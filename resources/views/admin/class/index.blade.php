@extends("layouts.app")

@section("content")
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    {{ __('All Student Classes') }}
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('student-class.create') }}" class="btn btn-sm btn-outline-primary">
                        {{ __('Create Student Class') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-sm">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Total Student</th>
                    <th>Created At</th>
                    <th>Options</th>
                </tr>
                </thead>
                <tbody>
                @foreach($studentClasses as $studentClass)
                    <tr>
                        <td>{{ $studentClass->name }}</td>
                        <td>{{ $studentClass->total_students }}</td>
                        <td>{{ \Carbon\Carbon::parse($studentClass->created_at)->format('d F Y h:i:s') }}</td>
                        <td>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-1">
                                    <a class="btn btn-sm btn-secondary" href="{{ route('student-class.edit', $studentClass->id) }}">Edit Class</a>
                                </li>
                                <li class="">
                                    <form action="{{ route('student-class.destroy', $studentClass->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete Class</button>
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
