<?php

namespace App\Repositories;

use App\Models\Shift;

class ShiftRepository
{
    public function findByTime(string $eventRecord): ?Shift
    {
        return Shift::whereTime('start_time', '<=', $eventRecord)
            ->whereTime('end_time', '>=', $eventRecord)
            ->first();
    }

    public function findPreviousStarted(int $shiftId): ?Shift
    {
        return Shift::where('id', '!=', $shiftId)
            ->where('is_started', 1)
            ->first();
    }

    public function findCurrentFinished(int $shiftId, string $shiftDate): ?Shift
    {
        return Shift::where('id', $shiftId)
            ->where('is_finished', 1)
            ->whereDate('updated_at', $shiftDate)
            ->first();
    }

    public function updateStatus(int $shiftId, bool $isStarted, bool $isFinished): ?Shift
    {
        $shift = Shift::find($shiftId);
        if ($shift) {
            $shift->is_started = $isStarted;
            $shift->is_finished = $isFinished;
            $shift->save();
        }
        return $shift;
    }

    public function finishPrevious(int $shiftId): ?Shift
    {
        $shift = Shift::where('id', '!=', $shiftId)
            ->where('is_started', 1)
            ->first();
        if ($shift) {
            $shift->is_started = 0;
            $shift->is_finished = 1;
            $shift->save();
        }
        return $shift;
    }
}