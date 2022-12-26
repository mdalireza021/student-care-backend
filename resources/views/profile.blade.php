@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <b>
                {{ __('My Profile') }}
            </b>
        </div>

        <div class="card-body">
            <form action="{{ route('profile.store') }}" method="post" class="" enctype="multipart/form-data">
                @csrf

                <div class="form-row">
                    @if(auth()->user()->hasRole("Teacher"))
                    <div class="form-group col-md-2">
                        <label for="title" class="required">Title</label>
                        <select id="title" class="form-control" name="title">
                            <option value="">Choose</option>
                            @foreach($titles as $value => $name)
                                <option value="{{ $value }}" @if(old('title', $user->teacher->getRawOriginal('title')) == $value) {{ "selected" }} @endif>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="first_name" class="required">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $user->teacher->first_name) }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="middle_name">Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ old('middle_name', $user->teacher->middle_name) }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="last_name" class="required">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $user->teacher->last_name) }}">
                    </div>
                    @else
                        <div class="form-group col-md-3">
                            <label for="name" class="required">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
                        </div>
                    @endif

                    @if(auth()->user()->hasRole("Teacher"))
                    <div class="form-group col-md-3">
                        <label for="gender" class="required">Gender</label>
                        <select id="gender" class="form-control" name="gender">
                            <option value="">Choose...</option>
                            @foreach($genders as $value => $name)
                                <option value="{{ $value }}" @if(old('gender', $user->teacher->getRawOriginal('gender')) == $value) {{ "selected" }} @endif>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="blood_type">Blood Type</label>
                        <select id="blood_type" class="form-control" name="blood_type">
                            <option value="">Choose...</option>
                            @foreach($bloodTypes as $value => $name)
                                <option value="{{ $value }}" @if(old('blood_type', $user->teacher->getRawOriginal('blood_type')) == $value) {{ "selected" }} @endif>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="shift_id" class="required">Shift</label>
                        <input type="text" id="shift_id" disabled value="{{ optional($user->teacher->shift)->name }}" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="designation_id" class="required">Designation</label>
                        <input type="text" id="designation_id" disabled value="{{ optional($user->teacher->designation)->name }}" class="form-control">
                    </div>
                    @endif
                </div>

                @if(auth()->user()->hasRole("Teacher"))
                    @php
                        $classes = [];
                        $subjects = [];

                        if (optional($user->teacher)->classes) {
                            foreach (optional($user->teacher)->classes as $teacherClass) {
                                $classes[] = $teacherClass->name;
                            }
                        }

                        if (optional($user->teacher)->subjects) {
                            foreach (optional($user->teacher)->subjects as $teacherSubject) {
                                $subjects[] = $teacherSubject->name;
                            }
                        }
                    @endphp
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->teacher->phone) }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="class_id">Classes</label>
                            <input type="text" class="form-control" disabled id="class_id" value="{{ count($classes) ? implode(', ', $classes) : "N/A" }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="section_id">Section</label>
                            <input type="text" id="section_id" disabled value="{{ optional($user->teacher->section)->name }}" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="school_id">School</label>
                            <input type="text" id="school_id" disabled value="{{ optional($user->teacher->school)->name }}" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="subject_id">Subject</label>
                            <input type="text" class="form-control" disabled id="subject_id" value="{{ count($subjects) ? implode(', ', $subjects) : "N/A" }}">
                        </div>
                    </div>
                @endif

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="login_id" class="required">Login ID/Username</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="login_id" disabled value="{{ $user->email }}">
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="password" class="">Password</label>
                        <input type="text" class="form-control" id="password" name="password" value="{{ old('password') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="avatar" class="">Avatar</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="avatar" aria-describedby="avatar" name="avatar">
                            <label class="custom-file-label" for="question">Choose file</label>
                        </div>
                    </div>
                    @if(auth()->user()->hasRole("Teacher"))
                    <div class="form-group col-md-2">
                        <img class="img-fluid rounded" src="{{ optional($user->teacher)->attachment ? url('storage/'.$user->teacher->attachment->path) : "#" }}" alt="{{ optional($user->teacher)->attachment ? $user->teacher->attachment->actual_name : "#" }}">
                    </div>
                    @else
                    <div class="form-group col-md-2">
                        <img class="img-fluid rounded" src="{{ $user->attachment ? url('storage/'.$user->attachment->path) : "#" }}" alt="{{ $user->attachment ? $user->attachment->actual_name : "#" }}">
                    </div>
                    @endif
                </div>
                @if(auth()->user()->hasRole("Teacher"))
                <div class="form-group">
                    <label for="address" class="required">Address</label>
                    <textarea class="form-control" id="address" name="address">{{ old('address', optional($user->teacher->currentAddress)->address) }}</textarea>
                </div>
                @endif

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-sm">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
@endsection
