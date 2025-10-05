<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Customer;
use DateTime;

class SocialController extends Controller
{

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle the callback from Google
    public function handleGoogleCallback()
    {

        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $customer = Customer::where('provider_id', $googleUser->getId())->first();
            if ($customer) {
                $customer->otp = 1;
                Session::forget("is_customer");
                Session::put("is_customer", $customer);
                $intendedUrl = session()->pull('url.intended', '/products');
                return redirect()->to($intendedUrl);
            } else {

                $customer = Customer::where('email', $googleUser->getEmail())->first();
                if(!$customer) {
                    $customer = new Customer();
                    $customer->first_name = $googleUser->user['given_name'] ?? NULL;
                    $customer->last_name = $googleUser->user['family_name'] ?? NULL;
                    $givenName = $googleUser->user['given_name'] ?? '';
                    $familyName = $googleUser->user['family_name'] ?? '';
                    $customer->company = trim($givenName . ' ' . $familyName);
                    $customer->provider_id = $googleUser->getId();
                    $customer->provider_type = 1;
                    $customer->email = $googleUser->getEmail() ?? NULL;
                    $customer->password = Hash::make(uniqid());
                    $customer->save();
                } else {
                    $customer->provider_id = $googleUser->getId();
                    $customer->provider_type = 1;
                    $customer->save();
                }

                $customer->last_login = new DateTime();
                $customer->save();

                $customer->otp = 1;
                Session::forget("is_customer");
                Session::put("is_customer", $customer);
            }
            $intendedUrl = session()->pull('url.intended', '/products');
            return redirect()->to($intendedUrl);
        } catch (\Exception $e) {
            // Handle the error
            return redirect(route('sign-in'))->withErrors('Unable to login with Google. Please try again.');
        }
    }


    // Redirect to Facebook login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Handle the callback from Facebook
    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
            //print_r($facebookUser->getId());exit;
            $customer = Customer::where('provider_id', $facebookUser->getId())->first();

            //exit;
            if ($customer) {
                $customer->otp = 1;
                Session::forget("is_customer");
                Session::put("is_customer", $customer);
                $intendedUrl = session()->pull('url.intended', '/products');
                return redirect()->to($intendedUrl);
            } else {
                $customer = Customer::where('email', $facebookUser->getEmail())->first();
                $userFirstLastName = $this->getFirstLastNames($facebookUser->getName());
                if(!$customer) {

                    $customer = new Customer();
                    $customer->first_name = $userFirstLastName['first_name'];
                    $customer->last_name = $userFirstLastName['last_name'];

                    $first_name =  $userFirstLastName['first_name'] ?? '';
                    $last_name = $userFirstLastName['last_name'] ?? '';
                    $customer->company = trim($first_name . ' ' . $last_name);

                    $customer->provider_id = $facebookUser->getId();
                    $customer->provider_type = 2;
                    $customer->email = $facebookUser->getEmail() ?? NULL;
                    $customer->password = Hash::make(uniqid());
                    $customer->save();

                } else {
                    $customer->provider_id = $facebookUser->getId();
                    $customer->provider_type = 2;
                    $customer->save();
                }

                $customer->last_login = new DateTime();
                $customer->save();

                $customer->otp = 1;
                Session::forget("is_customer");
                Session::put("is_customer", $customer);
            }

            $intendedUrl = session()->pull('url.intended', '/products');
            return redirect()->to($intendedUrl);
        } catch (\Exception $e) {
            return redirect(route('sign-in'))->withErrors('Unable to login with facebook. Please try again.');
        }
    }

    protected function getFirstLastNames($fullName)
    {
        $parts = array_values(array_filter(explode(" ", $fullName)));

        $size = count($parts);

        if(empty($parts)){
            $result['first_name']   = NULL;
            $result['last_name']    = NULL;
        }

        if(!empty($parts) && $size == 1){
            $result['first_name']   = $parts[0];
            $result['last_name']    = NULL;
        }

        if(!empty($parts) && $size >= 2){
            $result['first_name']   = $parts[0];
            $result['last_name']    = $parts[1];
        }

        return $result;
    }

}
