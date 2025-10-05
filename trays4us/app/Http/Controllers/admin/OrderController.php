<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Products;
use App\Models\User;
use App\Models\Orders;
use App\Models\Cart;
use App\Traits\Definations;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use DB;
use Storage;
use View;

class OrderController extends Controller
{
    public function all_orders(Request $request)
    {
        $data = $request->all();
        $filter_flag = false;
        $pagination = optional(View::shared('site_management'))->backend_pagination_listing ?? 50;
        $orders = Orders::with('orderItems', 'customer')
            ->select('*')
            ->when(isset($data['status']), function ($query) use ($data, &$filter_flag) {
                $filter_flag = true;
                return $query->where('orders.status', '=', $data['status']);
            })
            ->when(isset($data['search_by']), function ($query) use ($data, &$filter_flag) {
                $filter_flag = true;
                $query->where(function ($query) use ($data) {
                    $query->where('orders.order_number', 'LIKE', '%' . $data['search_by'] . '%');
                });
            })
            ->orderBy('orders.id', 'desc')
            ->paginate($pagination);

        return view('admin/orders/all-orders', compact('orders','filter_flag'));
    }

    /*
    function order_item_detail(Request $request)
    {
        $data = $request->all();
        $order_id = $data['order_id'];
        $order = Orders::find($order_id);
        $view = view('admin/orders/ajax-item-detail', compact('order'))->render();
        return response()->json(['html' => $view]);
    }
    */

    function edit_order(Request $request,$order_id)
    {
        $data = $request->all();
        $order = Orders::find($order_id);
        return view('admin/orders/edit-order', compact('order'));
    }

