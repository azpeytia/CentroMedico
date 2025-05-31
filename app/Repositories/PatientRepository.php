<?php

namespace App\Repositories;

use App\Models\Patient;

class PatientRepository
{
    public function searchByName(string $eventRecord): \Illuminate\Database\Eloquent\Collection
    {
        return Patient::where('name', 'like', '%' . $eventRecord . '%')->get();
    }
}