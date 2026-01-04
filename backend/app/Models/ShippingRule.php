<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingRule extends Model
{
    protected $fillable = [
        'district_id',
        'upazila_id',
        'charge',
    ];
}
