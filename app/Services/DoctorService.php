<?php

namespace App\Services;

use App\DTOs\EventResultDTO;
use App\Http\Requests\Doctors\SearchDoctorInformationRequest;
use App\Repositories\DoctorRepository;

class DoctorService
{
    protected DoctorRepository $doctorRepository;

    public function __construct(DoctorRepository $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }

    /**
     * Busca información de doctores por nombre.
     *
     * @param SearchDoctorInformationRequest $request
     * @return EventResultDTO
     */
    public function searchDoctorInformation(SearchDoctorInformationRequest $request): EventResultDTO
    {
        $eventResultDTO = new EventResultDTO();

        try {
            $doctors = $this->doctorRepository->searchByName($request->eventRecord);

            if ($doctors->isEmpty()) {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'No se encontró un doctor';

                return $eventResultDTO;
            }
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Proceso fallido: ' . $e->getMessage();

            return $eventResultDTO;
        }

        $eventResultDTO->values['doctorRecords'] = $doctors;
        $eventResultDTO->message = 'Doctor(es) encontrado(s)';

        return $eventResultDTO;
    }
}