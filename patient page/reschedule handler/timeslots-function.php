<?php

function timeslots()
{
    // Define slot parameters within the function
    $duration = 30; // Duration of each slot in minutes
    $cleanup = 0;  // Cleanup time in minutes
    $start = "08:00"; // Start time
    $end = "17:00";   // End time

    // Define lunch break period
    $lunch_start = "12:00"; // Lunch start time
    $lunch_end = "13:00";   // Lunch end time

    $start = new DateTime($start);
    $end = new DateTime($end);
    $lunch_start = new DateTime($lunch_start);
    $lunch_end = new DateTime($lunch_end);

    $interval = new DateInterval("PT" . $duration . "M");
    $cleanupInterval = new DateInterval("PT" . $cleanup . "M");
    $slots = [];

    for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)) {
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);

        // Skip the lunch break period
        if ($intStart >= $lunch_start && $intStart < $lunch_end) {
            continue;
        }

        if ($endPeriod > $end) {
            break;
        }

        $slots[] = $intStart->format("g:iA") . " - " . $endPeriod->format("g:iA");
    }

    return $slots;
}
