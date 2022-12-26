<?php

namespace App\Http\Controllers;

use App\Models\StudentClass;
use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::all();
        return view('admin.subject.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = StudentClass::all();
        return view('admin.subject.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            Subject::create($request->all());
            flash()->success('Subject has been added');
            return redirect()->route('subject.index');
        } catch (\Exception $exception) {
            flash()->error('Something went wrong, please try again.');
        }

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        $classes = StudentClass::all();
        return view('admin.subject.edit', compact('subject', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Subject $subject, Request $request)
    {
        try {
            $subject->student_class_id = $request->input('student_class_id');
            $subject->name = $request->input('name');
            $subject->code = $request->input('code');
            $subject->preferred_books = $request->input('preferred_books');
            $subject->save();
            flash()->success('Subject has been updated');
            return redirect()->route('subject.index');
        } catch (\Exception $exception) {
            flash()->error('Something went wrong, please try again.');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        try {
            $subject->delete();
            flash()->success('Subject has been deleted');
            return redirect()->route('subject.index');
        } catch (\Exception $exception) {
            flash()->error('Something went wrong, please try again.');
        }

        return back();
    }

    public function getSubjectByClassId(Request $request)
    {
        $data = [];
        $classIds = $request->get('class_id');

        if ($classIds) {
            $subjects = Subject::whereIn('student_class_id', $classIds)->get();

            foreach ($subjects as $subject) {
                $data[] = [
                    'id' => $subject->id,
                    'code' => $subject->code,
                    'name' => $subject->name
                ];
            }
        }

        return $data;
    }
}
