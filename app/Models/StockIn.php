<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $fillable = [
        'transaction_id',
        'publisher_id',
        'game_id',
        'quantity_received',
        'cost_price',
        'sale_rate',
        'reference_number',
        'arrival_date',
        'payment_status',
    ];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}