    public function edit_order_submitted(Request $request){

        $data = $request->all();
       // echo "<pre>";print_r($data);exit;
        $validator = Validator::make($data, [
            //'company_name' => 'required',
            //'order_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $order_id = $request->order_id;
        $order = Orders::findOrFail($order_id);

        $before_save_estimated_ship_date = $order->estimated_ship_date;
        $before_save_shipping_cost = $order->shipping_cost;

        $new_estimatedShipDate = Carbon::createFromFormat('m/d/Y', $data['estimated_ship_date'])->format('Y-m-d');
        $order->estimated_ship_date = $new_estimatedShipDate;
        $order->shipping_cost = $data['shipping_cost'] ?? 0.00;
        $order->quick_book_link = $data['quick_book_link'] ?? null;
        $order->tracking_id = $data['tracking_id'] ?? null;
        $order->save();

        $order->shipment_date_change = $before_save_estimated_ship_date != $new_estimatedShipDate;
        $order->shipment_cost = $before_save_shipping_cost != $data['shipping_cost'];

        $changed_order_items = [];

        if (!empty($data['products_qty']) && is_array($data['products_qty'])) {
            foreach ($order->orderItems as $item) {
                if (isset($data['products_qty'][$item->id]) && $data['products_qty'][$item->id] != $item->quantity) {
                    $changed_order_items[] = $item->id;
                }

                if (isset($data['products_prices'][$item->id]) && $data['products_prices'][$item->id] != $item->sale_price) {
                    $changed_order_items[] = $item->id;
                }

                if (isset($data['products_qty'][$item->id]) || isset($data['products_prices'][$item->id])) {
                    $item->update([
                        'quantity' => $data['products_qty'][$item->id],
                        'sale_price' => $data['products_prices'][$item->id],
                    ]);
                }
            }
        }

        if(isset($data['action']) && $data['action'] == 2) {
            $unique_order_items_array = array_unique($changed_order_items);

            if (!empty($unique_order_items_array) || $order->shipment_date_change || $order->shipment_cost) {
                $order->shipment_date_change = false;
                if ($before_save_estimated_ship_date != $new_estimatedShipDate) {
                    $order->shipment_date_change = true;
                    $order->before_save_estimated_ship_date = $before_save_estimated_ship_date;
                }

                $order->shipment_cost = false;
                if ($before_save_shipping_cost != $data['shipping_cost']) {
                    $order->shipment_cost = true;
                }

                $order->order_item_changes = $unique_order_items_array;
                Orders::send_order_changes_email_to_customer($order);
            }
        }


        return redirect(route('edit-order',['order_id' => $order_id]))->with('success', "Order updated");

    }

    public function cancel_order(Request $request)
    {
        $data = $request->all();
        $order = Orders::query()
            ->select("id", "status")
            ->where("id", "=", $data['order_id'])
            ->first();
        $order->status = 6;
        $order->save();
        Session::flash('success', "Order #".$data['order_id']." status changed");
        return response()->json([
            'status' => 'success',
            'message' => 'Order has been cancelled',
            'order_id' =>  $data['order_id']
        ]);
    }

    public function change_order_process(Request $request)
    {
        $data = $request->all();
        $order = Orders::find($data['order_id']);
        if ($order) {
            $order->status = $data['status'];
            $order->save();
            Orders::send_order_status_email($order);
            return redirect()->back()->with('success', "Order #".$data['order_id']." status changed");

        } else {
            return redirect()->back()->withErrors(['error' => "Operation Failed!"]);
        }
    }

    function delete_order_items(Request $request)
    {
        $data = $request->all();
        $order_item = OrderItems::find($data['oi_id']);
        $order_item->delete();
        return response()->json(['status' => 'success']);
    }

    // Show all cart item which customer added but not checkout yet

    public function all_cart_items(Request $request)
    {
        $data = $request->all();
        $filter_flag = false;
        $pagination = optional(View::shared('site_management'))->backend_pagination_listing ?? 50;
        $cart_items = Products::join('product_prices', 'products.id', '=', 'product_prices.product_id')
            ->join('product_type', 'product_prices.pt_sub_id', '=', 'product_type.id')
            ->join('artist', 'products.artist_id', '=', 'artist.id')
            ->join('cart', 'cart.product_id', '=', 'products.id')
            ->join('customers', 'customers.id', '=', 'cart.customer_id')
           // ->select('customers.id','customers.first_name','customers.last_name','SUM(product_prices.price * cart.quantity) as total_price','SUM(cart.quantity) as total_quantity')
            ->select('customers.id', 'customers.first_name', 'customers.last_name', 'customers.email', 'customers.phone', 'customers.shiping_address1', \DB::raw('SUM(product_prices.price * cart.quantity) as total_price'), \DB::raw('SUM(cart.quantity) as total_quantity'))
            ->where("products.status", "=", 1)
            ->where("artist.status", "=", 1)
            ->orderBy('cart.id', 'desc')
            ->groupBy('cart.customer_id')
            ->paginate($pagination);
        //print_r($cart_items);exit;
        return view('admin/cart-items/all-cart-items', compact('cart_items','filter_flag'));
    }

    function cart_item_detail(Request $request)
    {
        $data = $request->all();

        $cart_products = Products::join('product_prices', 'products.id', '=', 'product_prices.product_id')
            ->join('product_type', 'product_prices.pt_sub_id', '=', 'product_type.id')
            ->join('artist', 'products.artist_id', '=', 'artist.id')
            ->join('cart', 'cart.product_id', '=', 'products.id')
            ->select('products.product_name','products.id as pid','products.product_slug','products.product_customizable','products.feature_image','products.product_sku','artist.id as artist_id','artist.first_name','artist.last_name','artist.display_name' ,'artist.artist_slug' ,'product_prices.price','product_prices.pt_sub_id', 'product_type.type_name','cart.id as cid','cart.quantity as quantity')
            ->where("products.status", "=", 1)
            ->where("artist.status", "=", 1)
            ->where("cart.customer_id", "=", $data['cid'])
            ->get();
        $customer = Customer::find( $data['cid']);
        return view('admin/cart-items/view-cart-detail', compact('cart_products','customer'));
    }
}
