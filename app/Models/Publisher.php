<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $fillable = [
        'publisher_id',
        'company_name',
        'email',
        'contact_number',
        'address',
    ];
}