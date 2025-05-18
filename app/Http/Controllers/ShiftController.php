<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTOs\EventResultDTO;
use App\Services\ShiftService;
use Carbon\Carbon;

class ShiftController extends Controller
{
    protected $shiftService;

    public function __construct(ShiftService $shiftService)
    {
        $this->shiftService = $shiftService;
    }

    public function getShiftInformation(Request $request, EventResultDTO $eventResultDTO)
    {
        $eventRecord = $request->input('eventRecord');

        try {
            $shiftRecord = $this->shiftService->getShiftInformation($eventRecord);

            if ($shiftRecord) {
                $eventResultDTO->values['shiftRecords'] = $shiftRecord;
                $eventResultDTO->result = true;
            } else {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'No se encontró un turno para la hora proporcionada';
            }
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Error  ' . $e->getMessage();

            return response()->json($eventResultDTO, 500);
        }

        return response()->json($eventResultDTO);
    }

    public function getPreviousShiftStatus(Request $request, EventResultDTO $eventResultDTO)
    {
        $shiftId = $request->input('eventRecord');

        try {
            $shiftRecord = $this->shiftService->getPreviousShiftStatus($shiftId);

            if ($shiftRecord) {
                $eventResultDTO->values['shiftRecords'] = $shiftRecord;
                $eventResultDTO->result = true;
                $eventResultDTO->message = 'Existe un turno sin terminar';
                $eventResultDTO->icon = 'warning';
            } else {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'No se encontró un turno iniciado';
            }
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Error  ' . $e->getMessage();

            return response()->json($eventResultDTO, 500);
        }

        return response()->json($eventResultDTO);
    }

    public function getCurrentShiftStatus(Request $request, EventResultDTO $eventResultDTO)
    {
        $shiftId = $request->input('eventRecord.shiftId');
        $shiftDate = Carbon::parse($request->input('eventRecord.shiftDate'))->toDateString();

        try {
            $shiftRecord = $this->shiftService->getCurrentShiftStatus($shiftId, $shiftDate);

            if ($shiftRecord) {
                $eventResultDTO->values['shiftRecords'] = $shiftRecord;
                $eventResultDTO->result = true;
                $eventResultDTO->message = 'Turno iniciado y terminado anteriormente';
                $eventResultDTO->icon = 'warning';
            } else {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'No se encontró un turno terminado';
            }
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Error  ' . $e->getMessage();

            return response()->json($eventResultDTO, 500);
        }

        return response()->json($eventResultDTO);
    }

    public function updateShiftStatus(Request $request, EventResultDTO $eventResultDTO)
    {
        $shiftId = $request->input('eventRecord.shiftId');
        $isStarted = $request->input('eventRecord.isStarted');
        $isFinished = $request->input('eventRecord.isFinished');

        try {
            $shift = $this->shiftService->updateShiftStatus($shiftId, $isStarted, $isFinished);
            if ($shift) {
                $eventResultDTO->result = true;
                $eventResultDTO->message = 'Estado del turno actualizado correctamente';
            } else {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'Turno no encontrado';
            }
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Error  ' . $e->getMessage();

            return response()->json($eventResultDTO, 500);
        }

        return response()->json($eventResultDTO);
    }

    public function updatePreviousShiftStatus(Request $request, EventResultDTO $eventResultDTO)
    {
        $shiftId = $request->input('eventRecord');

        try {
            $shift = $this->shiftService->updatePreviousShiftStatus($shiftId);

            if ($shift) {
                $eventResultDTO->result = true;
                $eventResultDTO->message = 'Estado del turno previo actualizado correctamente';
            } else {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'Turno no encontrado';
            }
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Error  ' . $e->getMessage();

            return response()->json($eventResultDTO, 500);
        }

        return response()->json($eventResultDTO);
    }
}