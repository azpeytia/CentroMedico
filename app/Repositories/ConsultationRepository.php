<?php

namespace App\Repositories;

use App\Models\Consultation;

class ConsultationRepository
{
    public function create(array $data): ?Consultation
    {
        return Consultation::create($data);
    }
}