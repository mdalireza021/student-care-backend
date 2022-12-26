@extends("layouts.app")

@section("content")
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h5 class="font-weight-bold mb-0">
                        {{ __('Academic Results') }}
                    </h5>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('academic-result.create') }}" class="btn btn-sm btn-outline-primary">
                        {{ __('Add New Academic Result') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-sm">
                <thead>
                <tr>
                    <th>Class Name</th>
                    <th>Student Name</th>
                    <th>Subject Name</th>
                    <th>Exam Name</th>
                    <th>Total Marks</th>
                    <th>Obtained Marks</th>
                    <th>Highest Marks</th>
                    <th>Remarks</th>
                    <th>Date</th>
                    <th>Options</th>
                </tr>
                </thead>
                <tbody>
                @foreach($academicResults as $academicResult)
                    <tr>
                        <td>{{ optional($academicResult->studentClass)->name }}</td>
                        <td>{{ optional($academicResult->student)->fullname }}</td>
                        <td>{{ optional($academicResult->subject)->name }}</td>
                        <td>{{ optional($academicResult->exam)->name }}</td>
                        <td>{{ $academicResult->total_marks }}</td>
                        <td>{{ $academicResult->obtained_marks }}</td>
                        <td>{{ $academicResult->highest_marks }}</td>
                        <td>{{ $academicResult->remarks }}</td>
                        <td>{{ \Carbon\Carbon::parse($academicResult->created_at)->format('d M Y h:i:s A') }}</td>
                        <td>
                            <ul class="list-unstyled mb-0">
                                <li class="">
                                    <form action="{{ route('academic-result.destroy', $academicResult->id) }}" method="post">
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
