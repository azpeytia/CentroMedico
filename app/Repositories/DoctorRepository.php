<?php

namespace App\Repositories;

use App\Models\Doctor;

class DoctorRepository
{
    public function create(array $doctorData): ?Doctor
    {
        return Doctor::create($doctorData);
    }

    public function searchByName(string $eventRecord): \Illuminate\Database\Eloquent\Collection
    {
        return Doctor::where('name', 'like', '%' . $eventRecord . '%')->get();
    }
}