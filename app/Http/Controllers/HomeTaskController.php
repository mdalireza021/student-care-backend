<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\HomeTask;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomeTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (auth()->user()->hasRole('Administrator')) {
            $homeTasks = HomeTask::all();
        } else {
            $homeTasks = HomeTask::with([
                'attachment',
                'students',
                'studentClass',
                'subject',
            ])
                ->where('published_by', optional(Auth::user()->teacher)->id)
                ->get();
        }

        // dd($homeTasks->toArray());

        return view('home_task.index', compact('homeTasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $teacherClasses = auth()->user()->teacher->class_ids;
        $classes = StudentClass::whereIn('id', $teacherClasses)->get();
        $subjects = Subject::all();
        // $students = Student::all();
        return view('home_task.create', compact('classes','subjects'));
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
            $inputs['published_by'] = Auth::user()->teacher->id;
            $inputs['published'] = date('Y-m-d H:i:s');
            $inputs['done_status'] = false;
            $inputs['marks'] = 0;

            $homeTask = HomeTask::create($inputs);

            // Store File
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileName = uniqid().".".$extension;
            $file = $request->file('file');
            $path = Storage::disk('public')->putFileAs('home_task', $file, $fileName);

            $attachment = new Attachment([
                'actual_name' => $file->getClientOriginalName(),
                'file_name' => $fileName,
                'path' => $path,
                'extension' => $extension,
            ]);

            $homeTask->attachment()->save($attachment);
            $students = Student::select('id')->where('student_class_id', $inputs['student_class_id'])->get();

            foreach ($students as $student) {
                $homeTask->students()->attach($student->id);
            }

            DB::commit();
            flash()->success('Home task has been added.');
            return redirect()->route('home-task.index');
        } catch (\Exception $exception) {
            flash()->error('Something went wrong, please try again later.');
            DB::rollBack();
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomeTask  $homeTask
     * @return \Illuminate\Http\Response
     */
    public function show(HomeTask $homeTask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeTask  $homeTask
     * @return \Illuminate\Http\Response
     */
    public function edit(HomeTask $homeTask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HomeTask  $homeTask
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HomeTask $homeTask)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomeTask  $homeTask
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(HomeTask $homeTask)
    {
        $homeTask->attachment()->delete();
        $homeTask->delete();
        flash()->success('Home Task has been deleted.');
        return back();
    }
}
