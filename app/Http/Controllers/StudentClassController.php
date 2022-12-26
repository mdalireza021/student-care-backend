<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentClass;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $studentClasses = StudentClass::all();
        return view('admin.class.index', compact('studentClasses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.class.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            StudentClass::create($request->all());
            flash()->success('Class has been added');
        } catch (\Exception $exception) {
            flash()->error('Something went wrong, please try again.');
        }

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentClass  $studentClass
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(StudentClass $studentClass)
    {
        return view('admin.class.edit', compact('studentClass'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentClass  $studentClass
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, StudentClass $studentClass)
    {
        try {
            $studentClass->name = $request->input('name');
            $studentClass->total_students = $request->input('total_students');
            $studentClass->save();
            flash()->success('Class has been updated');
        } catch (\Exception $exception) {
            flash()->error('Something went wrong, please try again.');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentClass  $studentClass
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(StudentClass $studentClass)
    {
        try {
            $studentClass->delete();
            flash()->success('Class has been deleted');
        } catch (\Exception $exception) {
            flash()->error('Something went wrong, please try again.');
        }

        return back();
    }

    public function getStudentAttendance(Request $request)
    {
        $date = $request->input('attendance_date');
        $classId = $request->input('class_id');

        if ($date) {
            $date = Carbon::parse($date)->format('Y-m-d');

            $students = Student::select('id','first_name','last_name','middle_name','roll_number')
                ->with([
                    'attendances' => function($q) use ($date) {
                        $q->where('attendance_date', $date);
                    }
                ])
                ->where('student_class_id', $classId)
                ->get();
        } else {
            $students = Student::select('id','first_name','last_name','middle_name','roll_number')
                ->where('student_class_id', $classId)
                ->get();
        }

        return response()->json(['students' => $students, 'status' => true]);
    }
}
