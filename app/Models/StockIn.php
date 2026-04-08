<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $fillable = [
        'transaction_id', 'publisher_id', 'game_id',
         'quantity_received', 'reference_number',
        'arrival_date', 'total_cost', 'payment_status'
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
