<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\Syllabus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SyllabusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $syllabuses = Syllabus::all();
        return view('syllabus.index', compact('syllabuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = StudentClass::all();
        $subjects = Subject::all();
        return view('syllabus.create', compact('classes','subjects'));
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
            $libraries = Syllabus::all()->count();
            $serial = $libraries + 1;
            $inputs['serial'] = $serial;
            $inputs['file'] = $request->file('file')->store('syllabus');

            $syllabus = Syllabus::create($inputs);

            // Store File
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileName = uniqid().".".$extension;
            $path = Storage::disk('public')->putFileAs('syllabus', $file, $fileName);

            $attachment = new Attachment([
                'actual_name' => $file->getClientOriginalName(),
                'file_name' => $fileName,
                'path' => $path,
                'extension' => $extension,
            ]);

            $syllabus->attachment()->save($attachment);
            flash()->success('Syllabus has been added.');

            return redirect()->route('syllabus.index');
        } catch (\Exception $exception) {
            flash()->error('Something went wrong, please try again later.');
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Syllabus  $syllabus
     * @return \Illuminate\Http\Response
     */
    public function show(Syllabus $syllabus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Syllabus  $syllabus
     * @return \Illuminate\Http\Response
     */
    public function edit(Syllabus $syllabus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Syllabus  $syllabus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Syllabus $syllabus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Syllabus  $syllabus
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $syllabus = Syllabus::find($id);
        $syllabus->attachment()->delete();
        $syllabus->delete();
        flash()->success('Syllabus has been deleted.');
        return back();
    }
}
