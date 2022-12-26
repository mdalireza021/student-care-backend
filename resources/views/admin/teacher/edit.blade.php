@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <b>
                {{ __('Edit Teacher - ' . $teacher->fullname) }}
            </b>
        </div>

        <div class="card-body">
            <form action="{{ route('teacher.update', $teacher->id) }}" method="post" class="" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="title" class="required">Title</label>
                        <select id="title" class="form-control" name="title">
                            <option value="">Choose</option>
                            @foreach($titles as $value => $name)
                                <option value="{{ $value }}" @if(old('title', $teacher->getRawOriginal('title')) == $value) {{ "selected" }} @endif>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="first_name" class="required">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $teacher->first_name) }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="middle_name">Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ old('middle_name', $teacher->middle_name) }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="last_name" class="required">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $teacher->last_name) }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="gender" class="required">Gender</label>
                        <select id="gender" class="form-control" name="gender">
                            <option value="">Choose...</option>
                            @foreach($genders as $value => $name)
                                <option value="{{ $value }}" @if(old('gender', $teacher->getRawOriginal('gender')) == $value) {{ "selected" }} @endif>
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
                                <option value="{{ $value }}" @if(old('blood_type', $teacher->getRawOriginal('blood_type')) == $value) {{ "selected" }} @endif>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="shift_id" class="required">Shift</label>
                        <select id="shift_id" class="form-control" name="shift_id">
                            <option value="">Choose...</option>
                            @foreach($shifts as $shift)
                                <option value="{{ $shift->id }}" @if(old('shift_id', $teacher->shift_id) == $shift->id) {{ "selected" }} @endif>{{ $shift->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="designation_id" class="required">Designation</label>
                        <select id="designation_id" class="form-control" name="designation_id">
                            <option value="">Choose...</option>
                            @foreach($designations as $designation)
                                <option value="{{ $designation->id }}" @if(old('designation_id', $teacher->designation_id) == $designation->id) {{ "selected" }} @endif>{{ $designation->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $teacher->phone) }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="class_id">Classes</label>
                        <select id="class_id" class="form-control edit-selectpicker" multiple name="class_id[]">
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" @if(in_array(old('class_id', $class->id), $teacher->classIds)) {{ "selected" }} @endif>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="section_id">Section</label>
                        <select id="section_id" class="form-control" name="section_id">
                            <option value="">Choose...</option>
                            @foreach($classes as $class)
                                @foreach($class->sections as $section)
                                    <option value="{{ $section->id }}" @if(old('section_id', $teacher->section_id) == $section->id) {{ "selected" }} @endif>{{ $section->name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="school_id">School</label>
                        <select id="school_id" class="form-control" name="school_id">
                            <option value="">Choose...</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}" @if(old('school_id', $teacher->school_id) == $school->id) {{ "selected" }} @endif>{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="subject_id">Select Subject(s)</label>
                        <select id="subject_id" class="form-control edit-selectpicker" name="subject_id[]" multiple required>
                            @foreach($classes as $class)
                                <optgroup label="{{ $class->name }}">
                                @foreach($class->subjects as $subject)
                                    <option data-chained="{{ $class->id }}" value="{{ $subject->id }}" @if(in_array(old('subject_id', $subject->id), $teacher->subjectIds)) {{ "selected" }} @endif>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="login_id" class="required">Login ID/Username</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="login_id" name="email" value="{{ old('email', str_replace(config('app.domain_name'), '', $teacher->user->email)) }}">
                            <div class="input-group-append">
                                <span class="input-group-text" id="domain_name">
                                    {{ config('app.domain_name') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="password" class="">Password</label>
                        <input type="text" class="form-control" id="password" name="password" value="{{ old('password') }}">
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-md-3">
                        <label for="avatar" class="required">Avatar</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="avatar" aria-describedby="avatar" name="avatar">
                            <label class="custom-file-label" for="question">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <img class="img-fluid rounded" src="{{ $teacher->attachment ? url('storage/'.$teacher->attachment->path) : "#" }}" alt="{{ $teacher->attachment ? $teacher->attachment->actual_name : "#" }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="required">Address</label>
                    <textarea class="form-control" id="address" name="address">{{ old('address', optional($teacher->currentAddress)->address) }}</textarea>
                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-sm">Update Teacher</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('script')
    <script>
        // $("#subject_id").chained("#class_id");
    </script>
@endsection
