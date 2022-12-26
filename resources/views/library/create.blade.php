@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="font-weight-bold mb-0">
                {{ __('Add Books to Library') }}
            </h4>
        </div>

        <div class="card-body">
            <form action="{{ route('library.store') }}" method="post" class="" enctype="multipart/form-data">
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
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" @if(old('subject_id') == $subject->id) {{ "selected" }} @endif>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="question" class="required">Library File</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file" aria-describedby="file" name="file" required>
                            <label class="custom-file-label" for="question">Choose file</label>
                        </div>
                    </div>
                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-sm">Add to Library</button>
                </div>
            </form>
        </div>
    </div>
@endsection

