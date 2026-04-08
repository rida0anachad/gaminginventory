<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameStock extends Model
{
    protected $fillable = [
        'game_id', 'sku', 'release_date', 'qty', 'mrp', 'rate'
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
