<?php

namespace App\Services;

use Carbon\Carbon;

class TimeService
{
    public function generateTimeRange(string $from, string $to)
    {
        $time = Carbon::parse($from);
        $endTime = Carbon::parse($to);
        $interval = 45;

        $timeRange = [];
        while ($time < $endTime) {
            $timeRange[] = [
                'start' => $time->format("H:i:s"),
                'end' => $time->addMinutes($interval)->format("H:i:s")
            ];
        }

        return $timeRange;
    }
}