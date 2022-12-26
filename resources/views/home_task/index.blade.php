@extends("layouts.app")

@section("content")
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h5 class="font-weight-bold mb-0">
                        {{ __('Home Tasks') }}
                    </h5>
                </div>
                @if(auth()->user()->hasRole('Teacher'))
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('home-task.create') }}" class="btn btn-sm btn-outline-primary">
                            {{ __('Add New Home Task') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-sm" id="data-table">
                <thead>
                <tr>
                    <th>Class Name</th>
                    <th>Subject Name</th>
                    <th>File</th>
                    <th>Published</th>
                    <th>Status</th>
                    @if(auth()->user()->hasRole('Administrator'))
                        <th>Published By</th>
                    @endif
                    <th>Options</th>
                </tr>
                </thead>
                <tbody>
                @foreach($homeTasks as $homeTask)
                    <tr>
                        <td>{{ optional($homeTask->studentClass)->name }}</td>
                        <td>{{ optional($homeTask->subject)->name }}</td>
                        <td>
                            @if(Storage::disk('public')->exists(optional($homeTask->attachment)->path))
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-fileurl="{{ $homeTask->attachment->path }}" id="download-storage-file">
                                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download File
                                </button>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($homeTask->published)->format('d M Y h:i:s A') }}</td>
                        <td>
                            <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#task_status_{{ $homeTask->id }}" data-taskid="{{ $homeTask->id }}">
                                Task Status
                            </button>
                        </td>
                        @if(auth()->user()->hasRole('Administrator'))
                            <td>{{ optional($homeTask->publishedBy)->fullname }}</td>
                        @endif
                        <td>
                            <ul class="list-unstyled mb-0">
                                {{--<li class="mb-1">
                                    <a class="btn btn-sm btn-secondary" href="{{ route('home-task.edit', $homeTask->id) }}">Edit Task</a>
                                </li>--}}
                                <li class="">
                                    <form action="{{ route('home-task.destroy', $homeTask->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete Task</button>
                                    </form>
                                </li>
                            </ul>
                        </td>
                    </tr>

                    <div class="modal fade" id="task_status_{{ $homeTask->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Home Task Status</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        @foreach($homeTask->students as $student)
                                            <div class="col-sm-4">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <ul class="list-unstyled mb-0">
                                                            <li>Name: {{ $student->fullname }}</li>
                                                            <li>Roll Number: {{ $student->roll_number }}</li>
                                                            <li>Name: {{ $student->fullname }}</li>
                                                            <li>Mark: {{ $student->mark }}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
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
