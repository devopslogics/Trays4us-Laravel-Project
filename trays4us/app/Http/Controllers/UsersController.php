<?php

namespace App\Http\Controllers;

use App\Mail\Registration;
use App\Models\Countries;
use App\Models\Customer;
use App\Models\States;
use App\Models\User;
use App\Models\SiteManagements;
use Cassandra\Custom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use DateTime;

class UsersController extends Controller
{

    public function restrictAccess(Request $request)
    {
        echo "hereeeeeeeeeee";exit;
        \Log::info('Accessed restrictAccess route', ['file' => $request->query('file')]);
    }

    public function verify_otp()
    {
        return view('frontend/customers/verify-2fa');
    }

    public function verify_otp_ajax(Request $request)
    {
        // get all request params.
        $data = $request->all();
        $is_customer = Session::get("is_customer");

        $rules = ['otp' => 'integer|required'];
        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 403,
                'response' => 'Otp is required or it must be an integer.',
            ]);
        }

        $user_data = Customer::get_user($data['customer_id']);


        if ($user_data && ($data['otp'] == $user_data->two_factor_code)) {

            // reset two factor code.
            Customer::reset_two_factor_code($user_data->id);

            // unset otp in admin session.
            if (isset($is_customer) && $is_customer['otp'] == 1) {
                unset($is_customer->otp);
                // \Session::put("is_admin", $is_admin);
            }

            // redirect to admin dashboard.
            return response()->json([
                'status' => 200,
                'response' => ''
            ]);
        }

        return response()->json([
            'status' => 403,
            'response' => 'The two factor code you have entered does not match or expired.'
        ]);
    }

    public function resend_otp_ajax(Request $request)
    {
        // get all request params.
        $data = $request->all();

        if (isset($data['customer_id'])) {

            $customer = Customer::get_user($data['customer_id']);

            if ($customer) {

                $two_factor_code = Customer::generate_two_factor_code($data['customer_id']);
                //Customer::send_twofactorcode_via_email($customer->email, $two_factor_code);

                $email = $email ?? "sajidanwar2020@gmail.com";

                $subject = "Trays4Us - Your one-time password";
                $data = ['code' => $two_factor_code,'info' => $customer];

                $message =  view('emails.two-factor-verify-email',$data)->render();
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: no-reply@tray4us.com' . "\r\n";
                mail($email,$subject,$message,$headers);

                return response()->json([
                    'status' => 200,
                    'response' => 'The two factor code has been sent again.'
                ]);

            } else {
                return response()->json([
                    'status' => 200,
                    'response' => 'Unable to find the user.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 200,
                'response' => 'Something went wrong.'
            ]);
        }
    }

    function signin()
    {
        $page_title = 'Sign In';
        $page_description = '';
        return view('frontend/customers/signin', compact('page_title','page_description'));
    }

    public function signin_submitted(Request $request)
    {
        // validation.
        $this->validate($request, [
            'email' => [
                'required',
                'email',
            ],
            'password' => 'required'
        ]);

        $data = $request->all();
        $email = $data['email'] ?? '';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()
                ->back()
                ->withErrors(['error' => __("The email address is invalid or does not contain a dot in the domain.")])
                ->withInput();
        }

        $customer = Customer::where(['email' => $email])->first();

        // Check if the user exists and verify the password.
        if ($customer && Hash::check($data['password'], $customer->password)) {

            if (isset($customer->is_verified) && $customer->is_verified == 0) {
                return \Redirect::back()->withErrors(['error' => __("Please check your email to activate your account first")])->withInput();
            }

            if (isset($customer->status) && $customer->status == 2) {
                return \Redirect::back()->withErrors(['error' => __("Your account has been deleted. Please contact with support.")])->withInput();
            }

            $customer->otp = 1;
            Session::forget("is_customer");
            Session::put("is_customer", $customer);

            //----------------------------- Custom last login ----------------------------------------------------

            $customer_last_login = Customer::find($customer->id);
            $customer_last_login->last_login = new DateTime();
            $customer_last_login->save();

            //-----------------------------------------------------------------------------------------------------

            $siteManagement  = SiteManagements::getSiteManagment();

            if (isset($siteManagement->enable_otp) AND $siteManagement->enable_otp == 1) {
                //print_r($siteManagement);exit;
                $two_factor_code = Customer::generate_two_factor_code($customer->id);
                //print_r($two_factor_code);exit;
               // Customer::send_twofactorcode_via_email($email, $two_factor_code);

                $from_email = env('MAIL_FROM_ADDRESS');
                $headers = array('From' => $from_email, 'Reply-To' => $from_email, 'X-Mailer' => 'PHP/' . phpversion());

                $email = $email ?? "sajidanwar2020@gmail.com";

                $subject = "Trays4Us - Your one-time password";
                $data = ['code' => $two_factor_code ,'info' => $customer];

                try {
                    /*
                    Mail::send('emails.two-factor-verify-email', $data, function ($message) use ($email) {
                        $message->to('sajidanwar2020@gmail.com');
                        $message->subject('Trays4us - Verify OTP code');
                    }); */

                    $message =  view('emails.two-factor-verify-email',$data)->render();
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= 'From: no-reply@tray4us.com' . "\r\n";
                    mail($email,$subject,$message,$headers);

                    return redirect('/verify-otp');
                } catch (\Exception $e) {
                    Log::error('Error sending test email: ' . $e->getMessage());
                }
            } else {
                $intendedUrl = session()->pull('url.intended', '/products');
                return redirect()->to($intendedUrl);
            }

        }
        //echo "hereeee";exit;
        return \Redirect::back()->withErrors(['error' => __("Email or password incorrect. Try again.")])->withInput();

    }

    public function customer_signup()
    {
        $page_title = 'Sign Up';
        $page_description = '';
        if (Session::has('is_customer') && !empty(Session::get('is_customer'))) {
            return redirect(route('home'));
        }
        $countries = Countries::getCountries();
        return view('frontend/customers/signup', compact('countries','page_title','page_description'));
    }

    public function customer_signup_submitted(Request $request)
    {
        $data = $request->all();
        $siteManagement  = SiteManagements::getSiteManagment();
        $this->validate($request, [
            'company' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            //'customer_display_name' => 'required',
            'shiping_address1' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
            'state' => 'required',
            'phone' => 'required',
            'email' => [
                'required',
                'email',
                'unique:customers,email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',
            ],
            'password' => 'required|min:6|confirmed',
        ]);
        $customer = new Customer();
        $customer->first_name = $data['first_name'];
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
        if (isset($siteManagement->send_email) AND $siteManagement->send_email == 1) {
            $customer->is_verified =0;
            $code = mt_rand(100000, 999999);
            $customer->verification_code = $code;
        }

        $customer->save();

        if (isset($siteManagement->send_email) AND $siteManagement->send_email == 1) {
            if(isset($data['state']) AND $data['state'] > 0) {
                $state = States::find($data['state']);
                $customer->state_name = $state->state_name;
            }

            Customer::send_registration_email($customer, $siteManagement);
            return redirect(route('sign-in'))->with('success', 'Please check your email to complete registration process');
        } else {
            return redirect(route('sign-in'))->with('success', 'Congratulations! You have successfully registered');
        }


    }

    function customer_signup_verification(Request $request)
    {
        $is_already_registered = 0;
        $data = $request->all();
        $token = base64_decode($data['token']);
        $info = explode(":", $token);

        $email = isset($info[0]) ? $info[0] : '';
        $code = isset($info[1]) ? $info[1] : '';

        // email exist and not deleted.
        $exists = DB::table("customers as u")
            ->select("u.id", 'u.email')
            ->where("u.email", "=", $email)
            ->where("u.is_verified", "=", 1) // not deleted already.
            ->first();

        // check user invites.
        $user_invites = Customer::query()
            ->select('*')
            ->where('email', '=', $email)
            ->where('verification_code', '=', $code)
            ->where('is_verified', '=', "0")
            ->first();

        // check if already exists.
        if (!empty($exists)) {
            $is_already_registered = 1;
        }

        if (!empty($user_invites) && $is_already_registered == "0") {
            $user_invites->is_verified = 1;
            $user_invites->verification_code = NULL;
            $user_invites->save();
            return redirect(route('sign-in'))->with('success', 'Registration completed now you can login');
        }
        return redirect(route('sign-in'))->with('error', 'Invite expired');
    }

    //------------------------------------------------------------------------------------------------------------

    function profile()
    {
        $customer = Session::get('is_customer');
        $customer_id = $customer['id'];
        $customer_detail = Customer::select('*')->where(['id' => $customer_id])->first();
        $data['countries']  = $countries = Countries::getCountries();
        $country_id = $countries[0]['id'] ?? 231;
        $data['states'] = States::where('country_id', $country_id)->get();
        $data['customer_detail'] = $customer_detail;
        $data['page_title'] = 'Profile';
        $data['page_description'] = '';
        return view('frontend/customers/profile', $data);
    }

    function profile_update_save(Request $request)
    {
        $data = $request->all();
        $this->validate($request, [
            //'first_name' => 'required|email',
            'company' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            //'customer_display_name' => 'required',
            'shiping_address1' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
            'city' => 'required',
            'state' => 'required',
            'phone' => 'required',
        ]);
      //  print_r($data);exit;
        $customer = Session::get("is_customer");
        $profile = Customer::where("id", "=", $customer['id'])->first();
        $profile->first_name = $data['first_name'];
        $profile->last_name = $data['last_name'];
        //$profile->customer_display_name = $data['customer_display_name'];
        $profile->shiping_address1 = $data['shiping_address1'];
        $profile->shiping_address2 = $data['shiping_address2'];
        $profile->company = $data['company'];
        $profile->phone = $data['customer_full_phone'];
        $profile->postal_code = $data['postal_code'];
        $profile->country_id = $data['country'];
        $profile->city = $data['city'];
        $profile->state_id = $data['state'];
        $profile->save();

        $profile->otp = 1;
        Session::forget("is_customer");
        Session::put("is_customer", $profile);

        return redirect($data['previous_url'])->with('success', "Updated profile");
    }

    function change_password()
    {
        $customer = Session::get('is_customer');
        $customer_id = $customer['id'];
        $customer_detail = Customer::select('*')->where(['id' => $customer_id])->first();
        $data['customer_detail'] = $customer_detail;
        $data['page_title'] = 'Change Password';
        $data['page_description'] = '';
        return view('frontend/customers/change-password', $data);
    }

    function change_password_save(Request $request)
    {
        $data = $request->all();

        $this->validate($request, [
            //'first_name' => 'required|email',
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $customer = Session::get("is_customer");
        $customer = Customer::where("id", "=", $customer['id'])->first();

        if ($customer && Hash::check($data['current_password'], $customer->password)) {
            $customer->password = Hash::make($data['password']);
            $customer->save();
            return redirect(route('change-password'))->with('success', 'Your password has been changed successfully');
        } else {
            return redirect(route('change-password'))->with('error', "Current Password is inccorect");
        }
    }

    //------------------------------------------------------------------------------------------------------------

    function my_account()
    {
        $customer = Session::get('is_customer');
        $customer_id = $customer['id'];
        $customer_detail = Customer::select('*')->where(['id' => $customer_id])->first();
        $data['countries'] = Countries::getCountries();
        $data['states'] = States::where('country_id', $customer_detail->country_id)->get();
        $data['customer_detail'] = $customer_detail;
        $data['page_title'] = 'My Account';
        $data['page_description'] = '';
        return view('frontend/my-account/my-account', $data);
    }

    function forgot_password_customer(Request $request)
    {
        $email = $request->email;
        $customer = Customer::select("id", "password", 'first_name','last_name', 'verification_code')
            ->where(['email' => $email])
            ->first();

        if (!empty($customer)) {
            $code = mt_rand(100000, 999999);
            $customer->verification_code = $code;
            $customer->save();

            $url = 'reset_password';
            $token = base64_encode($email . ':' . $code);

            $forgot_arr['token'] = $token;
            $info = array(
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'full_name' => $customer->full_name,
                'link' => route($url, $forgot_arr),
                'logo' => ''

            );
            Customer::send_forget_password_email($email, $info);
            return 1;
        }
        return "No such email are found.";
    }

    function reset_password(Request $request)
    {
        $data = $request->all();
        return view('frontend/customers/reset_password', $data);
    }

    public function reset_update_password(Request $request)
    {
        $data = $request->all();
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $info = base64_decode($data['token']);

        $info = explode(":", $info);
        $email = $info[0];
        $code = $info[1];

        if ($email != '' && $code != '') {
            $user = Customer::select("id", "password", 'verification_code')
                ->where(['email' => $email, 'verification_code' => $code])
                ->first();

            if (empty($user)) {
                return redirect(route('reset_password', ['token' => $data['token']]))->with('error', 'Sorry your password reset link is expired');
            } else {
                $password = Hash::make($data['password']);
                $user->password = $password;
                $user->verification_code = '';
                if ($user->save()) {
                    return redirect(route('sign-in'))->with('success', 'Your password has been changed successfully');
                } else {
                    return redirect(route('reset_password', ['token' => $data['token']]))->with('error', 'Opps something went wrong');
                }
            }
        } else {
            return redirect(route('reset_password', ['token' => $data['token']]));
        }
    }

    public function logout(Request $request)
    {
        $redirect_url = route('sign-in');
        $adasd = Session::get("is_customer");
        Session::forget('is_customer');
        $request->session()->flush();
        return redirect($redirect_url);
    }

}
