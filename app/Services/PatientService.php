<?php

namespace App\Services;

use App\Repositories\PatientRepository;

class PatientService
{
    protected $patientRepository;

    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function searchPatientInformation($eventRecord)
    {
        return $this->patientRepository->searchByName($eventRecord);
    }
}