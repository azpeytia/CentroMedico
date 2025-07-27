<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctors\SearchDoctorInformationRequest;
use App\Services\DoctorService;
use Illuminate\Http\JsonResponse;

class DoctorController extends Controller
{
    protected DoctorService $doctorService;

    public function __construct(DoctorService $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    /**
     * Busca información de doctores.
     *
     * @param SearchDoctorInformationRequest $request
     * @return JsonResponse
     */
    public function searchDoctorInformation(SearchDoctorInformationRequest $request): JsonResponse
    {
        $eventResultDTO = $this->doctorService->searchDoctorInformation($request);

        return response()->json($eventResultDTO);
    }
}
