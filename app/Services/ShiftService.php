<?php

namespace App\Services;

use App\DTOs\EventResultDTO;
use App\Repositories\ShiftRepository;

class ShiftService
{
    protected $shiftRepository;

    public function __construct(ShiftRepository $shiftRepository)
    {
        $this->shiftRepository = $shiftRepository;
    }

    public function getShiftInformation($request): EventResultDTO
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

    public function getPreviousShiftStatus($shiftId)
    {
        return $this->shiftRepository->findPreviousStarted($shiftId);
    }

    public function getCurrentShiftStatus($shiftId, $shiftDate)
    {
        return $this->shiftRepository->findCurrentFinished($shiftId, $shiftDate);
    }

    public function updateShiftStatus($shiftId, $isStarted, $isFinished)
    {
        return $this->shiftRepository->updateStatus($shiftId, $isStarted, $isFinished);
    }

    public function updatePreviousShiftStatus($shiftId)
    {
        return $this->shiftRepository->finishPrevious($shiftId);
    }
}