<?php

namespace App\Http\Controllers;

use App\DTOs\EventResultDTO;
use App\Http\Requests\Shifts\GetCurrentShiftStatusRequest;
use App\Http\Requests\Shifts\GetPreviousShiftStatusRequest;
use App\Http\Requests\Shifts\GetShiftInformationRequest;
use App\Http\Requests\Shifts\UpdateShiftStatusRequest;
use App\Http\Requests\Shifts\UpdatePreviousShiftStatusRequest;
use App\Services\ShiftService;
use Illuminate\Http\JsonResponse;

class ShiftController extends Controller
{
    protected ShiftService $shiftService;

    public function __construct(ShiftService $shiftService)
    {
        $this->shiftService = $shiftService;
    }

    public function getShiftInformation(GetShiftInformationRequest $request): JsonResponse
    {
        $eventResultDTO = $this->shiftService->getShiftInformation($request);

        return response()->json($eventResultDTO);
    }

    public function getPreviousShiftStatus(GetPreviousShiftStatusRequest $request): JsonResponse
    {
        $eventResultDTO = $this->shiftService->getPreviousShiftStatus($request);

        return response()->json($eventResultDTO);
    }

    public function getCurrentShiftStatus(GetCurrentShiftStatusRequest $request): JsonResponse
    {
        $eventResultDTO = $this->shiftService->getCurrentShiftStatus($request);

        return response()->json($eventResultDTO);
    }

    public function updateShiftStatus(UpdateShiftStatusRequest $request): JsonResponse
    {
        $eventResultDTO = $this->shiftService->updateShiftStatus($request);

        return response()->json($eventResultDTO);
    }

    public function updatePreviousShiftStatus(UpdatePreviousShiftStatusRequest $request): JsonResponse
    {
        $eventResultDTO = $this->shiftService->updatePreviousShiftStatus($request);

        return response()->json($eventResultDTO);
    }
}