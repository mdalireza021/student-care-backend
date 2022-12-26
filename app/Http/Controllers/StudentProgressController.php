<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentClass;
use App\Models\StudentProgress;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (auth()->user()->hasRole('Administrator')) {
            $academicProgress = StudentProgress::all();
        } else {
            $academicProgress = StudentProgress::with([
                'student',
                'studentClass',
            ])
                ->where('teacher_id', Auth::user()->teacher->id)
                ->get();
        }

        return view('academic_progress.index', compact('academicProgress'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $teacherClasses = Teacher::where('user_id', Auth::id())->first();
        $classes = StudentClass::whereIn('id', $teacherClasses->class_ids)->get();
        $students = Student::whereIn('student_class_id', $teacherClasses->class_ids)->get();
        return view('academic_progress.create', compact('classes','students'));
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
            DB::beginTransaction();
            $inputs = $request->all();
            $inputs['teacher_id'] = Auth::user()->teacher->id;
            $inputs['date'] = Carbon::now();
            StudentProgress::create($inputs);
            DB::commit();
            flash()->success('Academic progress has been added.');
            return redirect()->route('student-progress.index');
        } catch (\Exception $exception) {
            flash()->error('Something went wrong, please try again later.');
            DB::rollBack();
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentProgress  $studentProgress
     * @return \Illuminate\Http\Response
     */
    public function show(StudentProgress $studentProgress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentProgress  $studentProgress
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentProgress $studentProgress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentProgress  $studentProgress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentProgress $studentProgress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentProgress  $studentProgress
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentProgress $studentProgress)
    {
        //
    }
}
