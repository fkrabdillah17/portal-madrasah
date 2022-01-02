<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin">
        <div class="sidebar-brand-icon">
            <img src="{{ URL::asset('assets/img/logo/Logo.png') }}" width="60px"></img>
        </div>
        <div class="sidebar-brand-text mx-3">MTsN 1 Kota Bengkulu</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-1">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('admin') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('beranda') }}">
            <i class="fas fa-home"></i>
            <span>Beranda</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ request()->is('admin/slide*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ Route('slide.index') }}">
            <i class="fas fa-file-alt"></i>
            <span>Slide</span></a>
    </li>
    <li class="nav-item {{ request()->is('admin/profile*') ? 'active' : '' }}">
        <a class="nav-link" href="/admin/profile">
            <i class="fas fa-user"></i>
            <span>Profil</span></a>
    </li>
    <li class="nav-item {{ request()->is('admin/academic*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('academic.index') }}">
            <i class="bi bi-book-half"></i>
            <span>Akademik</span></a>
    </li>
    <li class="nav-item {{ request()->is('admin/kesiswaan*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kesiswaan.index') }}">
            <i class="bi bi-person-lines-fill"></i>
            <span>Kesiswaan</span></a>
    </li>
    <li class="nav-item {{ request()->is('admin/staff*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('staff.index') }}">
            <i class="bi bi-file-person"></i>
            <span>Staff</span></a>
    </li>
    <li class="nav-item {{ request()->is('admin/news*') ? 'active' : '' }}">
        <a class="nav-link" href="/admin/news">
            <i class="far fa-newspaper"></i>
            <span>Berita</span></a>
    </li>
    <li class="nav-item {{ request()->is('admin/service*') ? 'active' : '' }}">
        <a class="nav-link" href="/admin/service">
            <i class="fas fa-file-alt"></i>
            <span>Layanan</span></a>
    </li>
    <li class="nav-item {{ request()->is('admin/gallery*') ? 'active' : '' }}">
        <a class="nav-link" href="/admin/gallery">
            <i class="fas fa-photo-video"></i>
            <span>Galeri</span></a>
    </li>
    <li class="nav-item {{ request()->is('admin/download*') ? 'active' : '' }}">
        <a class="nav-link" href="/admin/download">
            <i class="bi bi-file-earmark-arrow-down"></i>
            <span>Unduhan</span></a>
    </li>


    @if (auth()->user()->role == 0)
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Akun
        </div>
        <!-- Nav Item - Account -->
        <li class="nav-item {{ request()->is('admin/account*') ? 'active' : '' }}">
            <a class="nav-link" href="/admin/account">
                <i class="fas fa-user-circle"></i>
                <span>Akun</span></a>
        </li>
    @endif

    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
