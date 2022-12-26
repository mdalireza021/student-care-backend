<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Attachment;
use App\Models\Designation;
use App\Models\School;
use App\Models\Shift;
use App\Models\StudentClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = User::with([
            'teacher' => function($q) {
                $q->with('classes','shift','designation','attachment');
            }
        ])
        ->where('id', Auth::id())
        ->first();

        $titles = config('app.title');
        $genders = config('app.gender');
        $schools = School::all();
        $classes = StudentClass::with(['sections'])->get();
        $bloodTypes = config('app.blood_types');
        $shifts = Shift::all();
        $designations = Designation::all();

        // dd($user->toArray());

        return view('profile', compact('user','titles','schools','classes','bloodTypes','genders','shifts','designations'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $user = auth()->user();
            $inputs = $request->all();
            // dd($inputs);

            if (auth()->user()->hasRole('Teacher')) {
                $user = $user->teacher;
                $this->updateUser($inputs, $user);
                $user->update($inputs);

                if ($inputs['address'] != $user->currentAddress->address) {
                    $address = new Address([
                        'address' => $inputs['address']
                    ]);

                    if ($currentAddress = $user->addresses()->save($address)) {
                        $user->addresses()->where('id', '!=', $currentAddress->id)->update(['is_current' => false]);
                    }
                }

                $user->classes()->sync($inputs['class_id']);
            } else {
                $user->name = $request->get('name');
                if ($request->get('password')) {
                    $user->password = bcrypt($request->get('password'));
                }

                $user->save();
            }

            // Store File
            if ($file = $request->file('avatar')) {
                $folderName = auth()->user()->hasRole('Teacher') ? 'teacher' : 'admin';
                $extension = $file->getClientOriginalExtension();
                $fileName = uniqid() . "." . $extension;
                $path = Storage::disk('public')->putFileAs($folderName, $file, $fileName);

                $attachment = new Attachment([
                    'actual_name' => $file->getClientOriginalName(),
                    'file_name' => $fileName,
                    'path' => $path,
                    'extension' => $extension,
                ]);

                $user->attachment()->delete();
                $user->attachment()->save($attachment);
            }

            DB::commit();
            flash()->success('Profile has been updated.');
        } catch (\Exception $exception) {
            flash()->error('Something went wrong, please try again.');
        }

        return back();
    }

    private function updateUser($inputs, $teacher)
    {
        $data = [];

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
}
