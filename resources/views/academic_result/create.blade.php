@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <b>
                {{ __('Add Academic Result') }}
            </b>
        </div>

        <div class="card-body">
            <form action="{{ route('academic-result.store') }}" method="post" class="">
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
                        <label for="student_id" class="required">Student ID</label>
                        <select id="student_id" class="form-control" name="student_id" required>
                            <option value="">Choose...</option>
                            @foreach($students as $student)
                                <option data-chained="{{ $student->student_class_id }}" value="{{ $student->id }}" @if(old('student_id') == $student->id) {{ "selected" }} @endif>
                                    {{ $student->id_no }} - ({{ $student->fullname }})
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
                        <label for="exam_id" class="required">Exam Name</label>
                        <select id="exam_id" class="form-control" name="exam_id" required>
                            <option value="">Choose...</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}" @if(old('exam_id') == $exam->id) {{ "selected" }} @endif>
                                    {{ $exam->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="total_marks" class="required">Total Marks</label>
                        <input type="text" class="form-control" name="total_marks" id="total_marks" value="{{ old('total_marks') }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="obtained_marks" class="required">Obtained Marks</label>
                        <input type="text" class="form-control" name="obtained_marks" id="obtained_marks" value="{{ old('obtained_marks') }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="highest_marks" class="required">Highest Marks</label>
                        <input type="text" class="form-control" name="highest_marks" id="highest_marks" value="{{ old('highest_marks') }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="remarks" class="required">Remarks</label>
                        <input type="text" class="form-control" name="remarks" id="remarks" value="{{ old('remarks') }}" required>
                    </div>
                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-sm">Add Academic Result</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#student_id").chained("#student_class_id");
        $("#subject_id").chained("#student_class_id");
    </script>
@endsection
