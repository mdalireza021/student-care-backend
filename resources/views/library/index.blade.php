@extends("layouts.app")

@section("content")
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="font-weight-bold mb-0">
                        {{ __('All books from Library') }}
                    </h4>
                </div>
                @if(auth()->user()->hasRole('Administrator'))
                <div class="col-sm-6 text-right">
                    <a href="{{ route('library.create') }}" class="btn btn-sm btn-outline-primary">
                        {{ __('Add Books to Library') }}
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
                    <th>Class Name</th>
                    <th>Subject Name</th>
                    <th class="text-center">File</th>
                    <th>Created At</th>
                    @if(auth()->user()->hasRole('Administrator'))
                    <th>Options</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($libraries as $library)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ optional($library->studentClass)->name }}</td>
                        <td>{{ optional($library->subject)->name }}</td>
                        <td class="text-center">
                            @if(Storage::disk('public')->exists($library->file))
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-fileurl="{{ $library->file }}" id="download-storage-file">
                                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download File
                                </button>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($library->created_at)->format('d F Y h:i:s') }}</td>
                        @if(auth()->user()->hasRole('Administrator'))
                        <td>
                            <ul class="list-unstyled mb-0">
                                {{--<li class="mb-1">
                                    <a class="btn btn-sm btn-secondary" href="{{ route('library.edit', $library->id) }}">Edit Library</a>
                                </li>--}}
                                <li class="">
                                    <form action="{{ route('library.destroy', $library->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete Library</button>
                                    </form>
                                </li>
                            </ul>
                        </td>
                        @endif
                    </tr>
                @endforeach

                <div class="modal fade" data-backdrop="static" id="view-storage-file" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">View File</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="the-canvas"></div>
                            </div>
                        </div>
                    </div>
                </div>
                </tbody>
            </table>
        </div>
    </div>
@endsection
