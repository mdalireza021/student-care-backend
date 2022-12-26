@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="font-weight-bold mb-0">{{ __('Dashboard') }}</h4>
        </div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="row">
                <div class="col-sm-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h3 class="font-weight-bold">{{ $totalStudents }}</h3>
                        </div>
                        <div class="card-footer">
                            <b>Student</b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card text-white bg-secondary">
                        <div class="card-body">
                            <h3 class="font-weight-bold">{{ $totalTeachers }}</h3>
                        </div>
                        <div class="card-footer">
                            <b>Teacher</b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h3 class="font-weight-bold">{{ $totalGuardians }}</h3>
                        </div>
                        <div class="card-footer">
                            <b>Guardian</b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <h3 class="font-weight-bold">{{ $totalPresents }}</h3>
                        </div>
                        <div class="card-footer">
                            <b>Present Today</b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
