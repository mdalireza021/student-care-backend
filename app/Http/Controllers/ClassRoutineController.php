<?php

namespace App\Http\Controllers;

use App\Models\ClassRoutine;
use App\Models\StudentClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class ClassRoutineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $studentClasses = StudentClass::all()->pluck('name','id')->toArray();
        $days = config('app.days');
        $routines = ClassRoutine::all()->groupBy(['student_class_id','day']);

        // dd($studentClasses);

        return view('class_routine.index', compact('studentClasses','days','routines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $subjects = Subject::all();
        $classes = StudentClass::all();
        return view('class_routine.create', compact('subjects','classes'));
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
            ClassRoutine::create($inputs);
            flash()->success('Class Routine has been added');
            return redirect()->route('routine.index');
        } catch (\Exception $exception) {
            flash()->error('Something went wrong, please try again.');
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClassRoutine  $classRoutine
     * @return \Illuminate\Http\Response
     */
    public function show(ClassRoutine $classRoutine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClassRoutine  $classRoutine
     * @return \Illuminate\Http\Response
     */
    public function edit(ClassRoutine $classRoutine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClassRoutine  $classRoutine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClassRoutine $classRoutine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClassRoutine  $classRoutine
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ClassRoutine $classRoutine)
    {
        try {
            $classRoutine->delete();
            flash()->success('Class Routine has been deleted');
            return redirect()->route('routine.index');
        } catch (\Exception $exception) {
            flash()->error('Something went wrong, please try again.');
        }

        return back();
    }
}
