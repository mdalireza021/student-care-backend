@extends("layouts.app")

@section("content")
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    {{ __('All Roles') }}
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('role.create') }}" class="btn btn-sm btn-outline-primary">
                        {{ __('Create Role') }}
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
{{--                        <th>Permissions</th>--}}
                        <th>Created At</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        {{--<td>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#permissionModal">
                                View Permission(s)
                            </button>
                        </td>--}}
                        <td>{{ \Carbon\Carbon::parse($role->created_at)->format('d F Y h:i:s') }}</td>
                        <td>
                            <ul class="list-unstyled mb-0">
                                {{--<li class="mb-1">
                                    <a class="btn btn-sm btn-secondary" href="{{ '' }}">Assign Role to User</a>
                                </li>
                                <li class="">
                                    <a class="btn btn-sm btn-secondary" href="{{ route('role.permission.create', $role->id) }}">Add Permission</a>
                                </li>--}}
                                <li class="">
                                    <form action="{{ route('role.destroy', $role->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </li>
                            </ul>
                        </td>
                    </tr>

                    <div class="modal fade" id="permissionModal" tabindex="-1" aria-labelledby="permissionModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">List of Permissions</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <ul class="list-unstyled list-inline">
                                        @foreach($role->permissions as $permission)
                                            <li class="list-inline-item">
                                                <span class="badge badge-secondary">{{ $permission->name }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
