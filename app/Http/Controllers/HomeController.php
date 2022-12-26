<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalStudents = Student::all()->count();
        $totalTeachers = Teacher::all()->count();
        $totalGuardians = Guardian::all()->count();
        $totalPresents = Attendance::where('attendance_date', date('Y-m-d'))
            ->where('attendance_type', 1)
            ->get()
            ->count();
        return view('home', compact('totalStudents','totalTeachers','totalGuardians','totalPresents'));
    }
}
