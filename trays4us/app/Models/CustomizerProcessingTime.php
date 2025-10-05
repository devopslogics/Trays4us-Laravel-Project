<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CustomizerProcessingTime extends Model
{
    protected $table = 'customizer_processing_time';

    protected $fillable = [
        'product_name',
        'product_ids',
        'customer_id',
        'image_name',
        'upload_processing_time',
        'created_at',
        'updated_at',
        // Add any other fields here as needed.
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
