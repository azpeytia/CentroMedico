<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'state',
        'zip_code',
        'phone',
        'sex',
        'date_of_birth',
        'is_active',
    ];

    protected $casts = [
        'name' => 'string',
        'address' => 'string',
        'city' => 'string',
        'state' => 'string',
        'zip_code' => 'string',
        'phone' => 'string',
        'sex' => 'string',
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
    ];

    protected $attributes = [
        'is_active' => true,
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}