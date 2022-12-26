@extends("layouts.app")

@section("content")
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    {{ __('All Shifts') }}
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('shift.create') }}" class="btn btn-sm btn-outline-primary">
                        {{ __('Create Shift') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Created At</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($shifts as $shift)
                    <tr>
                        <td>{{ $shift->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($shift->created_at)->format('d F Y h:i:s') }}</td>
                        <td>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-1">
                                    <a class="btn btn-sm btn-secondary" href="{{ route('shift.edit', $shift->id) }}">Edit Shift</a>
                                </li>
                                <li class="">
                                    <form action="{{ route('shift.destroy', $shift->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete Shift</button>
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
