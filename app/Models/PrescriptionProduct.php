<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product',
        'instructions',
        'is_active',
        'is_suspended',
        'is_deleted',
    ];

    protected $casts = [
        'instructions' => 'text',
        'is_active' => 'boolean',
        'is_suspended' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    protected $attributes = [
        'is_active' => true,
        'is_suspended' => false,
        'is_deleted' => false,
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}