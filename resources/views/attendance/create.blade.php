@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <b>
                {{ __('Attendance') }}
            </b>
        </div>

        <div class="card-body">
            <form action="{{ route('attendance.store') }}" method="post" class="" id="class-attendance">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="student_class_id">Class Name</label>
                        <select id="student_class_id" class="form-control" name="student_class_id" required>
                            <option value="">Choose...</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" @if(old('class_id') == $class->id) {{ "selected" }} @endif>{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="attendance_date">Attendance Date</label>
                        <input type="text" class="form-control date-picker" id="attendance_date" name="attendance_date" required>
                    </div>
                    <div class="form-group col-md-4 mt-4 pt-2">
                        <button class="btn btn-md btn-primary" id="get-students">Get Students</button>
                    </div>

                    <div class="form-group col-md-12 d-none" id="check-box-wrapper">
                        <label for="">List of Students</label>
                        <div id="check-box-container"></div>
                        <small id="" class="form-text text-muted">
                            For present check Student Name, and for absent uncheck Student Name
                        </small>
                    </div>

                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-sm">Take Attendance</button>
                </div>
            </form>
        </div>
    </div>
@endsection
