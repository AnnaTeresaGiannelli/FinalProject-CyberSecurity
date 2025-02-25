<nav class="navbar navbar-expand-lg bg-dark border-bottom border-body " data-bs-theme="dark" id="navbar">
    <div class="container">

        <div class="collapse navbar-collapse col-lg-4 order-lg-1" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('homepage')}}">The Aulab Post</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('careers') }}">Work with us!</a>
                </li>

                <!-- Utente loggato -->
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Hi, {{ ucwords(Auth::user()->name) }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a></li>

                        @if(Auth::user()->is_writer && Auth::user()->is_admin && Auth::user()->is_revisor)
                            <li><a class="dropdown-item" href="{{ route('articles.create') }}">Write your Article</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                            <li><a class="dropdown-item" href="{{ route('revisor.dashboard') }}">Revisor Panel</a></li>
                            <li><a class="dropdown-item" href="{{ route('writer.dashboard') }}">Writer Panel</a></li>
                        @elseif(Auth::user()->is_admin)
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                        @elseif(Auth::user()->is_revisor)
                            <li><a class="dropdown-item" href="{{ route('revisor.dashboard') }}">Revisor Panel</a></li>
                        @elseif(Auth::user()->is_writer)
                            <li><a class="dropdown-item" href="{{ route('writer.dashboard') }}">Writer Panel</a></li>
                            <li><a class="dropdown-item" href="{{ route('articles.create') }}">Write your Article</a></li>
                        @endif

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.querySelector('#form-logout').submit();"><i class="bi bi-box-arrow-right"></i> Logout</a>
                        </li>
                        <form action="{{ route('logout') }}" method="POST" id="form-logout" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </li>

                @if(Auth::user()->is_writer && Auth::user()->is_admin && Auth::user()->is_revisor)
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Super Admin</a>
                    </li>
                @elseif(Auth::user()->is_admin)
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Admin</a>
                    </li>
                @elseif(Auth::user()->is_revisor)
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Revisor</a>
                    </li>
                @elseif(Auth::user()->is_writer)
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Writer</a>
                    </li>
                @endif

                @endauth

                <!-- Utente non autenticato -->
                @guest
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Welcome Guest</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('register') }}">Sign Up</a></li>
                        <li><a class="dropdown-item" href="{{ route('login') }}">Sign In</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('careers') }}">Work with us!</a></li>
                    </ul>
                </li>
                @endguest

            </ul>
        </div>

        <div class="col-6 d-lg-none text-center order-1">
            <a class="navbar-brand fst-italic fs-1" href="{{ route('homepage') }}">The Aulab Post</a>
        </div>


        <div class="col-6 col-lg-4 d-flex justify-content-end order-2">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Search bar dispositivi grandi -->
            <form class="d-none d-lg-flex ms-3" role="search" action="{{ route('articles.search') }}" method="GET">
                <input class="form-control me-2" type="search" placeholder="Search..." aria-label="Search" name="query">
                <button class="btn btn-outline-light" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>