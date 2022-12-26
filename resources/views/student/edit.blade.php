@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <b>
                {{ __('Edit Student - '.$student->fullname) }}
            </b>
        </div>

        <div class="card-body">
            <form action="{{ route('student.update', $student->id) }}" method="post" class="" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="first_name" class="required">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $student->first_name) }}" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="middle_name">Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ old('middle_name', $student->middle_name) }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="last_name" class="required">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $student->last_name) }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="gender" class="required">Gender</label>
                        <select id="gender" class="form-control" name="gender" required>
                            <option value="">Choose...</option>
                            @foreach($genders as $value => $name)
                                <option value="{{ $value }}" @if(old('gender', $student->getRawOriginal('gender')) == $value) {{ "selected" }} @endif>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="blood_type" class="required">Blood Type</label>
                        <select id="blood_type" class="form-control" name="blood_type" required>
                            <option value="">Choose...</option>
                            @foreach($bloodTypes as $value => $name)
                                <option value="{{ $value }}" @if(old('blood_type', $student->getRawOriginal('blood_type')) == $value) {{ "selected" }} @endif>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="student_class_id" class="required">Class</label>
                        <select id="student_class_id" class="form-control" name="student_class_id" required>
                            <option value="">Choose...</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" @if(old('student_class_id', $student->student_class_id) == $class->id) {{ "selected" }} @endif>{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="shift_id">Shift</label>
                        <select id="shift_id" class="form-control" name="shift_id" required>
                            <option value="">Choose...</option>
                            @foreach($shifts as $shift)
                                <option value="{{ $shift->id }}" @if(old('shift_id', $student->shift_id) == $shift->id) {{ "selected" }} @endif>{{ $shift->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="roll_number" class="required">Roll Number</label>
                        <input type="text" class="form-control" id="roll_number" name="roll_number" value="{{ old('roll_number', $student->roll_number) }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="section_id" class="">Section</label>
                        <select id="section_id" class="form-control" name="section_id">
                            <option value="">Choose...</option>
                            @foreach($classes as $class)
                                @foreach($class->sections as $section)
                                    <option value="{{ $section->id }}" @if(old('section_id', $student->section_id) == $section->id) {{ "selected" }} @endif>{{ $section->name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="school_id" class="">School</label>
                        <select id="school_id" class="form-control" name="school_id">
                            <option value="">Choose...</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}" @if(old('school_id', $student->school_id) == $school->id) {{ "selected" }} @endif>{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="">Student ID</label>
                        <input class="form-control" type="text" disabled value="{{ $student->id_no }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="avatar" class="required">Avatar</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="avatar" aria-describedby="avatar" name="avatar" required>
                            <label class="custom-file-label" for="question">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <img class="img-fluid rounded" src="{{ $student->attachment ? url('storage/'.$student->attachment->path) : "#" }}" alt="{{ $student->attachment ? $student->attachment->actual_name : "#" }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" id="address" name="address" required>{{ old('address', optional($student->currentAddress)->address) }}</textarea>
                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-sm">Update Student</button>
                </div>
            </form>
        </div>
    </div>
@endsection
