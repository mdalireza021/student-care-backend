<?php

namespace App\Http\Controllers;

use App\Models\AcademicResult;
use App\Models\Exam;
use App\Models\Student;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcademicResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $academicResults = AcademicResult::all();
        return view('academic_result.index', compact('academicResults'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $exams = Exam::all();
        $classes = StudentClass::all();
        $students = Student::all();
        return view('academic_result.create', compact('exams','students','classes'));
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
            $inputs = $request->all();
            $inputs['examine_id'] = Auth::id();
            $inputs['serial'] = 1;

            // dd($inputs);
            AcademicResult::create($inputs);
            flash()->success('Academic Result has been added');
            return redirect()->route('academic-result.index');
        } catch (\Exception $exception) {
            flash()->error('Something went wrong, please try again.');
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AcademicResult  $academicResult
     * @return \Illuminate\Http\Response
     */
    public function show(AcademicResult $academicResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AcademicResult  $academicResult
     * @return \Illuminate\Http\Response
     */
    public function edit(AcademicResult $academicResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AcademicResult  $academicResult
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AcademicResult $academicResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AcademicResult  $academicResult
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(AcademicResult $academicResult)
    {
        try {
            $academicResult->delete();
            flash()->success('Academic Result has been deleted');
            return redirect()->route('academic-result.index');
        } catch (\Exception $exception) {
            flash()->error('Something went wrong, please try again.');
        }

        return back();
    }
}
