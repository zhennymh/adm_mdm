<header class="navbar navbar-expand-md navbar-light d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href=".">
                <img src="{{ asset('static/logo.svg') }}" width="110" height="32" alt="Tabler" class="navbar-brand-image">
            </a>
        </h1>

        <div class="nav-item dropdown">
            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                aria-label="Open user menu">
                <span class="avatar avatar-sm" style="background-image: url('{{ asset('static/avatars/000m.png')}}')"></span>
                <div class="d-none d-xl-block ps-2">
                    <div>{{ auth()->user()->username }}</div>
                    <div class="mt-1 small text-muted">{{ session('role') }}</div>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <form action="{{ url('logout') }}" method="post">
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
                            <a class="nav-link" href="{{ url($m->url) }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    {!! $m->icon !!}
                                </span>
                                <span class="nav-link-title">
                                    {{ $m->menu }}
                                </span>
                            </a>
                        </li>
                    @endforeach
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/lifebuoy -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M15 15l3.35 3.35" /><path d="M9 15l-3.35 3.35" /><path d="M5.65 5.65l3.35 3.35" /><path d="M18.35 5.65l-3.35 3.35" /></svg>
                        </span>
                        <span class="nav-link-title">
                          Visualisasi
                        </span>
                      </a>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="http://172.19.2.189/views/MetadataStation/Dashboard1?iframeSizedToWindow=true&:embed=y&:showAppBanner=false&:display_count=no&:showVizHome=no&:origin=viz_share_link" target="_blank">
                          Metadata Station
                        </a>
                        <a class="dropdown-item" href="http://172.19.2.189/views/AnalisaLagTime/DashboardLagTime?iframeSizedToWindow=true&:embed=y&:showAppBanner=false&:display_count=no&:showVizHome=no&:origin=viz_share_link" target="_blank">
                          Lagtime
                        </a>
                        <a class="dropdown-item" href="http://172.19.2.189/views/AnalisaLagTime/DashboardLagTimeGBON?iframeSizedToWindow=true&:embed=y&:showAppBanner=false&:display_count=no&:showVizHome=no&:origin=viz_share_link" target="_blank">
                          Lagtime (GBON)
                        </a>                        
                        <a class="dropdown-item" href="#" rel="noopener">
                          Me48
                        </a>
                        <a class="dropdown-item" href="http://172.19.2.189/views/PosHujan/Dashboard1?iframeSizedToWindow=true&:embed=y&:showAppBanner=false&:display_count=no&:showVizHome=no&:origin=viz_share_link" target="_blank">
                          Pos Hujan Kerjasama
                        </a>
                        <a class="dropdown-item" href="http://172.19.2.189/views/DataPosHujan/DashboardDataHujanPHK?iframeSizedToWindow=true&:embed=y&:showAppBanner=false&:display_count=no&:showVizHome=no&:origin=viz_share_link" target="_blank">
                          Data Pos Hujan Kerjasama
                        </a>
                        <a class="dropdown-item" href="http://172.19.2.189/views/DataPosHujan/DashboardData9999?iframeSizedToWindow=true&:embed=y&:showAppBanner=false&:display_count=no&:showVizHome=no&:origin=viz_share_link" target="_blank">
                          Data Hujan 9999 Pos Hujan Kerjasama 
                        </a>
                        <a class="dropdown-item" href="http://172.19.2.189/views/DataPosHujan/DashboardPenginputDataPHK?iframeSizedToWindow=true&:embed=y&:showAppBanner=false&:display_count=no&:showVizHome=no&:origin=viz_share_link" target="_blank">
                          Penginput Data Pos Hujan Kerjasama
                        </a>
                        <a class="dropdown-item" href="http://172.19.2.189/views/IntegrasiAWSDigidanBMKGSoft/DashboardRainfallLastMm?iframeSizedToWindow=true&:embed=y&:showAppBanner=false&:display_count=no&:showVizHome=no&:origin=viz_share_link" target="_blank">
                          Integrasi AWS Digi dan BMKGSoft
                        </a>
                        <a class="dropdown-item" href="http://172.19.2.189/views/WWRBMKG/DashboardKetersediaanData?iframeSizedToWindow=true&:embed=y&:showAppBanner=false&:display_count=no&:showVizHome=no&:origin=viz_share_link" target="_blank">
                          World Weather Records (WWR)
                        </a>

                        
                        <!-- <a class="dropdown-item text-pink" href="https://github.com/sponsors/codecalm" target="_blank" rel="noopener">                        
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" /></svg>
                          Sponsor project!
                        </a> -->
                      </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
