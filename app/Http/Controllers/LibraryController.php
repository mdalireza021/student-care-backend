<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\StudentClass;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $libraries = Library::all();
        return view('library.index', compact('libraries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $classes = StudentClass::all();
        $subjects = Subject::all();

        return view('library.create', compact('classes','subjects'));
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
            $libraries = Library::all()->count();
            $serial = $libraries + 1;
            $inputs['serial'] = $serial;

            $file = $request->file('file');
            $inputs['file'] = Storage::disk('public')->putFile('library', $file);

            Library::create($inputs);
            flash()->success('Book has been added to library.');

            return redirect()->route('library.index');
        } catch (\Exception $exception) {
            flash()->error('Something went wrong, please try again later.');
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function show(Library $library)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function edit(Library $library)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Library $library)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Library  $library
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Library $library)
    {
        $library->delete();
        flash()->success('Book from Library has been deleted.');
        return back();
    }
}
