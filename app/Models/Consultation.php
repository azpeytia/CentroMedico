<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_date',
        'reason_for_consultation',
        'blood_pressure',
        'heart_rate',
        'respiratory_rate',
        'oxygen_saturation',
        'temperature',
        'weight',
        'height',
        'medications',
        'medical_conditions',
        'medical_history',
        'family_history',
        'diagnosis',
        'treatment',
        'follow_up_instructions',
        'notes',
        'is_active',
        'is_suspended',
        'is_deleted',
    ];

    protected $casts = [
        'consultation_date' => 'timestamp',
        'reason_for_consultation' => 'string',
        'blood_pressure' => 'string',
        'heart_rate' => 'string',
        'respiratory_rate' => 'string',
        'oxygen_saturation' => 'string',
        'temperature' => 'string',
        'weight' => 'string',
        'height' => 'string',
        'medications' => 'string',
        'medical_conditions' => 'string',
        'medical_history' => 'string',
        'family_history' => 'string',
        'diagnosis' => 'string',
        'treatment' => 'string',
        'follow_up_instructions' => 'string',
        'notes' => 'text',
        'is_active' => 'boolean',
        'is_suspended' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    protected $attributes = [
        'is_active' => true,
        'is_suspended' => false,
        'is_deleted' => false,
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}