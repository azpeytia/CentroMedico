<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'shift_id',
        'date',
        'opening_stock',
        'sold_stock',
        'closing_stock',
    ];

    protected $casts = [
        'product_id' => 'integer',
        'shift_id' => 'integer',
        'date' => 'datetime',
        'opening_stock' => 'integer',
        'sold_stock' => 'integer',
        'closing_stock' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}