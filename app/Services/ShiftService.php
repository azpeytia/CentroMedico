<?php

namespace App\Services;

use App\DTOs\EventResultDTO;
use App\Http\Requests\Shifts\GetCurrentShiftStatusRequest;
use App\Http\Requests\Shifts\GetPreviousShiftStatusRequest;
use App\Http\Requests\Shifts\GetShiftInformationRequest;
use App\Http\Requests\Shifts\UpdateShiftStatusRequest;
use App\Http\Requests\Shifts\UpdatePreviousShiftStatusRequest;
use App\Repositories\ShiftRepository;
use Carbon\Carbon;

class ShiftService
{
    protected ShiftRepository $shiftRepository;

    public function __construct(ShiftRepository $shiftRepository)
    {
        $this->shiftRepository = $shiftRepository;
    }

    public function getShiftInformation(GetShiftInformationRequest $request): EventResultDTO
    {
        $eventResultDTO = new EventResultDTO();

        try {
            $shiftRecords = $this->shiftRepository->findByTime($request->input('eventRecord'));

            if (!$shiftRecords) {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'No se encontró un turno para la hora proporcionada';

                return $eventResultDTO;
            }
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Proceso fallido: ' . $e->getMessage();

            return $eventResultDTO;
        }

        $eventResultDTO->values['shiftRecords'] = $shiftRecords;
        $eventResultDTO->message = 'Turno(s) encontrado(s)';

        return $eventResultDTO;
    }

    public function getPreviousShiftStatus(GetPreviousShiftStatusRequest $request): EventResultDTO
    {
        $eventResultDTO = new EventResultDTO();

        try {
            $shiftRecords = $this->shiftRepository->findPreviousStarted($request->input('eventRecord'));

            if (!$shiftRecords) {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'No se encontró un turno iniciado anteriormente';

                return $eventResultDTO;
            }
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Proceso fallido: ' . $e->getMessage();

            return $eventResultDTO;
        }

        $eventResultDTO->values['shiftRecords'] = $shiftRecords;
        $eventResultDTO->message = 'Existe un turno sin terminar';
        $eventResultDTO->icon = 'warning';

        return $eventResultDTO;
    }

    public function getCurrentShiftStatus(GetCurrentShiftStatusRequest $request): EventResultDTO
    {
        $eventResultDTO = new EventResultDTO();

        $shiftId = $request->input('eventRecord.shiftId');
        $shiftDate = Carbon::parse($request->input('eventRecord.shiftDate'))->toDateString();

        try {
            $shiftRecords = $this->shiftRepository->findCurrentFinished($shiftId, $shiftDate);

            if (!$shiftRecords) {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'No se encontró un turno terminado';

                return $eventResultDTO;
            }
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Proceso fallido: ' . $e->getMessage();

            return $eventResultDTO;
        }

        $eventResultDTO->values['shiftRecords'] = $shiftRecords;
        $eventResultDTO->message = 'Turno iniciado y terminado anteriormente';
        $eventResultDTO->icon = 'warning';

        return $eventResultDTO;
    }

    public function updateShiftStatus(UpdateShiftStatusRequest $request): EventResultDTO
    {
        $eventResultDTO = new EventResultDTO();

        try {
            $shiftRecords = $this->shiftRepository->updateStatus(
                $request->input('eventRecord.shiftId'),
                $request->input('eventRecord.isStarted'),
                $request->input('eventRecord.isFinished')
            );

            if (!$shiftRecords) {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'Turno no encontrado';

                return $eventResultDTO;
            }
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Proceso fallido: ' . $e->getMessage();

            return $eventResultDTO;
        }

        $eventResultDTO->values['shiftRecords'] = $shiftRecords;
        $eventResultDTO->message = 'Estado del turno actualizado correctamente';

        return $eventResultDTO;
    }

    public function updatePreviousShiftStatus(UpdatePreviousShiftStatusRequest $request): EventResultDTO
    {
        $eventResultDTO = new EventResultDTO();

        try {
            $shiftRecords = $this->shiftRepository->finishPrevious($request->input('eventRecord'));

            if (!$shiftRecords) {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'No se encontró un turno para finalizar';

                return $eventResultDTO;
            }
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Proceso fallido: ' . $e->getMessage();

            return $eventResultDTO;
        }

        $eventResultDTO->values['shiftRecords'] = $shiftRecords;
        $eventResultDTO->message = 'Turno anterior finalizado exitosamente';

        return $eventResultDTO;
    }
}