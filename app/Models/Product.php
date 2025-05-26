<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'presentation',
        'stock',
        'max_stock',
        'min_stock',
        'price',
        'is_active',
        'is_suspended',
        'is_deleted',
    ];

    protected $casts = [
        'category_id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'presentation' => 'string',
        'stock' => 'integer',
        'max_stock' => 'integer',
        'min_stock' => 'integer',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_suspended' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    protected $attributes = [
        'is_active' => true,
        'is_suspended' => false,
        'is_deleted' => false,
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    public function saleProducts()
    {
        return $this->hasMany(SaleProduct::class);
    }

    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sale_products')
                    ->withPivot('quantity', 'unit_price', 'subtotal')
                    ->withTimestamps();
    }
}