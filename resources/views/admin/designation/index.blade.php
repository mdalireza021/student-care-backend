@extends("layouts.app")

@section("content")
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    {{ __('All Designations') }}
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('designation.create') }}" class="btn btn-sm btn-outline-primary">
                        {{ __('Create Designation') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-sm">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Created At</th>
                    <th>Options</th>
                </tr>
                </thead>
                <tbody>
                @foreach($designations as $designation)
                    <tr>
                        <td>{{ $designation->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($designation->created_at)->format('d F Y h:i:s') }}</td>
                        <td>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-1">
                                    <a class="btn btn-sm btn-secondary" href="{{ route('designation.edit', $designation->id) }}">Edit Designation</a>
                                </li>
                                <li class="">
                                    <form action="{{ route('designation.destroy', $designation->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete Designation</button>
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
