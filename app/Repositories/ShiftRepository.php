<?php

namespace App\Repositories;

use App\Models\Shift;

class ShiftRepository
{
    public function findByTime($eventRecord)
    {
        return Shift::whereTime('start_time', '<=', $eventRecord)
            ->whereTime('end_time', '>=', $eventRecord)
            ->first();
    }

    public function findPreviousStarted($shiftId)
    {
        return Shift::where('id', '!=', $shiftId)
            ->where('is_started', 1)
            ->first();
    }

    public function findCurrentFinished($shiftId, $shiftDate)
    {
        return Shift::where('id', $shiftId)
            ->where('is_finished', 1)
            ->whereDate('updated_at', $shiftDate)
            ->first();
    }

    public function updateStatus($shiftId, $isStarted, $isFinished)
    {
        $shift = Shift::find($shiftId);
        if ($shift) {
            $shift->is_started = $isStarted;
            $shift->is_finished = $isFinished;
            $shift->save();
        }
        return $shift;
    }

    public function finishPrevious($shiftId)
    {
        $shift = Shift::where('id', '!=', $shiftId)->first();
        if ($shift) {
            $shift->is_started = 0;
            $shift->is_finished = 1;
            $shift->save();
        }
        return $shift;
    }
}