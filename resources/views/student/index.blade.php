@extends("layouts.app")

@section("content")
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    {{ __('List of Students') }}
                </div>
                @if(auth()->user()->hasRole('Administrator'))
                <div class="col-sm-6 text-right">
                    <a href="{{ route('student.create') }}" class="btn btn-sm btn-outline-primary">
                        {{ __('Add Student') }}
                    </a>
                </div>
                @endif
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-sm" id="data-table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>ID</th>
                    <th>Roll Number</th>
                    <th></th>
                    <th>Class</th>
                    <th>Address</th>
                    <th>Created At</th>
                    @if(auth()->user()->hasRole('Administrator'))
                    <th>Options</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>
                            <p>{{ $student->fullname }}</p>
                            <img class="img-thumbnail rounded" width="150" src="{{ $student->attachment ? url('storage/'.$student->attachment->path) : "#" }}" alt="{{ $student->attachment ? $student->attachment->actual_name : "#" }}">
                        </td>
                        <td>{{ $student->id_no }}</td>
                        <td>{{ $student->roll_number }}</td>
                        <td>
                            <ul class="list-unstyled mb-0">
                                <li>Gender: {{ $student->gender }}</li>
                                <li>Blood Type: {{ $student->blood_type }}</li>
                                <li>Shift: {{ optional($student->shift)->name }}</li>
                                <li>Section: {{ optional($student->section)->name }}</li>
                                <li>School ID: {{ optional($student->school)->name }}</li>
                            </ul>
                        </td>
                        <td>
                            {{ optional($student->studentClass)->name }}
                        </td>
                        <td>{{ optional($student->currentAddress)->address }}</td>
                        <td>{{ \Carbon\Carbon::parse($student->created_at)->format('d F Y h:i:s A') }}</td>
                        @if(auth()->user()->hasRole('Administrator'))
                        <td>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-1">
                                    <a class="btn btn-sm btn-secondary btn-block" href="{{ route('student.edit', $student->id) }}">Edit</a>
                                </li>
                                <li class="">
                                    <form action="{{ route('student.destroy', $student->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger btn-block">Delete</button>
                                    </form>
                                </li>
                            </ul>
                        </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
