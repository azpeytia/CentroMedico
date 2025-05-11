<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'is_suspended',
        'is_deleted',
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'is_active' => 'boolean',
        'is_suspended' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    protected $attributes = [
        'is_active' => true,
        'is_suspended' => false,
        'is_deleted' => false,
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}