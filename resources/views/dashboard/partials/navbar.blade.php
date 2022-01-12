<header class="navbar navbar-expand-md navbar-light d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href=".">
                <img src="./static/logo.svg" width="110" height="32" alt="Tabler" class="navbar-brand-image">
            </a>
        </h1>

        <div class="nav-item dropdown">
            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                aria-label="Open user menu">
                <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.png)"></span>
                <div class="d-none d-xl-block ps-2">
                    <div>{{ auth()->user()->username }}</div>
                    <div class="mt-1 small text-muted">{{ session('role') }}</div>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <form action="/logout" method="post">
                    @csrf
                    <button type="submit" class="dropdown-item">Logout</button>
                </form>
            </div>
        </div>
    </div>
    </div>
</header>
<div class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar navbar-light">
            <div class="container-xl">
                <ul class="navbar-nav">
                    @foreach ($menu as $m)
                        <li class="nav-item {{ $uri == $m->uri ? 'active' : '' }}">
                            <a class="nav-link" href="{{ $m->url }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    {!! $m->icon !!}
                                </span>
                                <span class="nav-link-title">
                                    {{ $m->menu }}
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
