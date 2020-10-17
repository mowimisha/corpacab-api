<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mpesa extends Model
{
    protected $table = 'mpesa_payments';

    protected $fillable = [
        'checkout_request_id',
        'amount',
        'receipt_number',
        'transaction_date',
        'phone',
    ];
}
