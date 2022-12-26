@extends("layouts.app")

@section("content")
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    {{ __('List of Teacher') }}
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('teacher.create') }}" class="btn btn-sm btn-outline-primary">
                        {{ __('Add Teacher') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-sm" id="data-table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th></th>
                    <th>Classes</th>
                    <th>Credentials</th>
                    <th>Address</th>
                    <th>Created At</th>
                    <th>Options</th>
                </tr>
                </thead>
                <tbody>
                @foreach($teachers as $teacher)
                    <tr>
                        <td>
                            <p>{{ $teacher->fullname }}</p>
                            <img class="img-thumbnail rounded" width="150" src="{{ $teacher->attachment ? url('storage/'.$teacher->attachment->path) : "#" }}" alt="{{ $teacher->attachment ? $teacher->attachment->actual_name : "#" }}">
                        </td>
                        <td>
                            <ul class="list-unstyled mb-0">
                                <li>Gender: {{ $teacher->gender }}</li>
                                <li>Blood Type: {{ $teacher->blood_type }}</li>
                                <li>Phone Number: {{ $teacher->phone }}</li>
                                <li>Shift: {{ $teacher->shift->name }}</li>
                                <li>Section: {{ optional($teacher->section)->name }}</li>
                                <li>School ID: {{ optional($teacher->school)->name }}</li>
                            </ul>
                        </td>
                        <td>
                            <ol class="mb-0 pl-3">
                                @foreach($teacher->classes as $tc)
                                    <li>{{ $tc->name }}</li>
                                @endforeach
                            </ol>
                        </td>
                        <td>
                            <ul class="list-unstyled">
                                <li>
                                    Designation: {{ $teacher->designation->name }}
                                </li>
                                <li>
                                    Email: {{ optional($teacher->user)->email }}
                                </li>
                            </ul>
                        </td>
                        <td>{{ optional($teacher->currentAddress)->address }}</td>
                        <td>{{ \Carbon\Carbon::parse($teacher->created_at)->format('d F Y h:i:s A') }}</td>
                        <td>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-1">
                                    <a class="btn btn-sm btn-secondary btn-block" href="{{ route('teacher.edit', $teacher->id) }}">Edit</a>
                                </li>
                                <li class="">
                                    <form action="{{ route('teacher.destroy', $teacher->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger btn-block">Delete</button>
                                    </form>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
