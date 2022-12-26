<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\StudentClass;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Http\Request;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $classes = StudentClass::all();
        return view('attendance.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $teacher = Teacher::select('id','user_id')
            ->where('user_id', Auth::id())
            ->first();

        $teacherClasses = $teacher->class_ids;

        $classes = StudentClass::whereIn('id', $teacherClasses)->get();
        return view('attendance.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function store(Request $request)
    {
        $studentClassId = $request->input('student_class_id');
        $attendanceDate = Carbon::parse($request->input('attendance_date'));

        if (auth()->user()->hasRole('Administrator')) {
            $attendances = Attendance::where('attendance_date', $attendanceDate->format('Y-m-d'))
                ->where('student_class_id', $studentClassId)
                ->with([
                    'attendanceTaker' => function($q) {
                        $q->select('id','user_id','first_name','middle_name','last_name','title');
                    },
                    'student' => function($q) {
                        $q->select('id','first_name','middle_name','last_name');
                    },
                    'studentClass'
                ])
                ->get();

            $classes = StudentClass::all();
            session()->flashInput($request->input());

            return view('attendance.index', compact('attendances','classes'));
        } elseif (auth()->user()->hasRole('Teacher')) {
            $studentClass = StudentClass::find($studentClassId);
            $students = Student::where('student_class_id', $studentClassId)->get();
            $presentStudents = $request->input('students');
            $insertData = $updateData = [];
            $attendances = Attendance::where('attendance_date', $attendanceDate->format('Y-m-d'))
                ->where('student_class_id', $studentClassId)
                ->where('attendance_taker_id', Auth::id())
                ->get()
                ->toArray();

            foreach ($students as $student) {
                if ($attendances) {
                    $filteredAttendance = array_values(array_filter($attendances, function ($att) use ($student) {
                        return $att['student_id'] == $student->id;
                    }));

                    if (count($filteredAttendance) > 0) {
                        $filteredAttendance = $filteredAttendance[0];
                        if ($presentStudents) {
                            if ($filteredAttendance['attendance_type'] && in_array($filteredAttendance['student_id'], $presentStudents)) {
                                //
                            } else {
                                $updateData[$filteredAttendance['id']] = in_array($student->id, $presentStudents) ? true : false;
                            }
                        } else {
                            $updateData[$filteredAttendance['id']] = false;
                        }
                    } else {
                        $insertData[] = [
                            'attendance_taker_id' => optional(Auth::user()->teacher())->id,
                            'student_id' => $student->id,
                            'student_class_id' => $studentClassId,
                            'attendance_date' => $attendanceDate->format('Y-m-d'),
                            'attendance_type' => $presentStudents ? in_array($student->id, $presentStudents) ? true : false : false,
                            'day' => $attendanceDate->day,
                            'month' => $attendanceDate->month,
                            'year' => $attendanceDate->year,
                            'created_at' => date('Y-m-d H:i:s'),
                        ];
                    }
                } else {
                    $insertData[] = [
                        'attendance_taker_id' => Auth::id(),
                        'student_id' => $student->id,
                        'student_class_id' => $studentClassId,
                        'attendance_date' => $attendanceDate->format('Y-m-d'),
                        'attendance_type' => $presentStudents ? in_array($student->id, $presentStudents) ? true : false : false,
                        'day' => $attendanceDate->day,
                        'month' => $attendanceDate->month,
                        'year' => $attendanceDate->year,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                }
            }

            // dd($insertData, $updateData);

            if ($insertData) {
                Attendance::insert($insertData);
            }

            if ($updateData) {
                foreach ($updateData as $attendanceId => $attendanceType) {
                    Attendance::where('id', $attendanceId)
                        ->update([
                            'attendance_type' => $attendanceType,
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
                }
            }

            flash()->success('Attendance has been taken for Class: '.$studentClass->name.' Date: '.$attendanceDate->format('d F Y'));
            return redirect()->route('attendance.create');
        } else {
            flash()->warning('Invalid request');
            return redirect('home');
        }
    }
}
