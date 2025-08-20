<?php

namespace App\Repositories;

use App\Models\Prescription;

class PrescriptionRepository
{
    public function create(array $data): ?Prescription
    {
        return Prescription::create($data);
    }

    // Otros métodos para interactuar con el modelo Prescription
}