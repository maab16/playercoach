<nav id="sidebar">
    <div class="custom-menu">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
            <i class="fa fa-bars"></i>
            <span class="sr-only">Toggle Menu</span>
        </button>
    </div>
    <div class="p-4">
        <h1>
            <a href="{{ url('/') }}" class="logo">
                {{ config('app.name') }}
            </a>
        </h1>
        <ul class="list-unstyled components mb-5">
            <li>
                <a data-toggle="collapse" href="#user"><span class="fa fa-suitcase mr-3"></span> Users & Permissions</a>
                <div class="collapse" id="user">
                    <ul class="list-unstyled components ml-3">
                        <li><a href="{{ route('users') }}">Users</a></li>
                        <li><a href="{{ route('role.index') }}">Roles</a></li>
                        <li><a href="{{ route('permission.index') }}">Permissions</a></li>
                    </ul>
                </div>
            </li>
        </ul>

    </div>
</nav>
