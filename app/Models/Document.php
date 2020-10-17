<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast;

class Document extends Model
{
    protected $fillable = ['document_type', 'document_owner', 'issue_date', 'expiry_date', 'reminder_date', 'car'];


    public function vehicle()
    {
        return $this->belongsTo('App\Models\Vehicle');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
