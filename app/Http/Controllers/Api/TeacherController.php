<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Attachment;
use App\Models\Designation;
use App\Models\School;
use App\Models\Shift;
use App\Models\StudentClass;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with([
            'user',
            'attachment','shift','section','school','designation','classes'])
            ->get();

        $data = [];

        foreach ($teachers as $teacher) {
            $data[] = [
                'name' => $teacher->fullname,
                'designation' => $teacher->designation->name,
                'email' => $teacher->user->email,
                'phone' => $teacher->phone,
                'area' => "test",
            ];
        }

        return response()->json(['status' => true, 'data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $titles = config('app.title');
        $genders = config('app.gender');
        $schools = School::all();
        $classes = StudentClass::with(['sections'])->get();
        $bloodTypes = config('app.blood_types');
        $shifts = Shift::all();
        $designations = Designation::all();

        return view('admin.teacher.create', compact('titles','schools','classes','bloodTypes','genders','shifts','designations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $inputs = $request->all();
            $user = $this->createUser($inputs);
            $inputs['user_id'] = $user->id;
            $teacher = Teacher::create($inputs);

            $address = new Address([
                'address' => $inputs['address']
            ]);

            $teacher->addresses()->save($address);
            $teacher->classes()->attach($inputs['class_id']);

            if ($file = $request->file('avatar')) {
                $extension = $file->getClientOriginalExtension();
                $fileName = uniqid().".".$extension;
                $path = Storage::disk('public')->putFileAs('teacher', $file, $fileName);

                $attachment = new Attachment([
                    'actual_name' => $file->getClientOriginalName(),
                    'file_name' => $fileName,
                    'path' => $path,
                    'extension' => $extension,
                ]);

                $teacher->attachment()->save($attachment);
            }

            DB::commit();

            flash()->success('Teacher has been added');
            return redirect()->route('teacher.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            flash()->error('Something went wrong, please try again.');
            return back()->withInput();
        }
    }

    private function createUser($inputs)
    {
        $inputs['email'] = $inputs['email'].config('app.domain_name');
        $inputs['password'] = bcrypt($inputs['password']);
        $fullName = $inputs['first_name'].$inputs['middle_name'].$inputs['last_name'];

        $user = User::create([
            'email' => $inputs['email'],
            'password' => $inputs['password'],
            'name' => $fullName,
        ]);

        $user->assignRole('teacher');
        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return Response
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Teacher $teacher)
    {
        $titles = config('app.title');
        $genders = config('app.gender');
        $schools = School::all();
        $classes = StudentClass::with(['sections'])->get();
        $bloodTypes = config('app.blood_types');
        $shifts = Shift::all();
        $designations = Designation::all();

        $teacher = Teacher::with([
            'currentAddress',
            'classes',
            'user' => function($q) {
                $q->select('id','email','name');
            }
        ])
            ->find($teacher->id);

        return view('admin.teacher.edit', compact('titles','schools','classes','bloodTypes','genders','shifts','designations','teacher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Teacher $teacher)
    {
        DB::beginTransaction();

        try {
            $inputs = $request->all();
            $this->updateUser($inputs, $teacher);
            $teacher->update($inputs);

            if ($inputs['address'] != $teacher->currentAddress->address) {
                $address = new Address([
                    'address' => $inputs['address']
                ]);

                if ($currentAddress = $teacher->addresses()->save($address)) {
                    $teacher->addresses()->where('id', '!=', $currentAddress->id)->update(['is_current' => false]);
                }
            }

            $teacher->classes()->sync($inputs['class_id']);

            // Store File
            if ($file = $request->file('avatar')) {
                $extension = $file->getClientOriginalExtension();
                $fileName = uniqid().".".$extension;
                $path = Storage::disk('public')->putFileAs('teacher', $file, $fileName);

                $attachment = new Attachment([
                    'actual_name' => $file->getClientOriginalName(),
                    'file_name' => $fileName,
                    'path' => $path,
                    'extension' => $extension,
                ]);

                $teacher->attachment()->delete();

                $teacher->attachment()->save($attachment);
            }

            DB::commit();

            flash()->success('Teacher has been updated');
            return redirect()->route('teacher.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            flash()->error('Something went wrong, please try again.');
            return back()->withInput();
        }
    }

    private function updateUser($inputs, $teacher)
    {
        $data = [];

        if ($teacher->user->email != $inputs['email']) {
            $data['email'] = $inputs['email'].config('app.domain_name');
        }

        if (!Hash::check($inputs['password'], $teacher->user->password)) {
            $data['password'] = bcrypt($inputs['password']);
        }

        $data['name'] = $inputs['first_name'].$inputs['middle_name'].$inputs['last_name'];

        if ($data) {
            return User::where('id', $teacher->user->id)->update($data);
        } else {
            return false;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Teacher $teacher)
    {
        try {
            $teacher->addresses()->delete();
            $teacher->delete();
            $teacher->user()->delete();

            flash()->success('Teacher has been deleted.');
            return redirect()->route('teacher.index');
        } catch (\Exception $exception) {
            flash()->error('Something went wrong, please try again later.');
        }

        return back();
    }
}
