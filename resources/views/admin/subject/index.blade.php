@extends("layouts.app")

@section("content")
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    {{ __('All Subjects') }}
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('subject.create') }}" class="btn btn-sm btn-outline-primary">
                        {{ __('Add Subject') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-sm">
                <thead>
                <tr>
                    <th>Class</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Created At</th>
                    <th>Options</th>
                </tr>
                </thead>
                <tbody>
                @foreach($subjects as $subject)
                    <tr>
                        <td>{{ optional($subject->studentClass)->name }}</td>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $subject->code }}</td>
                        <td>{{ \Carbon\Carbon::parse($subject->created_at)->format('d F Y h:i:s') }}</td>
                        <td>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-1">
                                    <a class="btn btn-sm btn-secondary" href="{{ route('subject.edit', $subject->id) }}">Edit Subject</a>
                                </li>
                                <li class="">
                                    <form action="{{ route('subject.destroy', $subject->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete Subject</button>
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
