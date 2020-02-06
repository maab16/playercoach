@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <a href="{{ route('users') }}" class="btn btn-success mb-3">Back</a>
    <div class="card">
        <div class="card-header">{{ __('Register') }}</div>

        <div class="card-body">
            <form method="POST" action="{{ route('user.add') }}">
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
                    <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                    <input
                        id="email"
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email"
                        value="{{ old('email') }}"
                        autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>
                    <input
                        id="password"
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password"
                        autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label
                        for="password-confirm"
                        class="col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                    <input
                        id="password-confirm"
                        type="password"
                        class="form-control"
                        name="password_confirmation"
                        autocomplete="new-password">
                </div>
                <div class="form-group">
                    <label for="roles" class="col-form-lebel text-md-right">{{ __('Role') }}</label>
                    <select name="roles" id="roles" class="form-control">
                        <option value="">Select Role</option>
                        @role('super_admin')
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        @endrole
                        @hasrole('partner_admin')
                             @foreach($roles as $role)
                                @if($role->name != 'super_admin')
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endif
                            @endforeach
                        @endhasrole
                    </select>
                </div>
                <div class="form-group">
                  <a href="{{ route('users') }}" class="btn btn-danger" data-dismiss="modal">Close</a>
                  <button type="submit" class="btn btn-success">{{ __('Register') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push ('scripts')
<script>
    $(function(){
        $('.delete-role, .delete-user').on("click", function(e){
            e.preventDefault() // Don't post the form, unless confirmed
            if (confirm('Are you sure?')) {
                // Post the form
                $(e.target).closest('form').submit() // Post the surrounding form
            }
        });
    })

</script>
@endpush
