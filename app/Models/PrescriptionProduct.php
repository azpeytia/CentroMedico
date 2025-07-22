<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'dosage',
        'frequency',
        'duration',
        'instructions',
        'is_active',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'dosage' => 'string',
        'frequency' => 'string',
        'duration' => 'string',
        'instructions' => 'text',
        'is_active' => 'boolean',
    ];

    protected $attributes = [
        'is_active' => true,
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}