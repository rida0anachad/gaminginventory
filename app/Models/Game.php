<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'title', 'platform', 'genre', 'publisher_id', 'poster'
    ];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function stock()
    {
        return $this->hasOne(GameStock::class);
    }

    public function saleItems()
    {
    return $this->hasMany(SaleItem::class);
    }
    public function stockIns()
    {
    return $this->hasMany(StockIn::class);
    }
}
