<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\SiteManagements;

class Customer extends Model
{
    protected $table = 'customers';

    public static function generate_two_factor_code($customer_id = 0)
    {
        if ($customer_id != 0) {
            $code = rand(1000, 9999);
            Customer::where('id', $customer_id)->update(
                [
                    'two_factor_code' => $code
                ]
            );
            return $code;
        }
    }

    public static function reset_two_factor_code($customer_id)
    {
        $user_code = Customer::where('id', $customer_id)->first();

        if ($user_code) {
            $user_code->two_factor_code = null;
            $user_code->save();
        }
    }

    public static function get_user($customer_id)
    {
        $customer = Customer::where('id', $customer_id)->first();
        if ($customer) {
            return $customer;
        }
        return false;
    }

    public static function send_twofactorcode_via_email($email = "", $code = "")
    {
        $from_email = env('MAIL_FROM_ADDRESS');
        $headers = array('From' => $from_email, 'Reply-To' => $from_email, 'X-Mailer' => 'PHP/' . phpversion());

        $email = $email ?? "sajidanwar2020@gmail.com";

        $subject = "Trays4us - Verify OTP code";
        $data = ['code' => $code];

        try {
            // send email to hamza
            \Mail::send('emails.two-factor-verify-email', $data, function ($message) use ($email, $subject, $from_email) {
                $message->to($email, env('MAIL_FROM_NAME'))->subject($subject);
                $message->from($from_email, env('MAIL_FROM_ADDRESS'));
            });

            if (count(Mail::failures()) > 0) {
                return false;
            } else {
                return true;
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public static function send_forget_password_email($email = "",$info)
    {
        $from_email = env('MAIL_FROM_ADDRESS');
        $headers = array('From' => $from_email, 'Reply-To' => $from_email, 'X-Mailer' => 'PHP/' . phpversion());

        $email = $email ?? "sajidanwar2020@gmail.com";

        $subject = "Trays4Us - Reset Your Password";
        $data = ['info' => $info];

        try {

            $message =  view('emails.forgot_password',$data)->render();
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: no-reply@tray4us.com' . "\r\n";

            mail($email,$subject,$message,$headers);


            /*
            // send email to hamza
            \Mail::send('emails.forgot_password', $data, function ($message) use ($email, $subject, $from_email) {
                $message->to($email, env('MAIL_FROM_NAME'))->subject($subject);
                $message->from($from_email, env('MAIL_FROM_ADDRESS'));
            });
            return true;
            */
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public static function send_registration_email($customer = "",$setting)
    {
        $from_email = env('MAIL_FROM_ADDRESS');
        $headers = array('From' => $from_email, 'Reply-To' => $from_email, 'X-Mailer' => 'PHP/' . phpversion());

        $email =  $customer->email ?? "sajidanwar2020@gmail.com";
        $verification_code = $customer->verification_code;

        $subject = "Trays4us - Registration verification";

        $url = 'customer-signup-verification';
        $token = base64_encode($email . ':' . $verification_code);

        $forgot_arr['token'] = $token;

        $info = array(
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'email' => $customer->email,
            'link' => route($url, $forgot_arr),
            'logo' => ''
        );

        $data = ['info' => $info,'customer' => $customer ];

        /*
        $message =  view('emails.registration',$data)->render();
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: no-reply@tray4us.com' . "\r\n";

        mail($email,$subject,$message,$headers);

        // Send email to admin
        $message =  view('emails.admin-email-registration',$data)->render();
        Log::info('Before admin email');
        $siteManagement  = SiteManagements::getSiteManagment();
        if(isset($siteManagement->email) AND !empty($siteManagement->email)) {
            Log::info('Admin email sent');
            Log::info($siteManagement->email);
            mail($siteManagement->email,'Trays4us - User Sign up',$message,$headers);
        }
        */


        \Mail::send('emails.registration', $data, function ($message) use ($email) {
            $message->to($email);
            $message->subject('Trays4us - Registration verification');
        });


        Log::info('Before admin email');
        $siteManagement  = SiteManagements::getSiteManagment();
        if(isset($siteManagement->email) AND !empty($siteManagement->email)) {
            Log::info('Admin email sent');
            Log::info($siteManagement->email);

            $email_admin = $siteManagement->email;
            $subject = "Trays4us - User Sign up";
            \Mail::send('emails.admin-email-registration', $data, function ($message) use ($email_admin, $subject, $from_email) {
                $message->to($email_admin, env('MAIL_FROM_NAME'))->subject($subject);
                $message->from($from_email, env('MAIL_FROM_ADDRESS'));
            });
        }


    }

    public function country()
    {
        return $this->belongsTo(Countries::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(States::class, 'state_id');
    }
}
