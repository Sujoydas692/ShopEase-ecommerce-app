<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_no',
        'total',
        'shipping',
        'vat',
        'payable',
        'cus_details',
        'ship_details',
        'status',
        'payment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(InvoiceProduct::class);
    }
}
