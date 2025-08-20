<?php

namespace App\Services;

use App\DTOs\EventResultDTO;
use App\Http\Requests\Doctors\SaveDoctorInformationRequest;
use App\Http\Requests\Doctors\SearchDoctorInformationRequest;
use App\Repositories\DoctorRepository;

class DoctorService
{
    protected DoctorRepository $doctorRepository;

    public function __construct(DoctorRepository $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }

    public function saveDoctorInformation(SaveDoctorInformationRequest $request): EventResultDTO
    {
        $eventResultDTO = new EventResultDTO();
        $doctor = null;

        try {
            $doctor = $this->doctorRepository->create([
                'name' => $request->doctor_name,
                'license_number' => $request->doctor_license_number,
                'specialty' => $request->doctor_specialty,
                'email' => $request->doctor_email,
                'phone' => $request->doctor_phone,
            ]);

            if (!$doctor) {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'No se pudo guardar la información del doctor.';

                return $eventResultDTO;
            }
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Proceso fallido: ' . $e->getMessage();
            return $eventResultDTO;
        }

        $eventResultDTO->values['doctor'] = $doctor;
        $eventResultDTO->message = 'Doctor salvado correctamente.';

        return $eventResultDTO;
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