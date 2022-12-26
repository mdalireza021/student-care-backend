<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Attachment;
use App\Models\Designation;
use App\Models\School;
use App\Models\Shift;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (auth()->user()->hasRole('Administrator')) {
            $students = Student::all();
        } else {
            $teacherClasses = Teacher::where('user_id', Auth::id())->first();
            $students = Student::whereIn('student_class_id', $teacherClasses->class_ids)->get();
        }

        return view('student.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $genders = config('app.gender');
        $schools = School::all();
        $classes = StudentClass::with(['sections'])->get();
        $bloodTypes = config('app.blood_types');
        $shifts = Shift::all();

        return view('student.create', compact('schools','classes','bloodTypes','genders','shifts'));
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
            $inputs['id_no'] = (int)floor(time() - 999999999);

            $student = Student::create($inputs);

            $address = new Address([
                'address' => $inputs['address']
            ]);

            $student->addresses()->save($address);

            if ($file = $request->file('avatar')) {
                $extension = $file->getClientOriginalExtension();
                $fileName = uniqid().".".$extension;
                $path = Storage::disk('public')->putFileAs('student', $file, $fileName);

                $attachment = new Attachment([
                    'actual_name' => $file->getClientOriginalName(),
                    'file_name' => $fileName,
                    'path' => $path,
                    'extension' => $extension,
                ]);

                $student->attachment()->save($attachment);
            }

            DB::commit();

            flash()->success('Student successfully added.');
            return redirect()->route('student.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            flash()->error('Something went wrong, please try again later.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Student $student)
    {
        $genders = config('app.gender');
        $schools = School::all();
        $classes = StudentClass::with(['sections'])->get();
        $bloodTypes = config('app.blood_types');
        $shifts = Shift::all();

        $student = Student::with([
            'currentAddress'
        ])
            ->find($student->id);

        return view('student.edit', compact('schools','classes','bloodTypes','genders','shifts','student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Student $student)
    {
        DB::beginTransaction();

        try {
            $inputs = $request->all();
            $student->update($inputs);

            if ($inputs['address'] != optional($student->currentAddress)->address) {
                $address = new Address([
                    'address' => $inputs['address']
                ]);

                if ($currentAddress = $student->addresses()->save($address)) {
                    $student->addresses()->where('id', '!=', $currentAddress->id)->update(['is_current' => false]);
                }
            }

            // Update File
            if ($file = $request->file('avatar')) {
                $extension = $file->getClientOriginalExtension();
                $fileName = uniqid().".".$extension;
                $path = Storage::disk('public')->putFileAs('student', $file, $fileName);

                $attachment = new Attachment([
                    'actual_name' => $file->getClientOriginalName(),
                    'file_name' => $fileName,
                    'path' => $path,
                    'extension' => $extension,
                ]);

                $student->attachment()->delete();
                $student->attachment()->save($attachment);
            }

            DB::commit();

            flash()->success('Student has been updated');
            return redirect()->route('student.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            flash()->error('Something went wrong, please try again.');
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Student $student)
    {
        try {
            $student->addresses()->delete();
            $student->delete();

            flash()->success('Student has been deleted.');
            return redirect()->route('student.index');
        } catch (\Exception $exception) {
            flash()->error('Something went wrong, please try again later.');
        }

        return back();
    }
}
