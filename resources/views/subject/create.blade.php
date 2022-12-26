@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <b>
                {{ __('Add Subject') }}
            </b>
        </div>

        <div class="card-body">
            <form action="{{ route('subject.store') }}" method="post" class="">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="student_class_id">Class Name</label>
                        <select id="student_class_id" class="form-control">
                            <option selected>Choose...</option>
                            <option value="1">Class One</option>
                            <option value="2">Class Two</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="name">Subject Name</label>
                        <input type="text" class="form-control" id="name">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="code">Subject Code</label>
                        <input type="text" class="form-control" id="code">
                    </div>
                </div>
                <div class="form-group">
                    <label for="preferred_books">Preferred Books</label>
                    <textarea class="form-control" id="preferred_books"></textarea>
                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-sm">Add Subject</button>
                </div>
            </form>
        </div>
    </div>
@endsection

