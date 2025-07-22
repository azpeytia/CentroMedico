<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'license_number',
        'specialty',
        'phone',
        'email',
        'is_active',
        'is_suspended',
        'is_deleted',
    ];

    protected $casts = [
        'name' => 'string',
        'license_number' => 'string',
        'specialty' => 'string',
        'phone' => 'string',
        'email' => 'string',
        'is_active' => 'boolean',
        'is_suspended' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    protected $attributes = [
        'is_active' => true,
        'is_suspended' => false,
        'is_deleted' => false,
    ];

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function patients()
    {
        return $this->hasManyThrough(Patient::class, Consultation::class, 'doctor_id', 'id', 'id', 'patient_id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}