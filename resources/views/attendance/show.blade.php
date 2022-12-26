@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <b>
                {{ __('Attendance') }}
            </b>
        </div>

        <div class="card-body">
            <form action="{{ route('attendance.store') }}" method="post" class="">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="student_class_id">Class Name</label>
                        <input type="hidden" name="student_class_id" value="{{ $studentClass->id }}">
                        <input type="text" class="form-control" id="student_class_id" disabled value="{{ $studentClass->name }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="attendance_date">Attendance Date</label>
                        <input type="hidden" name="attendance_date" value="{{ $attendanceDate }}">
                        <input type="text" class="form-control" id="attendance_date" disabled value="{{ $attendanceDate }}">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="">List of Students</label>
                        @foreach($students as $student)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="students[]" id="student_{{ $student->id }}" value="{{ $student->id }}">
                                <label class="form-check-label" for="student_{{ $student->id }}">
                                    {{ $student->fullname }} (Roll: {{ $student->roll_number }})
                                </label>
                            </div>
                        @endforeach

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
