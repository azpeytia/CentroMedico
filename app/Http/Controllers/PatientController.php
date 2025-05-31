<?php

namespace App\Http\Controllers;

use App\DTOs\EventResultDTO;
use App\Services\PatientService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    protected $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    public function searchPatientInformation(Request $request, EventResultDTO $eventResultDTO) {
        try {
            $records = $this->patientService->searchPatientInformation($request->eventRecord);

            if ($records) {
                $eventResultDTO->values['patientRecords'] = $records;
                $eventResultDTO->result = true;
                $eventResultDTO->message = 'Se han encontrado los registros de pacientes exitosamente';
            } else {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'No se encontraron registros de pacientes para el nombre proporcionado';
            }
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Error  ' . $e->getMessage();

            return response()->json($eventResultDTO, 500);
        }

        return response()->json($eventResultDTO);
    }
}