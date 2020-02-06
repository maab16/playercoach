@extends('layouts.master')

@section('content')
<div class="container">
    <a href="{{ route('users') }}" class="btn btn-success mb-3">Back</a>
    <div class="card">
        <div class="card-header">{{ __('Update role') }}</div>

        <div class="card-body">
            <form method="POST" action="{{ route('role.update', ['id' => $role->id]) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name" class="col-form-label text-md-right">{{ __('Name') }}</label>
                    <input
                        id="name"
                        type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        name="name"
                        value="{{ old('name') ?? $role->name }}"
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
                        value="{{ old('guard_name') ?? $role->guard_name }}"
                        autocomplete="guard_name"
                        autofocus>

                    @error('guard_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="permissions" class="col-form-lebel text-md-right">{{ __('Permission') }}</label>
                    <select name="permissions[]" id="permissions" class="form-control select2-multiple" multiple="multiple">
                        <option value="">Select Permission</option>
                        @foreach($permissions as $permission)
                            @if($role->hasPermissionTo($permission))
                                <option value="{{ $permission->id }}" selected="selected">{{ $permission->name }}</option>
                            @else
                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-success">{{ __('Update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
