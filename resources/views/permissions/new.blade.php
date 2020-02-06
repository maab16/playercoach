@extends('layouts.master')

@section('content')
<div class="container">
    <a href="{{ route('users') }}" class="btn btn-success mb-3">Back</a>
    <div class="card">
        <div class="card-header">{{ __('Create a new role') }}</div>

        <div class="card-body">
            <form method="POST" action="{{ route('permission.store') }}">
                @csrf
                <div class="form-group">
                    <label for="name" class="col-form-label text-md-right">{{ __('Name') }}</label>
                    <input
                        id="name"
                        type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        name="name"
                        value="{{ old('name') }}"
                        autocomplete="name"
                        autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="guard_name" class="col-form-label text-md-right">{{ __('Guard name') }}</label>
                    <input
                        id="guard_name"
                        type="text"
                        class="form-control @error('guard_name') is-invalid @enderror"
                        name="guard_name"
                        value="{{ old('guard_name') }}"
                        autocomplete="guard_name"
                        autofocus>

                    @error('guard_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-success">{{ __('Create') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
