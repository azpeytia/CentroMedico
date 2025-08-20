<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'consultation_id',
        'notes',
        'prescription_date',
        'is_active',
        'is_suspended',
        'is_deleted',
    ];

    protected $casts = [
        'doctor_id' => 'integer',
        'patient_id' => 'integer',
        'consultation_id' => 'integer',
        'notes' => 'string',
        'prescription_date' => 'timestamp',
        'is_active' => 'boolean',
        'is_suspended' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    protected $attributes = [
        'is_active' => true,
        'is_suspended' => false,
        'is_deleted' => false,
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot(['quantity', 'instructions'])
            ->withTimestamps();
    }
}