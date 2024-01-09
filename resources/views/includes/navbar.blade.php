<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Home</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav gap-2">

                @auth
                    <li class="nav-item">
                        <a class="btn btn-warning" href="{{ route('celebrities.index') }}">
                            <i class="bi bi-bag"></i> Studio</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="{{ route('roles.index') }}">
                            <i class="bi bi-person-fill-gear"></i> BO - Roles</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-success" href="{{ route('users.index') }}">
                            <i class="bi bi-people"></i> BO - Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1"
                           aria-disabled="true">{{auth()->user()->name}}</a>
                    </li>
                    <li>
                        <form class="nav-item" action="{{route('auth.logout')}}" method="post">
                            @method("delete")
                            @csrf
                            <button class="nav-link">Se déconnecter</button>
                        </form>
                    </li>
                @endauth

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('auth.login')}}">Login</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
