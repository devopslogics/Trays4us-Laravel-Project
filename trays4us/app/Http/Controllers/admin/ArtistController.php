<?php

namespace App\Http\Controllers\admin;

use App\Models\Countries;
use App\Models\Helper;
use App\Models\Products;
use App\Models\States;
use Illuminate\Http\Request;
use App\Models\Artist;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Validator;
use Storage;
use DB;
use View;

class ArtistController extends Controller
{

    public function artist_listing(Request $request){
        $data = $request->all();
        $filter_flag = false;
        $pagination = optional(View::shared('site_management'))->backend_pagination_listing ?? 50;
        $artists = Artist::select('*')
            ->when(isset($data['search_by']), function ($query) use ($data, &$filter_flag) {
                $filter_flag = true;
                $query->where(function ($query) use ($data) {
                    $query->where('first_name', 'LIKE', '%' . $data['search_by'] . '%')
                        ->orWhere('artist_email', 'LIKE', '%' . $data['search_by'] . '%')
                        ->orWhere('company_name', 'LIKE', '%' . $data['search_by'] . '%');
                });
            })
            ->when(isset($data['status']), function ($query) use ($data, &$filter_flag) {
                $filter_flag = true;
                $status = is_array($data['status']) ? $data['status'] : [$data['status']];
                $query->whereIn('status', $status);
            }, function ($query) {
                $query->whereIn('status', [0, 1]);
            })
            ->orderBy('id', 'desc')
            ->paginate($pagination);


        return view('admin.artists.listing', compact('artists','filter_flag'));
    }

    public function generate_artist_slug() {
        $artists_qry = Artist::select('*');
        $artists = $artists_qry->get();
        foreach ($artists as $artist) {
            $display_name = filter_var($artist->display_name, FILTER_SANITIZE_STRING);
            $artist_slug = Artist::find($artist->id);
            $artist_slug->artist_slug = $this->createSlug($display_name);
            $artist_slug->save();
        }
    }

    public function add_artist(Request $request){
        $countries = Countries::getCountries();
        return view('admin.artists.add', compact('countries'));
    }

    public function add_artist_submitted(Request $request){
        //try {
            if ($request->IsMethod("post")) {
                $data = $request->all();
                $validator = Validator::make($data, [
                    //'company_name' => 'required',
                    'display_name' => 'required',
                    //'first_name' => 'required',
                   // 'last_name' => 'required',
                   // 'artist_phone' => 'required',
                    'artist_email' => 'required|email',
                    'artist_logo' => 'required|max:2048',
                    'description' => 'required',
                   // 'shiping_address1' => 'required',
                   // 'city' => 'required',
                  //  'postal_code' => 'required',
                  //  'country' => 'required',
                   // 'state' => 'required',
                ]);

                if ($validator->fails()) {

                    return response()->json([
                        'error' => $validator->errors()->all()
                    ]);

                }


                $artist = new Artist();
                $artist->first_name = $request->first_name ?? NULL;
                $artist->last_name = $request->last_name ?? NULL;
                $artist->display_name = $request->display_name ?? NULL;
                $artist_name = filter_var($request->display_name, FILTER_SANITIZE_STRING);
                $artist->artist_slug = $this->createSlug($artist_name);
                $artist->artist_email = $request->artist_email;
                $artist->artist_phone = $request->full_artist_phone ?? NULL;
                $artist->company_name = $request->company_name ?? '';
                $artist->description = $request->description;
                $artist->shiping_address1 = $request->shiping_address1 ?? NULL;
                $artist->shiping_address2 = $request->shiping_address2 ?? NULL;
                $artist->postal_code = $request->postal_code ?? NULL;
                $artist->city = $request->city ?? NULL;
                $artist->state_id = $request->state ?? NULL;
                $artist->country = $request->country ?? NULL;
                $artist->website = $request->input('website', '');
                $artist->is_feature = 0; //$request->input('is_feature', 0);
                $artist->is_visible = $request->input('is_visible', 0);
                $artist->status = 1;

                if($request->hasFile("artist_photo")) {
                    $artist_photo = $request->file("artist_photo");
                    $destinationPath =  base_path('uploads/users/');
                    $file_name = "artist-photo" . time() . "." . $artist_photo->getClientOriginalExtension();
                    $image_size = array(
                        'small' => array(
                            'width' => 200,
                            'height' => 150,
                        ),
                        'medium' => array(
                            'width' => 500,
                            'height' => 500,
                        )
                    );
                    Helper::uploadTempImageWithSize($destinationPath, $artist_photo, $file_name, $image_size);
                    $artist->artist_photo = $file_name;
                }

                if ($request->hasFile("artist_logo")) {
                    $artist_logo = $request->file("artist_logo");
                    $file_name = "artist-logo-" . time() . "." . $artist_logo->getClientOriginalExtension();
                    $destinationPath =  base_path('uploads/users/');
                    $image_size = array(
                        'small' => array(
                            'width' => 200,
                            'height' => 150,
                        ),
                        'medium' => array(
                            'width' => 300,
                            'height' => 225,
                        ),
                        'large' => array(
                            'width' => 500,
                            'height' => 500,
                        )
                    );
                    Helper::uploadTempImageWithSize($destinationPath, $artist_logo, $file_name, $image_size);
                    $artist->artist_logo = $file_name;
                }

                $artist->save();
                Session::flash('success', "Artist added successfully");
              //  return redirect(route('artists'))->with('success', "Artists Added");
                return response()->json([
                    'message' => 'Artists Added',
                    'class_name' => 'alert alert-success',
                    'status' => 'success',
                    'artist_id'=> $artist->id,
                    'redirect_url'=> route('artists'),
                ]);
            }
            /*
        }
        catch (ValidationException $e) {
                return redirect()->back()
                    ->withErrors($e->validator)
                    ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An unexpected error occurred');
        } */
    }

