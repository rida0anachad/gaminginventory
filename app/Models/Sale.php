<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'sale_no', 'member_id', 'date',
        'total_amount', 'discount', 'net_total'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
