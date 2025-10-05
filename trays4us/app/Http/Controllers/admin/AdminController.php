<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Badges;
use App\Models\Countries;
use App\Models\Orders;
use App\Models\ProductCustomizable;
use App\Models\Products;
use App\Models\Helper;
use App\Models\ProductStyle;
use App\Models\States;
use App\Models\Tags;
use App\Models\User;
use App\Models\WhitelistedIp;
use App\Models\SiteManagements;
use App\Imports\CustomerImportExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Storage;
use Response;
use Intervention\Image\Facades\Image;
use File;
use View;
use Mail;

class AdminController extends Controller
{
    //---------------------------------------------- General  ---------------------------------------

    public function admin()
    {
		return view('admin/users/signin');
    }

    public function admin_submitted(Request $request)
    {
        $data = $request->all();

        // Validate email and password input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Retrieve the admin user by email, ensuring their status is not '2' (deactivated)
        $info = User::query()
            ->where('email', $data['email'])
            ->where('status', '!=', '2')
            ->first();

        // If user not found or is deactivated, redirect back with error
        if (empty($info)) {
            return redirect(route('tfubacksecurelogin'))
                ->withInput($request->all())
                ->with('error', 'Email or Password is incorrect');
        }

        // If the password does not match, redirect back with error
        if (!Hash::check($data['password'], $info->password)) {
            return redirect(route('tfubacksecurelogin'))
                ->withInput($request->all())
                ->with('error', 'Email or Password is incorrect');
        }

        // Get the current IP address of the request
        $currentIP = $request->ip();

        // Check if the current IP is already whitelisted for the admin
        $isWhitelisted = WhitelistedIp::where('admin_id', $info->id)
            ->where('ip_address', $currentIP)
            ->exists();

        // If the IP is not whitelisted, trigger 2FA process
        if (!$isWhitelisted) {
            // Send the 2FA code to the admin (you should have a send2FACode method for this)
            $this->send2FACode($info, $currentIP);

            // Store necessary session variables for 2FA verification
            Session::put('pending_admin', $info);  // Admin details
            Session::put('new_ip', $currentIP);    // Current IP for verification

            // Redirect to the 2FA form
            return redirect()->route('show_2fa_Form');
        }

        // If the IP is whitelisted, log the admin in and redirect to dashboard
        Session::put('is_admin', $info);
        return redirect(route('admin-dashboard'));
    }

    public function send2FACode($user, $ip)
    {
        // Generate a 2FA code
        $code = rand(100000, 999999);

        // Save the code in session
        Session::put('2fa_code', $code);

        // Send 2FA code to the user via email
        Mail::send('emails.admin-2fa-code-whitelisted', ['code' => $code], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Your Two-Factor Authentication Code');
        });

