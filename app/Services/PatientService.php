<?php

namespace App\Services;

use App\DTOs\EventResultDTO;
use App\Http\Requests\SearchPatientInformationRequest;
use App\Repositories\PatientRepository;

class PatientService
{
    protected PatientRepository $patientRepository;

    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    /**
     * Busca información de pacientes por nombre.
     *
     * @param SearchPatientInformationRequest $request
     * @return EventResultDTO
     */
    public function searchPatientInformation(SearchPatientInformationRequest $request): EventResultDTO
    {
        $eventResultDTO = new EventResultDTO();

        try {
            $patients = $this->patientRepository->searchByName($request->eventRecord);

            if ($patients->isEmpty()) {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'No se encontró un paciente';

                return $eventResultDTO;
            }
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Proceso fallido: ' . $e->getMessage();

            return $eventResultDTO;
        }

        $eventResultDTO->values['patientRecords'] = $patients;
        $eventResultDTO->message = 'Paciente(s) encontrado(s)';

        return $eventResultDTO;
    }
}