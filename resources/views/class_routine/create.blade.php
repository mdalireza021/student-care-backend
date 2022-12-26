@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <b>
                {{ __('Add Class Routine') }}
            </b>
        </div>

        <div class="card-body">
            <form action="{{ route('routine.store') }}" method="post" class="">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="student_class_id" class="required">Class Name</label>
                        <select id="student_class_id" class="form-control" name="student_class_id" required>
                            <option value="">Choose...</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" @if(old('student_class_id') == $class->id) {{ "selected" }} @endif>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="subject_id" class="required">Subject Name</label>
                        <select id="subject_id" class="form-control" name="subject_id" required>
                            <option value="">Choose...</option>
                            @foreach($classes as $class)
                                @foreach($class->subjects as $subject)
                                    <option data-chained="{{ $subject->student_class_id }}" value="{{ $subject->id }}" @if(old('subject_id') == $subject->id) {{ "selected" }} @endif>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="day" class="required">Select Day</label>
                        <select id="day" class="form-control" name="day" required>
                            <option value="">Choose...</option>
                            @foreach(config('app.days') as $index => $value)
                                <option value="{{ $index }}" @if(old('day') == $index) {{ "selected" }} @endif>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="from" class="required">Time (From)</label>
                        <input type="text" class="form-control time-picker" name="from" id="from" value="{{ old('from') }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="to" class="required">Time (Fo)</label>
                        <input type="text" class="form-control time-picker" name="to" id="to" value="{{ old('to') }}" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="room_no" class="required">Room Number</label>
                        <input type="text" class="form-control" name="room_no" id="room_no" value="{{ old('room_no') }}" required>
                    </div>
                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-sm">Add Class Routine</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#student_id").chained("#student_class_id");
        $("#subject_id").chained("#student_class_id");

        $('.time-picker').timepicker();
    </script>
@endsection
