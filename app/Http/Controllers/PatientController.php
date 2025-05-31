<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchPatientInformationRequest;
use App\Services\PatientService;
use Illuminate\Http\JsonResponse;

class PatientController extends Controller
{
    protected PatientService $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    /**
     * Busca información de pacientes.
     *
     * @param SearchPatientInformationRequest $request
     * @return JsonResponse
     */
    public function searchPatientInformation(SearchPatientInformationRequest $request): JsonResponse
    {
        $eventResultDTO = $this->patientService->searchPatientInformation($request);

        return response()->json($eventResultDTO);
    }
}