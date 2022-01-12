<header class="navbar navbar-expand-md navbar-light d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href=".">
                <img src="./static/tabler.svg" width="110" height="32" alt="Tabler" class="navbar-brand-image">
            </a>
        </h1>

        <div class="nav-item dropdown">
            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                aria-label="Open user menu">
                <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.png)"></span>
                <div class="d-none d-xl-block ps-2">
                    <div>Username</div>
                    <div class="mt-1 small text-muted">Role</div>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <a href="#" class="dropdown-item">Edit Profile</a>
                <a href="#" class="dropdown-item">Logout</a>
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
                    <li class="nav-item {{ $title == 'Dashboard' ? 'active' : '' }}">
                        <a class="nav-link" href="/">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/device-desktop-analytics -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <rect x="3" y="4" width="18" height="12" rx="1" />
                                    <path d="M7 20h10" />
                                    <path d="M9 16v4" />
                                    <path d="M15 16v4" />
                                    <path d="M9 12v-4" />
                                    <path d="M12 12v-1" />
                                    <path d="M15 12v-2" />
                                    <path d="M12 12v-1" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Dashboard
                            </span>
                        </a>
                    </li>
                    <li class="nav-item {{ $title == 'export data' ? 'active' : '' }}">
                        <a class="nav-link" href="/export">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                    <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                    <rect x="7" y="13" width="10" height="8" rx="2" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Export Data
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
