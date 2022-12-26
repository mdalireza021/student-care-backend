@extends("layouts.app")

@section("content")
    <div class="card">
        <div class="card-header">
            <div class="row">
                {{ __('Add Role') }}
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('role.store') }}" method="post" class="form-inline">
                @csrf

                <div class="form-group">
                    <label for="name" class="my-1 mr-2 col-form-label-sm">{{ __('Role Name') }}</label>
                    <input id="name" type="text" class="form-control form-control-sm my-1 mr-sm-2" name="name" value="{{ old('name') }}" required>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-sm">Add Role</button>
                </div>
            </form>
        </div>
    </div>
@endsection
