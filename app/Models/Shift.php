<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'start_time',
        'end_time',
        'is_started',
        'is_finished',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'name' => 'string',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_started' => 'boolean',
        'is_finished' => 'boolean',
    ];

    protected $attributes = [
        'is_started' => false,
        'is_finished' => false,
    ];

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}