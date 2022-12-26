@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="font-weight-bold mb-0">
                {{ __('Attendance') }}
            </h4>
        </div>

        <div class="card-body">
            <form action="{{ route('attendance.store') }}" method="post" class="">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="student_class_id" class="required">Class Name</label>
                        <select id="student_class_id" name="student_class_id" class="form-control">
                            <option value="">Choose...</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" @if(old('student_class_id') == $class->id) {{ "selected" }} @endif>{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="attendance_date" class="required">Attendance Date</label>
                        <input type="text" value="{{ old('attendance_date') }}" class="form-control date-picker" id="attendance_date" name="attendance_date">
                    </div>

                    @if(isset($attendances))
                        <div class="form-group col-md-12">
                        @if(count($attendances) > 0)
                            <label for="">List of Students</label>
                            <table class="table table-sm table-bordered">
                                <tr>
                                    <th>Student Name</th>
                                    <th>Present?</th>
                                    <th>Attendance Taker</th>
                                    <th>Day</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                </tr>
                                @foreach($attendances as $attendance)
                                    <tr>
                                        <td>{{ optional($attendance->student)->fullname }}</td>
                                        <td>{{ $attendance->attendance_type == 0 ? "Absent" : "Present" }}</td>
                                        <td>{{ optional($attendance->attendanceTaker)->fullname }}</td>
                                        <td>{{ $attendance->day }}</td>
                                        <td>{{ date('F', mktime(0, 0, 0, $attendance->month, 10)) }}</td>
                                        <td>{{ $attendance->year }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <div class="alert alert-info" role="alert">
                                <b>Nothing found</b>
                            </div>
                        @endif
                        </div>
                    @endif
                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success">Search</button>
                </div>
            </form>
        </div>
    </div>
@endsection
