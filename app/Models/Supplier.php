<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'supplier_name',
        'company_name',
        'contact_person',
        'gst_number',
        'phone',
        'alternate_phone',
        'email',
        'website',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'status',

    ];
}