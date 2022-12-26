@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <b>
                {{ __('Edit Subject') }}
            </b>
        </div>

        <div class="card-body">
            <form action="{{ route('subject.update', $subject->id) }}" method="post" class="">
                @csrf
                @method('put')

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="student_class_id">Class Name</label>
                        <select id="student_class_id" name="student_class_id" class="form-control">
                            <option value="">Choose...</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" @if(old('student_class_id', $subject->student_class_id) == $class->id) {{ "selected" }} @endif>{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="name">Subject Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $subject->name) }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="code">Subject Code</label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ old('code', $subject->code) }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="preferred_books">Preferred Books</label>
                    <textarea class="form-control" id="preferred_books" name="preferred_books">{{ old('preferred_books', $subject->preferred_books) }}</textarea>
                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-sm">Update Subject</button>
                </div>
            </form>
        </div>
    </div>
@endsection

