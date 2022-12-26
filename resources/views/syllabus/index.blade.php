@extends("layouts.app")

@section("content")
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="font-weight-bold mb-0">
                        {{ __('All Syllabus') }}
                    </h4>
                </div>
                @if(auth()->user()->hasRole('Administrator'))
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('syllabus.create') }}" class="btn btn-sm btn-outline-primary">
                            {{ __('Add Syllabus') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-sm">
                <thead>
                <tr>
                    <th>Serial</th>
                    <th>Class Name</th>
                    <th>Subject Name</th>
                    <th>File</th>
                    <th>Created At</th>
                    @if(auth()->user()->hasRole('Administrator'))
                        <th>Options</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($syllabuses as $syllabus)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ optional($syllabus->studentClass)->name }}</td>
                        <td>{{ optional($syllabus->subject)->name }}</td>
                        <td>
                            @if(Storage::disk('public')->exists(optional($syllabus->attachment)->path))
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-fileurl="{{ $syllabus->attachment->path }}" id="download-storage-file">
                                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download File
                                </button>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($syllabus->created_at)->format('d F Y h:i:s') }}</td>
                        @if(auth()->user()->hasRole('Administrator'))
                            <td>
                                <ul class="list-unstyled mb-0">
                                    {{--<li class="mb-1">
                                        <a class="btn btn-sm btn-secondary" href="{{ route('syllabus.edit', $syllabus->id) }}">Edit</a>
                                    </li>--}}
                                    <li class="">
                                        <form action="{{ route('syllabus.destroy', $syllabus->id) }}" method="post">
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
