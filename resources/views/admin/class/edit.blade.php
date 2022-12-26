@extends("layouts.app")

@section("content")
    <div class="card">
        <div class="card-header">
            <b>{{ __('Edit Class') }}</b>
        </div>

        <div class="card-body">
            <form action="{{ route('student-class.update', $studentClass->id) }}" method="post" class="form-inline">
                @csrf
                @method('put')

                <div class="form-group">
                    <label for="name" class="my-1 mr-2 col-form-label-sm">{{ __('Class Name') }}</label>
                    <input id="name" type="text" class="form-control form-control-sm my-1 mr-sm-2" name="name" value="{{ old('name', $studentClass->name) }}" required>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="total_students" class="my-1 mr-2 col-form-label-sm">{{ __('Total Student') }}</label>
                    <input id="name" type="text" class="form-control form-control-sm my-1 mr-sm-2" name="total_students" value="{{ old('total_students', $studentClass->total_students) }}">
                    @error('total_students')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-sm">Update Class</button>
                </div>
            </form>
        </div>
    </div>
@endsection
