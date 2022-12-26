@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <b>
                {{ __('Add Notice') }}
            </b>
        </div>

        <div class="card-body">
            <form action="{{ route('notice.store') }}" method="post" class="">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="name">Title</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="available_from">Available From Date</label>
                        <input type="text" class="form-control date-picker" id="available_from" name="available_from">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="available_to">Available To Date</label>
                        <input type="text" class="form-control date-picker" id="available_to" name="available_to">
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-sm">Add Notice</button>
                </div>
            </form>
        </div>
    </div>
@endsection
