<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItems;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Wishlist extends Model
{

    protected $table = 'wishlist';

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function checkAllOrderItemsInWishlist($order_id)
    {
        // Retrieve all product IDs for the specified order ID
        $orderItems = OrderItems::where('order_id', $order_id)->get();

        foreach ($orderItems as $orderItem) {
            $productId = $orderItem->product_id;
            $wishlistProduct = Wishlist::where('product_id', $productId)->first();
            if (!$wishlistProduct) {
                return true; // Product not found in wishlist
            }
        }

        return false; // No product found in wishlist
    }

}
