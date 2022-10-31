<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Msgdesk</a>
</div>
<div class="sidebar-brand sidebar-brand-sm">
    <a href="index.html">St</a>
</div>
<ul class="sidebar-menu">
    <li class="menu-header">Dashboard</li>
    <li class="active">
        <a href="{{ url('dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
    </li>
    <li class="dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-user"></i> <span>User</span></a>
        <ul class="dropdown-menu">
            <li><a href="{{ route('users') }}">Lihat User</a></li>
            <li><a class="nav-link" href="{{ route('users.tambah') }}">Tambah User</a></li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-plug"></i> <span>Printer</span></a>
        <ul class="dropdown-menu">
            <li><a href="{{ route('printers.index') }}">Lihat Printer</a></li>
            <li><a class="nav-link" href="{{ route('printers.create') }}">Tambah Printer</a></li>
            <li><a href="#">Relokasi Printer</a></li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i>
            <span>Pengaduan</span></a>
        <ul class="dropdown-menu">
            <li>
                <div class="row">
                    <div class="col-md-6">
                        <a class="nav-link" href="{{ route('list-open-ticket') }}">
                            Open
                        </a>
                    </div>
                    <div class="col-md-4">
                        <span class="badge badge-success">{{ $count_ticket[0] }}</span>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-md-6">
                        <a class="nav-link" href="{{ route('list-progress-ticket') }}">
                            Progress
                        </a>
                    </div>
                    <div class="col-md-4">
                        <span class="badge badge-warning">{{ $count_ticket[1] }}</span>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-md-6">
                        <a class="nav-link" href="{{ route('list-close-ticket') }}">
                            close
                        </a>
                    </div>
                    <div class="col-md-4">
                        <span class="badge badge-danger">{{ $count_ticket[2] }}</span>
                    </div>
                </div>
            </li>
            <li>
                <a class="nav-link" href="{{ route('view-create-ticket') }}">
                    Buat Tiket
                </a>
            </li>
        </ul>
        
        </aside>
        </div>
