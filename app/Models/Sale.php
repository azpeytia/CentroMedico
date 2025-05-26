<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'shift_id',
        'user_id',
        'total',
        'status',
        'payment_method',
        'is_active',
        'is_suspended',
        'is_deleted',
    ];

    protected $casts = [
        'patient_id' => 'integer',
        'shift_id' => 'integer',
        'user_id' => 'integer',
        'total' => 'decimal:2',
        'status' => 'string',
        'payment_method' => 'string',
        'is_active' => 'boolean',
        'is_suspended' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    protected $attributes = [
        'is_active' => true,
        'is_suspended' => false,
        'is_deleted' => false,
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function saleProducts()
    {
        return $this->hasMany(SaleProduct::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}