@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <!-- Button trigger modal -->
    <a href="{{ route('user.add') }}" class="btn btn-success">
      Create new User
    </a>

    <div class="table-responsive mt-3">
        @if(count($users) > 0)
            <table class="table table-striped table-bordered database-tables" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th class="action">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $userItem)
                    <tr data-id="1">
                        <td>{{ $userItem->name }}</td>
                        <td>{{ $userItem->email }}</td>
                        <td>
                            @if(count($userItem->roles) > 0)
                            <ul class="user_roles" style="list-style: none">
                                @foreach($userItem->roles as $role)
                                    <li>{{ $role->name }}</li>
                                @endforeach
                            </ul>
                            @endif
                        </td>
                        <td class="action">
                            <a href="{{ route('user.edit', ['id' => $userItem->id]) }}" class="btn btn-success">Edit</a>
                            <form method="POST" action="{{ route('user.delete', ['id' => $userItem->id]) }}" class="d-inline-flex">
                                @csrf
                                @method('DELETE')

                                <div class="form-group">
                                    <input type="submit" class="btn btn-danger delete-user" value="Delete">
                                </div>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
        <p>There is no User</p>
        @endif
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
