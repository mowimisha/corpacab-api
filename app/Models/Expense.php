<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['car_registration', 'expense', 'amount', 'receipts'];

    public function vehicle()
    {
        return $this->belongsTo('App\Models\Vehicle');
    }
}
