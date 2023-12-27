@php use Illuminate\Support\Facades\Auth; @endphp
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Home</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">

                @auth
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/celebrities">Studio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/roles">Roles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1"
                           aria-disabled="true">{{Auth::user()->name}}</a>
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