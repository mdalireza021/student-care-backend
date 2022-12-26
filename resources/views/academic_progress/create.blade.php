@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <b>
                {{ __('Add Academic Progress') }}
            </b>
        </div>

        <div class="card-body">
            <form action="{{ route('student-progress.store') }}" method="post" class="">
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
                </div>
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control" id="remarks" name="remarks">{{ old('remarks') }}</textarea>
                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-sm">Add Progress</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#student_id").chained("#student_class_id");
    </script>
@endsection
