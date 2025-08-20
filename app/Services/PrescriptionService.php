<?php

namespace App\Services;

use App\DTOs\EventResultDTO;
use App\Http\Requests\Prescriptions\SavePrescriptionInformationRequest;
use App\Repositories\PrescriptionRepository;

class PrescriptionService
{
    protected PrescriptionRepository $prescriptionRepository;

    public function __construct(PrescriptionRepository $prescriptionRepository)
    {
        $this->prescriptionRepository = $prescriptionRepository;
    }

    public function savePrescriptionInformation(SavePrescriptionInformationRequest $request): EventResultDTO
    {
        // Lógica para guardar la información de la receta
        $eventResultDTO = new EventResultDTO();

        try {
            $prescription = $this->prescriptionRepository->create([
                'doctor_id' => $request->doctor_id,
                'patient_id' => $request->patient_id,
                'consultation_id' => $request->consultation_id,
                'notes' => $request->notes,
                'prescription_date' => $request->prescription_date,
            ]);

            if (!$prescription) {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'No se pudo guardar la receta.';

                return $eventResultDTO;
            }
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Proceso fallido: ' . $e->getMessage();

            return $eventResultDTO;
        }

        $eventResultDTO->values['prescription'] = $prescription ?? null;
        $eventResultDTO->message = 'Receta guardada correctamente.';

        return $eventResultDTO;
    }
}