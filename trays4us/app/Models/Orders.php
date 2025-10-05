<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public static function send_order_status_email($order)
    {
       // $from_email = 'info@trays4.us'; //env('MAIL_FROM_ADDRESS');
        $from_email = env('MAIL_FROM_ADDRESS');
        $subject = "Trays4Us -Order status changed";
        $data['order'] = $order;
        try {
            // Customer Email
            $customer_email = $order->customer->email;
            \Mail::send('emails.order-status-changed', $data, function ($message) use ($customer_email, $subject, $from_email) {
                $message->to($customer_email, env('MAIL_FROM_NAME'))->subject($subject);
                $message->from($from_email, env('MAIL_FROM_ADDRESS'));
            });

            // Admin Email
            $data['is_admin_email'] = true;
            $siteManagement  = SiteManagements::getSiteManagment();
            $admin_email = $siteManagement->email;
            \Mail::send('emails.order-status-changed', $data, function ($message) use ($admin_email, $subject, $from_email) {
                $message->to($admin_email, env('MAIL_FROM_NAME'))->subject($subject);
                $message->from($from_email, env('MAIL_FROM_ADDRESS'));
            });

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public static function send_order_changes_email_to_customer($order)
    {
        //$from_email = 'info@trays4.us'; //env('MAIL_FROM_ADDRESS');
        $from_email = env('MAIL_FROM_ADDRESS');
        $subject = "Trays4Us - Order #".$order->order_number." has been revised";
        $data['order'] = $order;
        try {

            // Customer Email
            $customer_email = $order->customer->email;
            \Mail::send('emails.order-changes-by-admin-inform-customer', $data, function ($message) use ($customer_email, $subject, $from_email) {
                $message->to($customer_email, env('MAIL_FROM_NAME'))->subject($subject);
                $message->from($from_email, env('MAIL_FROM_ADDRESS'));
            });

            // Admin Email
            $data['is_admin_email'] = true;
            $siteManagement  = SiteManagements::getSiteManagment();
            $admin_email = $siteManagement->email;
            \Mail::send('emails.order-changes-by-admin-inform-customer', $data, function ($message) use ($admin_email, $subject, $from_email) {
                $message->to($admin_email, env('MAIL_FROM_NAME'))->subject($subject);
                $message->from($from_email, env('MAIL_FROM_ADDRESS'));
            });

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public static function order_notification_to_customer($order)
    {
       //$from_email = 'info@trays4.us'; //env('MAIL_FROM_ADDRESS');
        $from_email = env('MAIL_FROM_ADDRESS');
        // print_r($order);exit;
        $subject = "Trays4Us - New Order";
        $data['order'] = $order;
        try {
            $customer_email = $order->customer->email;
            \Mail::send('emails.order-created-detail', $data, function ($message) use ($customer_email, $subject, $from_email) {
                $message->to($customer_email, env('MAIL_FROM_NAME'))->subject($subject);
                $message->from($from_email, env('MAIL_FROM_ADDRESS'));
            });


        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public static function order_notification_to_admin($order)
    {
        //$from_email = 'info@trays4.us'; //env('MAIL_FROM_ADDRESS');
        $from_email = env('MAIL_FROM_ADDRESS');
        $siteManagement  = SiteManagements::getSiteManagment();
        $admin_email = $siteManagement->email;
        $subject = "Trays4Us - #".$order->order_number." New Order";
        $data['order'] = $order;
        $data['is_admin_email'] = true;
        try {

            \Mail::send('emails.order-created-detail', $data, function ($message) use ($admin_email, $subject, $from_email) {
                $message->to($admin_email, env('MAIL_FROM_NAME'))->subject($subject);
                $message->from($from_email, env('MAIL_FROM_ADDRESS'));
            });

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

}
