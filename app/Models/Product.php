<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'category_id',

        'brand_id',

        'unit_id',

        'supplier_id',

        'product_name',

        'sku',

        'barcode',

        'purchase_price',

        'selling_price',

        'opening_stock',

        'minimum_stock',

        'image',

        'description',

        'status',

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

}