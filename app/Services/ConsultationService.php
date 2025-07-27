<?php

namespace App\Services;

use App\DTOs\EventResultDTO;
use App\Http\Requests\Consultations\SaveConsultationInformationRequest;
use App\Repositories\ConsultationRepository;

class ConsultationService
{
    protected $consultationRepository;

    public function __construct(
        ConsultationRepository $consultationRepository)
    {
        $this->consultationRepository = $consultationRepository;
    }

    public function saveConsultationInformation(SaveConsultationInformationRequest $request): EventResultDTO
    {
        $eventResultDTO = new EventResultDTO();

        try {
            $consultation = $this->consultationRepository->create([
                'doctor_id' => $request->input('doctor_id'),
                'patient_id' => $request->input('patient_id'),
                'consultation_date' => $request->input('consultation_date'),
                'reason_for_consultation' => $request->input('reason_for_consultation'),
                'allergies' => $request->input('allergies'),
                'blood_pressure' => $request->input('blood_pressure'),
                'heart_rate' => $request->input('heart_rate'),
                'respiratory_rate' => $request->input('respiratory_rate'),
                'oxygen_saturation' => $request->input('oxygen_saturation'),
                'temperature' => $request->input('temperature'),
                'weight' => $request->input('weight'),
                'height' => $request->input('height'),
                'medications' => $request->input('medications'),
                'medical_conditions' => $request->input('medical_conditions'),
                'medical_history' => $request->input('medical_history'),
                'family_history' => $request->input('family_history'),
                'diagnosis' => $request->input('diagnosis'),
                'treatment' => $request->input('treatment'),
                'follow_up_instructions' => $request->input('follow_up_instructions'),
                'notes' => $request->input('notes'),
                'is_active' => $request->input('is_active'),
                'is_suspended' => $request->input('is_suspended'),
                'is_deleted' => $request->input('is_deleted'),
            ]);

            $eventResultDTO->result = true;
            $eventResultDTO->message = 'Consulta guardada correctamente';
            $eventResultDTO->values['consultation'] = $consultation;
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Error al guardar la consulta: ' . $e->getMessage();
        }

        return $eventResultDTO;
    }
}