    function edit_artist(Request $request)
    {
        try {
            $data = $request->all();
            $id = $request->id;
            $artist = Artist::query()
                ->where('id', '=',  $id)
                ->first();
            $countries = Countries::getCountries();
            $states = States::where('country_id', $artist->country)->get();

            return view('admin/artists/edit', compact('artist','countries','states'));
        } catch (\Exception $exception) {
            return redirect(route('artists'))->withInput($request->all())->with('error', $exception->getMessage());
        }
    }

    public function edit_artist_submitted(Request $request){
        if($request->IsMethod("post")){

            $validator = Validator::make($request->all(), [
                //'company_name' => 'required',
                //'first_name' => 'required',
                // 'last_name' => 'required',
                'display_name' => 'required',
                'artist_email' => 'required',
                //'artist_phone' => 'required',
                'description' => 'required',
                //'shiping_address1' => 'required',
                // 'city' => 'required',
                // 'postal_code' => 'required',
                //'country' => 'required',
                // 'state' => 'required',
            ]);



            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->all()
                ]);
            }

            $id = $request->id;
            $artist = Artist::query()
                ->where('id', '=',  $id)
                ->first();

            $artist->first_name = $request->first_name ?? NULL;
            $artist->last_name = $request->last_name ?? NULL;
            $artist->display_name = $request->display_name ?? NULL;
            $artist->artist_email = $request->artist_email;
            $artist->artist_phone = $request->full_artist_phone ?? NULL;
            $artist->company_name = $request->company_name ?? '';
            $artist->description = $request->description;
            $artist->shiping_address1 = $request->shiping_address1 ?? NULL;
            $artist->shiping_address2 = $request->shiping_address2 ?? NULL;
            $artist->postal_code = $request->postal_code ?? NULL;
            $artist->city = $request->city ?? NULL;
            $artist->state_id = $request->state ?? NULL;
            $artist->country = $request->country ?? NULL;
            $artist->website = $request->website ?? '';
          //  $artist->is_feature = $request->is_feature ?? 0;
            $artist->is_visible = $request->input('is_visible') ?? 0;

            if($request->hasFile("artist_photo")) {
                $artist_photo = $request->file("artist_photo");
                $destinationPath =  base_path('uploads/users/');
                $file_name = "artist-photo" . time() . "." . $artist_photo->getClientOriginalExtension();
                $image_size = array(
                    'small' => array(
                        'width' => 200,
                        'height' => 150,
                    ),
                    'medium' => array(
                        'width' => 500,
                        'height' => 500,
                    )
                );
                Helper::uploadTempImageWithSize($destinationPath, $artist_photo, $file_name, $image_size);
                $artist->artist_photo = $file_name;
            }

            if ($request->hasFile("artist_logo")) {
                $artist_logo = $request->file("artist_logo");
                $file_name = "artist-logo-" . time() . "." . $artist_logo->getClientOriginalExtension();
                $destinationPath =  base_path('uploads/users/');
                $image_size = array(
                    'small' => array(
                        'width' => 322,
                        'height' => 90,
                    ),
                    'medium' => array(
                        'width' => 300,
                        'height' => 300,
                    ),
                    'large' => array(
                        'width' => 500,
                        'height' => 500,
                    )
                );
                Helper::uploadTempImageWithSize($destinationPath, $artist_logo, $file_name, $image_size);
                $artist->artist_logo = $file_name;
            }


            $artist->save();
            Session::flash('success', "Artist updated successfully");
            return response()->json([
                'message' => 'Artist Updated',
                'class_name' => 'alert alert-success',
                'status' => 'success',
                'artist_id'=> $id,
                'redirect_url'=> route('artists'),
            ]);
        }
    }

    function change_artist_status(Request $request)
    {
        $data = $request->all();
        $id = base64_decode($request->id);
        $sid = explode(":", $id)[0];
        $status = explode(":", $id)[1];

        $artist = Artist::query()
            ->select("id", "status")
            ->where("id", "=", $sid)
            ->first();
        $artist->status = $status;
        $artist->save();
        return redirect(route('artists'))->with('success', "Status Changed");
    }

    public function delete_artist_logo(Request $request){
        $id = $request->artist_id;
        $artist = Artist::query()
            ->where('id', '=',  $id)
            ->first();

        $artist->artist_logo = '';
        $artist->save();

        return response()->json([
            'message'   =>  'Artist updated',
            'class_name'  => 'alert alert-success',
            'status'  => 'success',
        ]);
    }

    public function delete_artist_photo(Request $request){

        $id = $request->artist_id;
        $artist = Artist::query()
            ->where('id', '=',  $id)
            ->first();

        $artist->artist_photo = '';
        $artist->save();

        return response()->json([
            'message'   =>  'Artist updated',
            'class_name'  => 'alert alert-success',
            'status'  => 'success',
        ]);
    }

    function sort_artist(Request $request)
    {
        $data = $request->all();
        $artist_sortings = Artist::select('*')
            ->where("status", "!=", 2)
            ->orderBY('sort_order')
            ->get();
        return view('admin/artists/sort-artist', compact('artist_sortings'));
    }

    function sort_artist_submitted(Request $request)
    {
        $data = $request->all();
        $sliders = $request->pass_array;
        foreach ($sliders as $key => $id) {
            Artist::query()->where('id','=',$id)->update(['sort_order' => $key]);
        }

        return response()->json([
            'message'   =>  'Successfully sorted',
            'class_name'  => 'alert alert-success',
            'status'  => 'success',
        ]);
    }

    function change_artist_visibility(Request $request)
    {
        $data = $request->all();
        $status = $request->status;
        $artist_id = $request->artist_id;
        Artist::query()->where('id','=',$artist_id)->update(['is_feature' => $status]);
        return response()->json([
            'message'   =>  'Successfully changed',
            'status'  => 'success',
        ]);
    }

    public function createSlug($title, $id = 0)
    {
        // Normalize the title
        $slug = Str::slug($title, '-');

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug, $id);

        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('artist_slug', $slug)){
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('artist_slug', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    function getRelatedSlugs($slug, $id = 0)
    {
        return Artist::select('artist_slug')->where('artist_slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }

}
