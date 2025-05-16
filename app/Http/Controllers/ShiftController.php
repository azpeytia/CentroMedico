<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTOs\EventResultDTO;
use App\Models\Shift;
use Carbon\Carbon;

class ShiftController extends Controller
{
    public function getShiftInformation(Request $request, EventResultDTO $eventResultDTO)
    {
        $eventRecord = $request->input('eventRecord');

        try {
            $shiftRecord = Shift::whereTime('start_time', '<=', $eventRecord)
            ->whereTime('end_time', '>=', $eventRecord)
            ->first();

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
            return response()->json($eventResultDTO);
        }
        return response()->json($eventResultDTO);
    }

    public function getPreviousShiftStatus(Request $request, EventResultDTO $eventResultDTO)
    {
        $shiftId = $request->input('eventRecord');

        try {
            $eventResultDTO->values['shiftRecords'] = Shift::where('id', '!=', $shiftId)
                ->where('is_started', 1)
                ->first();
            if ($eventResultDTO->values['shiftRecords']) {
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
            return response()->json($eventResultDTO);
        }
        return response()->json($eventResultDTO);
    }

    public function getCurrentShiftStatus(Request $request, EventResultDTO $eventResultDTO)
    {
        $shiftId = $request->input('eventRecord.shiftId');
        $shiftDate = Carbon::parse($request->input('eventRecord.shiftDate'))->toDateString();

        try {
            $eventResultDTO->values['shiftRecords'] = Shift::where('id', $shiftId)
                ->where('is_finished', 1)
                ->whereDate('updated_at', $shiftDate)
                ->first();
            if ($eventResultDTO->values['shiftRecords']) {
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
            return response()->json($eventResultDTO);
        }
        return response()->json($eventResultDTO);
    }

    public function updateShiftStatus(Request $request, EventResultDTO $eventResultDTO)
    {
        $shiftId = $request->input('eventRecord.shiftId');
        $isStarted = $request->input('eventRecord.isStarted');
        $isFinished = $request->input('eventRecord.isFinished');

        try {
            $shift = Shift::find($shiftId);
            if ($shift) {
                $shift->is_started = $isStarted;
                $shift->is_finished = $isFinished;
                $shift->save();

                $eventResultDTO->result = true;
                $eventResultDTO->message = 'Estado del turno actualizado correctamente';
            } else {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'Turno no encontrado';
            }
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Error  ' . $e->getMessage();
            return response()->json($eventResultDTO);
        }
        return response()->json($eventResultDTO);
    }

    public function updatePreviousShiftStatus(Request $request, EventResultDTO $eventResultDTO)
    {
        $shiftId = $request->input('eventRecord');

        try {
            $shift = Shift::where('id', '!=', $shiftId)
                ->first();
            if ($shift) {
                $shift->is_started = 0;
                $shift->is_finished = 1;
                $shift->save();

                $eventResultDTO->result = true;
                $eventResultDTO->message = 'Estado del turno previo actualizado correctamente';
            } else {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'Turno no encontrado';
            }
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Error  ' . $e->getMessage();
            return response()->json($eventResultDTO);
        }
        return response()->json($eventResultDTO);
    }
}