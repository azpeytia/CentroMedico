<?php

namespace App\Http\Controllers;

use App\DTOs\EventResultDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Consultations\SaveConsultationInformationRequest;
use App\Services\ConsultationService;
use Illuminate\Http\JsonResponse;

class ConsultationController extends Controller
{
    protected ConsultationService $consultationService;

    public function __construct(ConsultationService $consultationService)
    {
        $this->consultationService = $consultationService;
    }

    public function create()
    {
        return view('consultations.create');
    }

    public function saveConsultationInformation(SaveConsultationInformationRequest $request): JsonResponse
    {
        $eventResultDTO = $this->consultationService->saveConsultationInformation($request);

        return response()->json($eventResultDTO);
    }
}