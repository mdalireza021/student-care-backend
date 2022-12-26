@extends("layouts.app")

@section("content")
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="font-weight-bold mb-0">
                        {{ __('All Notices') }}
                    </h4>
                </div>
                @if(auth()->user()->hasRole('Administrator'))
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('notice.create') }}" class="btn btn-sm btn-outline-primary">
                            {{ __('Add Notice') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-sm" id="data-table">
                <thead>
                <tr>
                    <th>Serial</th>
                    <th>Title</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Description</th>
                    @if(auth()->user()->hasRole('Administrator'))
                        <th>Options</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($notices as $notice)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $notice->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($notice->available_from)->format('d F Y h:i:s') }}</td>
                        <td>{{ \Carbon\Carbon::parse($notice->available_to)->format('d F Y h:i:s') }}</td>
                        <td>{{ $notice->description }}</td>
                        @if(auth()->user()->hasRole('Administrator'))
                            <td>
                                <ul class="list-unstyled mb-0">
                                    {{--<li class="mb-1">
                                        <a class="btn btn-sm btn-secondary" href="{{ route('library.edit', $library->id) }}">Edit Library</a>
                                    </li>--}}
                                    <li class="">
                                        <form action="{{ route('notice.destroy', $notice->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
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