        // Send an alert email to info@trays4.us about the login attempt
        Mail::send('emails.admin_login_alert', ['user' => $user, 'ip' => $ip, 'time' => now()], function ($message) {
            $message->to('sajidanwar2020@gmail.com')
                ->subject('Admin Login Attempt from New IP');
        });
    }

    public function show2faForm()
    {
        return view('admin.users.verify-2fa');
    }

    public function verify2fa(Request $request)
    {
        $request->validate([
            '2fa_code' => 'required|numeric',
        ]);

        // Check if the entered code matches the one stored in session
        if ($request->input('2fa_code') == session('2fa_code')) {
            // Retrieve the pending admin and new IP from session
            $admin = Session::get('pending_admin');
            $newIP = Session::get('new_ip');

            // Check if the new IP is already whitelisted for this admin
            $whitelistedIp = WhitelistedIp::where('admin_id', $admin->id)
                ->where('ip_address', $newIP)
                ->first();

            // If not, add the new IP to the whitelisted IPs table
            if (!$whitelistedIp) {
                WhitelistedIp::create([
                    'admin_id'   => $admin->id,
                    'ip_address' => $newIP,
                ]);
            }

            // Clear session data related to 2FA
            Session::forget(['2fa_code', 'pending_admin', 'new_ip']);

            // Log the admin in
            Session::put('is_admin', $admin);
            return redirect(route('admin-dashboard'));
        }

        // If the 2FA code is incorrect, return an error
        return redirect()->back()->with('error', 'The provided 2FA code is incorrect.');
    }


    public function site_setting()
    {
        $site_managements = SiteManagements::query()
            ->where('id', '=',  1)
            ->first();

        $badges =Badges::query()
            ->select("id", "badge")
            ->where('status', '=', 1)
            ->get();

        $staticOptions = collect([
            (object)['id' => '_1', 'badge' => 'Buyer purchased in the past for logged in'],
            (object)['id' => '_2', 'badge' => 'Same State Products for logged in']
        ]);

        // Merge static options with badges
        $sorting_orders = [
            'Badges' => $badges,
            'custom Sorting' => $staticOptions
        ];

        $artists = Artist::select('*')
            ->wherein("status", array(1))
            ->get();

        $themes = ProductStyle::select('*')
            ->wherein("status", array(1))
            ->get();

        $tags = Tags::select('*')
            ->where("status", 1)
            ->get();

        $customizables = ProductCustomizable::select('*')
            ->where("status", 1)
            ->get();

        $badges = Badges::select('*')
            ->where("status", 1)
            ->get();


        return view('admin/dashboard/site-setting', compact('site_managements','sorting_orders','artists','themes','customizables','badges',));
    }

    public function site_update(Request $request)
    {
        $data = $request->all();

        $this->validate($request, [
                'site_name' => 'required',
                'mobile_number' => 'required',
                'currency_symbol' => 'required',
            ]
        );

        //echo "<pre>";print_r($data);exit;

        $site_management = SiteManagements::where("id", "=", 1)->first();
        $site_management->site_name = $data['site_name'] ?? '';
        $site_management->mobile_number = $data['mobile_number'] ?? '';
        $site_management->currency = $data['currency_symbol'] ?? '';
        $site_management->address = $data['address'] ?? '';
        $site_management->city = $data['city'] ?? '';
        $site_management->state = $data['state'] ?? '';
        $site_management->zip_code = $data['zip_code'] ?? '';
        $site_management->enable_otp = $data['enable_otp'] ?? 0;
        $site_management->send_email = $data['send_email'] ?? 0;
        $site_management->pagination = $data['pagination'] ?? 30;
        $site_management->backend_pagination_listing = $data['backend_pagination_listing'] ?? 50;
        $site_management->email = $data['email'] ?? '';
        $site_management->estimated_ship_days = $data['estimated_ship_days'] ?? 0;
        $site_management->msrp_price = $data['msrp_price'] ?? 0;
        $site_management->minimum_order_amount = $data['minimum_order_amount'] ?? 0;
        $site_management->shipping_fee = $data['shipping_fee'] ?? 0;

        // Customizer fields

        $site_management->customizer_bedge = $data['customizer_bedge'] ?? 0;
        $site_management->customizer_artist_id = $data['customizer_artist_id'] ?? 0;
        $site_management->customizer_style_id = $data['customizer_style_id'] ?? 0;
        //$site_management->customizer_price = $data['customizer_price'] ?? 0;
        $site_management->customizer_minimums = $data['customizer_minimums'] ?? 0;


        $website_logo = $request->file("website_logo");

        if ($website_logo) {
            Storage::disk('uploads')->delete("users/{$site_management->website_logo}");
            $file_name = "website-logo-" . time() . "." . $website_logo->getClientOriginalExtension();
            $website_logo->move('uploads/users', $file_name);
            $site_management->website_logo = $file_name;
        }
        $fav_icon = $request->file("fav_icon");

        if ($fav_icon) {
            Storage::disk('uploads')->delete("users/{$site_management->fav_icon}");
            $file_name = "favicon-" . time() . "." . $fav_icon->getClientOriginalExtension();
            $fav_icon->move('uploads/users', $file_name);
            $site_management->fav_icon = $file_name;
        }
        //if (isset($data['sorting_order'])) {
            $site_management->display_order_value =  array_map('trim', explode(',', $data['sorting_order'])) ?? [];
        //}

        $site_management->save();

        return redirect(route('site-setting'))->with('success', "Setting Updated");
    }

    function profile(Request $request)
    {
        try {
            $data = $request->all();
            $is_admin = Session::get('is_admin');
            $user_info = User::query()
                ->where('id', '=',  $is_admin->id)
                ->first();
            return view('admin/users/update-profile', compact('user_info'));
        } catch (\Exception $exception) {
            return redirect(route('tfubacksecurelogin'))->withInput($request->all())->with('error', $exception->getMessage());
        }
    }

    public function profile_update(Request $request)
    {
        $data = $request->all();
        $is_admin = Session::get("is_admin");

        $this->validate($request, [
                'first_name' => 'required',
                'last_name' => 'required',
            ]
        );

        $profile = User::where("id", "=", $is_admin['id'])->first();
        $profile->first_name = isset($data['first_name']) ? $data['first_name'] : '';
        $profile->last_name = isset($data['last_name']) ? $data['last_name'] : '';



        if (!empty($request['photo'])) {
            $image = $request->file("photo");
            $destinationPath =  base_path('uploads/users/');
            $file_name =  "profile-" . $is_admin['id'] . "_" . time() .'.'.$image->extension();
            $image_size = array(
                'small' => array(
                    'width' => 200,
                    'height' => 150,
                ),
                'medium' => array(
                    'width' => 400,
                    'height' => 300,
                )
            );
            Helper::uploadTempImageWithSize($destinationPath, $image, $file_name, $image_size);
            $profile->photo = $file_name;
        }

        $profile->save();


           // Storage::disk('uploads')->delete("users/{$profile->photo}");
            //$file_name = "profile" . $is_admin['id'] . "_" . time() . "." . $image->getClientOriginalExtension();
           // $image->storeAs("users", $file_name, 'uploads');
            //$profile->photo = $file_name;

            /*
            $imageBasePath = public_path('uploads');
            echo $imageBasePath;exit;
            $uploadsRelativePath = config('filesystems.disks.uploads.root');
            echo $uploadsRelativePath;exit;
            $destinationPath = public_path('/uploads');
            print_r(Storage::disk('uploads'));exit; */

            /*
            $destinationPath =  base_path('uploads/users');
            $img = Image::make($image->path());
            $img->resize(200, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/small-'.$imagename);

            $small_img = Image::make($image);
            $small_img->fit(
                200,
                150,
                function ($constraint) {
                    $constraint->upsize();
                }
            );
            $small_img->save($destinationPath . '/small-2-' . $imagename);

            $image->storeAs("users", $imagename, 'uploads');
            */

        return redirect(route('profile'))->with('success', "Profile updated");
    }

    public function admin_dashboard()
    {
        $data['title'] = 'Dashboard';
        $data['breadcrums'] = 'Dashboard';
        $data['customers_count'] = Customer::where('status', '!=', 2)->count();
        $data['artists_count'] = Artist::where('status', '!=', 2)->count();
        $data['products_count'] = Products::where('status', '!=', 2)->count();
        $data['orders_count'] = Orders::count();
        return view('admin/dashboard/dashboard', $data);
    }

    //---------------------------------------------- Customer ---------------------------------------

    public function customer_listing(Request $request){
        $data = $request->all();
        $countries = Countries::getCountries();
        $pagination = optional(View::shared('site_management'))->backend_pagination_listing ?? 50;
        $filter_flag = 0;
        $customer_qry = Customer::select('customers.*', \DB::raw('SUM(cart.quantity) as cquantity'))
            ->leftJoin('cart', 'cart.customer_id', '=', 'customers.id')
            ->where(function ($query) use ($data, &$filter_flag) {
               if(isset($data['search_by']) && !empty($data['search_by'])) {
                   $filter_flag = 1;
                   $query->where(function ($query) use ($data) {
                       $query->whereRaw("concat(first_name, ' ', last_name) like '%" . $data['search_by'] . "%'");
                   })
                       ->orWhere('email', 'LIKE', '%' . $data['search_by'] . '%')
                       ->orWhere('city', 'LIKE', '%' . $data['search_by'] . '%');
               }
            })
            ->where(function ($query) use ($data, &$filter_flag) {
                $filter_flag = 1;
                if(isset( $data['country']) AND  $data['country'] > 0)
                    $query->where('country_id',$data['country']);

                if(isset( $data['state']) AND  $data['state'] > 0)
                    $query->where('state_id',$data['state']);
            })
            ->when(isset($data['cid']), function ($query) use ($data) {
                if(isset( $data['cid']) AND  $data['cid'] > 0)
                    $query->where('customers.id',$data['cid']);
            })
            ->when(isset($data['status']), function ($query) use ($data, &$filter_flag) {
                $filter_flag = 1;
                $status = is_array($data['status']) ? $data['status'] : [$data['status']];
                $query->whereIn('status', $status);
            }, function ($query) {
                $query->whereIn('status', [0, 1]);
            })
            ->groupBy('customers.id');

        if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'order_by_last_updated') {
            $customer_qry->orderBy('last_login', $data['order']);
        } else {
            $customer_qry->orderByDesc('cquantity');
        }

        $customers = $customer_qry->paginate($pagination);

        return view('admin.users.customer.listing', compact('customers','filter_flag','countries'));
    }

    public function add_customer(Request $request){
        $countries = Countries::getCountries();
        return view('admin.users.customer.add', compact('countries'));
    }

    public function add_customer_submitted(Request $request){
        if($request->IsMethod("post")){
            $data = $request->all();
            $this->validate($request, [
                //'first_name' => 'required|email',
                //'first_name' => 'required',
                //'last_name' => 'required',
                'company' => 'required',
                'email' => 'required|unique:customers,email',
                'password' => 'required',
                //'phone' => 'required',
                //'shiping_address1' => 'required',
                //'city' => 'required',
                //'postal_code' => 'required',
                //'country' => 'required',
                //'state' => 'required',
            ]);

            $customer = new Customer();
            $customer->first_name = $data['first_name'] ?? $data['company'];
            $customer->last_name = $data['last_name'];
            $customer->company = $data['company'];
            //$customer->customer_display_name = $data['customer_display_name'];
            $customer->email = $data['email'];
            $customer->password = Hash::make($data['password']);
            $customer->phone = $data['customer_full_phone'];
            $customer->shiping_address1 = $data['shiping_address1'];
            $customer->shiping_address2 = $data['shiping_address2'];
            $customer->postal_code = $data['postal_code'];
            $customer->country_id = $data['country'];
            $customer->state_id = $data['state'];
            $customer->city = $data['city'];
            $customer->is_verified = 1;
            $customer->website = $data['website'] ?? NULL;
            $customer->save();
            return redirect(route('customer'))->with('success', "Customer Added");
        }
    }

    function edit_customer(Request $request)
    {
        try {
            $data = $request->all();
            $id = $request->id;
            $countries = Countries::getCountries();
            $customer = Customer::query()
                ->where('id', '=',  $id)
                ->first();

            $countries = Countries::getCountries();
            $states = States::where('country_id', $customer->country_id)->get();

            return view('admin.users.customer.edit', compact('customer','countries','states'));
        } catch (\Exception $exception) {
            return redirect(route('customer'))->with('error', $exception->getMessage());
        }
    }

    public function edit_customer_submitted(Request $request){
        if($request->IsMethod("post")){
            $customer_id = $request->id;
            $this->validate($request, [
                //'first_name' => 'required|email',
                //'first_name' => 'required',
                //'last_name' => 'required',
                'company' => 'required',
                //'customer_display_name' => 'required',
                //'email' => 'unique:customers,email',
                'email' => [
                    'required',
                    Rule::unique('customers', 'email')->where(function ($query) use ($customer_id) {
                        $query->where('status', '!=', '2')->where('id', '!=', $customer_id);
                    }),
                ],
                //'phone' => 'required',
                //'shiping_address1' => 'required',
                //'city' => 'required',
                //'postal_code' => 'required',
                //'country' => 'required',
               // 'state' => 'required',
            ]);
            $data = $request->all();
            $id = $request->id;

            $customer = Customer::query()
                ->where('id', '=',  $id)
                ->first();

            $customer->first_name = $data['first_name'];
            $customer->last_name = $data['last_name'];
            $customer->company = $data['company'];
           // $customer->customer_display_name = $data['customer_display_name'];
            $customer->email = $data['email'];
            $customer->phone = $data['customer_full_phone'];
            $customer->website = $data['website'];
            $customer->shiping_address1 = $data['shiping_address1'];
            $customer->shiping_address2 = $data['shiping_address2'];
            $customer->postal_code = $data['postal_code'];
            $customer->country_id = $data['country'];
            $customer->state_id = $data['state'];
            $customer->city = $data['city'];

            $customer->is_verified = 1;
            $customer->save();

            return redirect(route('customer'))->with('success', "Customer updated");
        }
    }

    function change_customer_status(Request $request)
    {
        $data = $request->all();
        $id = base64_decode($request->id);
        $sid = explode(":", $id)[0];
        $status = explode(":", $id)[1];

        $customer = Customer::query()
            ->select("id", "status")
            ->where("id", "=", $sid)
            ->first();
        $customer->status = $status;
        $customer->save();
        return redirect(route('customer'))->with('success', "Status Changed");
    }

    public function download_customer_csv(Request $request){

        $filename = 'customer_data_' . date('Y-m-d_H-i-s') . '.csv';

        $customers = Customer::select('*')
            ->whereIn('status', [0, 1])
            ->orderBy('id', 'desc')
            ->paginate(10);

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $columns = array('First Name', 'Last Name', 'Email', 'Phone#', 'Zipcode', 'Country', 'State', 'City', 'Shiping Address 1', 'Shiping Address 2', 'Company', 'Website', 'Created At');

        $callback = function() use($customers, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($customers as $customer) {
                $row['first_name']  = $customer->first_name;
                $row['last_name']    = $customer->last_name;
                $row['email']    = $customer->email;
                $row['phone']  = $customer->phone;
                $row['postal_code']  = $customer->postal_code;
                $row['country_id']  = $customer->country->country_name ?? '';
                $row['state_id']  =  $customer->state->state_name ?? '';
                $row['city']  = $customer->city;
                $row['shiping_address1']  = $customer->shiping_address1;
                $row['shiping_address2']  = $customer->shiping_address2;
                $row['company']  = $customer->company;
                $row['website']  = $customer->website;
                $row['created_at']  = $customer->created_at;
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import_customers(Request $request){
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'import_customer' => 'required|file|mimes:xls,xlsx',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ], 422);
        }


        // Get the uploaded file
        $file = $request->file('import_customer');
        $import = new CustomerImportExcel();
        // Process the Excel file
        Excel::import(new $import, $file);
        // echo $import->getInsertedCount();exit;
        Session::flash('success','File uploaded successfully');
        return response()->json(['status' => 'success','message' => 'File uploaded successfully'],200);
        //return redirect('/')->with('success', 'Import successful! Total records inserted: ' . $import->getInsertedCount());
    }

    //------------------------------------------ Countries -----------------------------------------

    public function all_countries(Request $request){
        $data = $request->all();
        $pagination = optional(View::shared('site_management'))->backend_pagination_listing ?? 50;
        $filter_flag = false;
        $country_qry = Countries::select('*')
            // ->whereIn('status', [0, 1])
            ->when(isset($data['search_by']), function ($query) use ($data, &$filter_flag) {
                $filter_flag = true;
                $query->where(function ($query) use ($data) {
                    $query->where('country_code', 'LIKE', '%' . $data['search_by'] . '%')
                        ->orWhere('country_name', 'LIKE', '%' . $data['search_by'] . '%');
                });
            })
            ->when(isset($data['status']), function ($query) use ($data, &$filter_flag) {
                $filter_flag = true;
                $status = is_array($data['status']) ? $data['status'] : [$data['status']];
                $query->whereIn('status', $status);
            }, function ($query) {
                $query->whereIn('status', [0, 1]);
            })
            ->orderBy('status', 'DESC')
            ->paginate($pagination);

        $countries = $country_qry;

        return view('admin.countries.listing', compact('countries','filter_flag'));
    }

    function change_country_status(Request $request)
    {
        $data = $request->all();
        $id = base64_decode($request->id);
        $sid = explode(":", $id)[0];
        $status = explode(":", $id)[1];

        $country = Countries::query()
            ->select("id", "status")
            ->where("id", "=", $sid)
            ->first();
        $country->status = $status;
        $country->save();
        return redirect(route('all-countries'))->with('success', "Status Changed");
    }

    //----------------------------------------  States ---------------------------------------------


    public function all_states_listings(Request $request){
        $data = $request->all();
        $pagination = optional(View::shared('site_management'))->backend_pagination_listing ?? 50;
        $filter_flag = false;
        $states_qry = States::select('*')
            ->whereIn('status', [0, 1])
            ->where('country_id', $data['cid'])
            ->when(isset($data['search_by']), function ($query) use ($data, &$filter_flag) {
                $filter_flag = true;
                $query->where(function ($query) use ($data) {
                    $query->where('state_name', 'LIKE', '%' . $data['search_by'] . '%');
                });
            })
            ->orderBy('state_name', 'ASC')
            ->paginate($pagination);

        $states = $states_qry;

        return view('admin.countries.state.listing', compact('states','filter_flag'));

    }

    public function add_state(Request $request){
        return view('admin.countries.state.add');
    }

    public function add_state_submitted(Request $request){
        if($request->IsMethod("post")){

            $validated = $request->validate([
                'slider_title' => 'required',
                'slider_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=1200,min_height=400',
            ]);


            $homepageSlider = new HomepageSlider();
            $homepageSlider->slider_title = $request->slider_title;

            $homepageSlider->status = 1;
            $homepageSlider->save();
            return redirect(route('homepage-slider'))->with('success', "Homepage slider Added");
        }
    }

    function edit_state(Request $request)
    {
        try {
            $data = $request->all();
            $id = $request->id;
            $state = States::query()
                ->where('id', '=',  $id)
                ->first();
            return view('admin.countries.state.edit', compact('state'));
        } catch (\Exception $exception) {
            return redirect(route('tfubacksecurelogin'))->withInput($request->all())->with('error', $exception->getMessage());
        }
    }

    public function edit_state_submitted(Request $request){
        if($request->IsMethod("post")){
            $validated = $request->validate([
                'state_name' => 'required',
            ]);

            $id = $request->state_id;
            $state = States::query()
                ->where('id', '=',  $id)
                ->first();

            $state->state_name = $request->state_name;
            $state->save();
            return back()->with('success', "States updated");
        }
    }

    function change_state_status(Request $request)
    {
        $data = $request->all();
        $id = base64_decode($request->id);
        $cid = explode(":", $id)[0];
        $status = explode(":", $id)[1];

        if ($status == 1) {
            $state = States::query()
                ->select("id", "status")
                ->where("id", "=", $cid)
                ->first();
            $state->status = $status;
            $state->save();
            return back()->with('success', "Status Changed");

        } else if ($status == 0) {
            $state = States::query()
                ->select("id", "status")
                ->where("id", "=", $cid)
                ->first();
            $state->status = $status;
            $state->save();
            return back()->with('success', "Status Changed");
        } else if ($status == 2) {
            $state = States::query()
                ->select("id", "status")
                ->where("id", "=", $cid)
                ->first();
            $state->status = $status;
            $state->save();
            return back()->with('success', "Status Changed");
        }

    }

    //---------------------------------- Change Password ------------------------------------------

    function change_password()
    {
        return view('admin/users/change_password');
    }

    function change_password_save(Request $request)
    {
        $data = $request->all();

        $this->validate($request, [
            //'first_name' => 'required|email',
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $is_admin = Session::get('is_admin');
        $user_info = User::query()
            ->where('id', '=',  $is_admin->id)
            ->first();

        if ($user_info && Hash::check($data['current_password'], $user_info->password)) {
            $user_info->password = Hash::make($data['password']);
            $user_info->save();
            return redirect(route('profile'))->with('success', 'Your password has been changed successfully');
        } else {
            return redirect(route('change-password'))->with('error', "Current Password is inccorect");
        }
    }

    //----------------------------------------------------------------------------------------------

    function admin_logout()
    {
        \session(['is_admin' => null]);
        return redirect(route('tfubacksecurelogin'));
    }

}
