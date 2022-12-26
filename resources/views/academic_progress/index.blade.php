@extends("layouts.app")

@section("content")
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h5 class="font-weight-bold mb-0">
                        {{ __('Academic Progress') }}
                    </h5>
                </div>
                @if(auth()->user()->hasRole('Teacher'))
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('student-progress.create') }}" class="btn btn-sm btn-outline-primary">
                            {{ __('Add New Academic Progress') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-sm">
                <thead>
                <tr>
                    <th>Class Name</th>
                    <th>Student Name</th>
                    <th>Comments</th>
                    <th>Date</th>
                    <th>Teacher</th>
                    <th>Options</th>
                </tr>
                </thead>
                <tbody>
                @foreach($academicProgress as $progress)
                    <tr>
                        <td>{{ optional($progress->studentClass)->name }}</td>
                        <td>{{ optional($progress->student)->fullname }}</td>
                        <td>{{ $progress->remarks }}</td>
                        <td>{{ \Carbon\Carbon::parse($progress->date)->format('d M Y h:i:s A') }}</td>
                        <td>{{ optional($progress->teacher)->fullname }}</td>
                        <td>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-1">
                                    <a class="btn btn-sm btn-secondary" href="{{ route('student-progress.edit', $progress->id) }}">Edit</a>
                                </li>
                                <li class="">
                                    <form action="{{ route('student-progress.destroy', $progress->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
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
