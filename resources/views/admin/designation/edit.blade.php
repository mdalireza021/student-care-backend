@extends("layouts.app")

@section("content")
    <div class="card">
        <div class="card-header">
            <b>{{ __('Edit Designation') }}</b>
        </div>

        <div class="card-body">
            <form action="{{ route('designation.update', $designation->id) }}" method="post" class="form-inline">
                @csrf
                @method('put')

                <div class="form-group">
                    <label for="name" class="my-1 mr-2 col-form-label-sm">{{ __('Designation Name') }}</label>
                    <input id="name" type="text" class="form-control form-control-sm my-1 mr-sm-2" name="name" value="{{ old('name', $designation->name) }}" required>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-sm">Update Designation</button>
                </div>
            </form>
        </div>
    </div>
@endsection
