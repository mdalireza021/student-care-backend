@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h5 class="font-weight-bold mb-0">
                        {{ __('Class Routine') }}
                    </h5>
                </div>
                @if(auth()->user()->hasRole('Administrator'))
                <div class="col-sm-6 text-right">
                    <a href="{{ route('routine.create') }}" class="btn btn-sm btn-outline-primary">
                        {{ __('Add Class Routine') }}
                    </a>
                </div>
                @endif
            </div>
        </div>

        <div class="card-body">
            @foreach($routines as $classId => $routineGroup)
                <h5 class="font-weight-bold text-center">
                    {{ array_key_exists($classId, $studentClasses) ? $studentClasses[$classId] : "" }}
                </h5>
                <div class="row">
                    @foreach($routineGroup as $dayId => $routineDayGroup)
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header text-center">
                                    <h5 class="mb-0">{{ array_key_exists($dayId, $days) ? $days[$dayId] : "" }}</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-hover table-sm">
                                        <tr>
                                            <td>Time</td>
                                            <td>Subject</td>
                                            <td>Room No</td>
                                            <td>Options</td>
                                        </tr>

                                        @foreach($routineDayGroup as $routine)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($routine->from)->format('h:i:s A') }} - {{ \Carbon\Carbon::parse($routine->to)->format('h:i:s A') }}</td>
                                                <td>{{ optional($routine->subject)->name }}</td>
                                                <td>{{ $routine->room_no }}</td>
                                                <td>
                                                    <ul class="list-unstyled mb-0">
                                                        <li class="">
                                                            <form action="{{ route('routine.destroy', $routine->id) }}" method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection
