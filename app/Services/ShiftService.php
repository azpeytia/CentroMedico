<?php

namespace App\Services;

use App\Repositories\ShiftRepository;

class ShiftService
{
    protected $shiftRepository;

    public function __construct(ShiftRepository $shiftRepository)
    {
        $this->shiftRepository = $shiftRepository;
    }

    public function getShiftInformation($eventRecord)
    {
        return $this->shiftRepository->findByTime($eventRecord);
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