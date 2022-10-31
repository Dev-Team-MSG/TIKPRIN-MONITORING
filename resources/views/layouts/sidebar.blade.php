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
          <a href="{{ url('dashboard')}}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
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
            <li><a href="{{route('printers.index')}}">Lihat Printer</a></li>
            <li><a class="nav-link" href="{{route('printers.create')}}">Tambah Printer</a></li>
            <li><a href="#">Relokasi Printer</a></li>
          </ul>
        </li>            
        <li><a class="nav-link" href="credits.html"><i class="fas fa-pencil-ruler"></i> <span>Credits</span></a></li>
      </ul>

      <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
        <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
          <i class="fas fa-rocket"></i> Documentation
        </a>
      </div>        </aside>
  </div>