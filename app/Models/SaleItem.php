<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id', 'game_id', 'quantity', 'unit_price', 'subtotal'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}