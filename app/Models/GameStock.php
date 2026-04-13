<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameStock extends Model
{
    protected $fillable = [
        'game_id',
        'qty',
        'sale_rate',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}