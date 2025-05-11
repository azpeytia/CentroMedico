<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'is_started',
        'is_finished',
    ];

    protected $casts = [
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

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function invetories()
    {
        return $this->hasMany(Inventory::class);
    }
}