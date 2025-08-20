<?php

namespace App\Http\Controllers;

use App\DTOs\EventResultDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Prescriptions\SavePrescriptionInformationRequest;
use App\Services\PrescriptionService;
use Illuminate\Http\JsonResponse;

class PrescriptionController extends Controller
{
    protected PrescriptionService $prescriptionService;

    public function __construct(PrescriptionService $prescriptionService)
    {
        $this->prescriptionService = $prescriptionService;
    }

    public function create()
    {
        return view('prescriptions.create');
    }

    /**
     * Salva la información de la receta.
     *
     * @param SavePrescriptionInformationRequest $request
     * @return JsonResponse
     */
    public function savePrescriptionInformation(SavePrescriptionInformationRequest $request): JsonResponse
    {
        $eventResultDTO = $this->prescriptionService->savePrescriptionInformation($request);

        return response()->json($eventResultDTO);
    }
}