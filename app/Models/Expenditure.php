<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
    protected $fillable = ['paid_to', 'expenditure', 'amount', 'receipts'];

    public function user()
    {
        return $this->hasMany('App\Models\User');
    }
}
