<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'member_id', 'name', 'contact_number',
        'address', 'favorite_genre', 'platform_preference'
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
