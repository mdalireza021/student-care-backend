<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $shifts = Shift::all();
        return view('admin.shift.index', compact('shifts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.shift.create');
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
            Shift::create($request->all());
            flash()->success('Shift has been added');
        } catch (\Exception $exception) {
            flash()->error('Something went wrong, please try again.');
        }

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Shift $shift)
    {
        return view('admin.shift.edit', compact('shift'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Shift $shift)
    {
        try {
            $shift->name = $request->input('name');
            $shift->save();
            flash()->success('Shift has been updated');
        } catch (\Exception $exception) {
            flash()->error('Something went wrong, please try again.');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Shift $shift)
    {
        try {
            $shift->delete();
            flash()->success('Shift has been deleted');
        } catch (\Exception $exception) {
            flash()->error('Something went wrong, please try again.');
        }

        return back();
    }
}
