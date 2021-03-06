<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ (request()->is('examiner')) ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('examiner.home') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Home</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    {{-- <li class="nav-item {{ (request()->is('examiner/kriteria*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('examiner.kriteria') }}">
            <i class="fas fa-fw fa-tags"></i>
            <span>Kriteria</span></a>
    </li> --}}

    <li class="nav-item {{ (request()->is('examiner/kriteria*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
            aria-controls="collapseOne">
            <i class="fas fa-fw fa-tags"></i>
            <span>Kriteria</span>
        </a>
        <div id="collapseOne" class="collapse {{ (request()->is('examiner/kriteria*')) ? 'show' : '' }}"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Sub Menu Kriteria:</h6>
                <a class="collapse-item {{ (request()->is('examiner/kriteria')) ? 'active' : '' }}"
                    href="{{ route('examiner.kriteria') }}">Nilai Kriteria</a>
                <a class="collapse-item {{ (request()->is('examiner/kriteria/recent')) ? 'active' : '' }}"
                    href="{{ route('examiner.recent') }}">Proses Sebelumnya</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->