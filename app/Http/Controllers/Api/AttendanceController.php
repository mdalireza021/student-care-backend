<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function show($studentId)
    {
        $today = Carbon::now();
        $attendances = Attendance::where('student_id', $studentId)
            ->where('month', $today->month)
            ->where('year', $today->year)
            // ->get()
            ->pluck('attendance_type', 'day')
            ->toArray();

        $data = [];
        $fridays = [];
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        $firstFriday = $start->next(Carbon::FRIDAY);

        for ($date = $firstFriday; $date->lte($end); $date->addWeek()) {
            $fridays[] = $date->format('d');
        }

        for ($startDay = $start->startOfMonth()->day;$startDay <= $end->day;$startDay++) {
            if (in_array($startDay, $fridays)) {
                $data[$startDay] = 2;
            } elseif (array_key_exists($startDay, $attendances)) {
                if ($attendances[$startDay] == 1) {
                    $data[$startDay] = 1;
                } else {
                    $data[$startDay] = 0;
                }
            } else {
                $data[$startDay] = 3;
            }
        }

        $data = [$data];

        return response()->json(['status' => true, 'data' => $data]);
    }
}
