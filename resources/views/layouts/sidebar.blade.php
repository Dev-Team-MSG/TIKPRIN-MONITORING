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
            @foreach ($main_menu as $mm)
                @if ($mm->akses == 1)
                    @if ($mm->url == '')
                        <li class="dropdown">
                            <a href="#" class="nav-link has-dropdown"><i class="{{ $mm->icon }}"></i>
                                <span>{{ $mm->nama_menu }}</span></a>
                            <ul class="dropdown-menu">
                                @foreach ($sub_menu as $sm)
                                    @if ($sm->main_menu == $mm->kode_menu)
                                        @if ($sm->akses == 1)
                                            
                                            <li>
                                                @if ($sm->nama_menu == 'Open')
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <a class="nav-link" href="{{ url($sm->url) }}">
                                                                {{ $sm->nama_menu }}
                                                            </a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <span class="badge badge-success">{{ $count_open }}</span>
                                                        </div>
                                                    </div>
                                                @elseif ($sm->nama_menu == 'Progress')
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <a class="nav-link" href="{{ url($sm->url) }}">
                                                                {{ $sm->nama_menu }}
                                                            </a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <span
                                                                class="badge badge-warning">{{ $count_progress }}</span>
                                                        </div>
                                                    </div>
                                                @elseif ($sm->nama_menu == 'Close')
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <a class="nav-link" href="{{ url($sm->url) }}">
                                                                {{ $sm->nama_menu }}
                                                            </a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <span class="badge badge-danger">{{ $count_close }}</span>
                                                        </div>
                                                    </div>
                                                @else
                                                    <a href="{{ url($sm->url) }}">
                                                        {{ $sm->nama_menu }}</a>
                                                @endif
                                            </li>
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li><a class="nav-link" href="{{ url($mm->url) }}"><i class="{{ $mm->icon }}"></i>
                                <span>{{ $mm->nama_menu }}</span></a>
                        </li>
                    @endif
                @endif
            @endforeach

      <ul class="sidebar-menu">
          <li class="menu-header">Dashboard</li>
          <li class="active">
              <a href="{{ url('dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
          </li>
          {{-- @can('access user') --}}
                <li>
                  <a href="{{ route('users') }}" class="nav-link"><i class="far fa-user"></i> <span>User</span></a>
                  {{-- <ul class="dropdown-menu">
                      <li><a href="{{ route('users') }}">Lihat User</a></li>
                      @can('create user')
                          <li><a class="nav-link" href="{{ route('users.tambah') }}">Tambah User</a></li>
                      @endcan
                  </ul> --}}
              </li>
              <li>
                <a href="{{ route('kanims.index') }}" class="nav-link"><i class="far fa-building"></i> <span>Kanim</span></a>
            </li>
          {{-- @endcan --}}
          {{-- @can('access printer') --}}
              <li class="dropdown">
                  <a href="#" class="nav-link has-dropdown"><i class="fas fa-plug"></i> <span>Printer</span></a>
                  <ul class="dropdown-menu">
                      <li><a href="{{ route('printers.index') }}">Lihat Printer</a></li>
                      {{-- @can('create printer') --}}
                          <li><a class="nav-link" href="{{ route('printers.create') }}">Tambah Printer</a></li>
                      {{-- @endcan --}}

                      {{-- @can('relokasi printer') --}}
                          <li><a href="{{ route('printerkanims.index') }}">Relokasi Printer</a></li>
                  </ul>
              </li>
          {{-- @endcan --}}

          {{-- @can('access tiket')
              <li class="dropdown">
                  <a href="#" class="nav-link has-dropdown"><i class="fas fa-ticket"></i>
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
                                  <span class="badge badge-success">{{ $count_open }}</span>
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
                                  <span class="badge badge-warning">{{ $count_progress }}</span>
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
                                  <span class="badge badge-danger">{{ $count_close }}</span>
                              </div>
                          </div>
                      </li>
                      @can('create tiket')
                          <li>
                              <a class="nav-link" href="{{ route('view-create-ticket') }}">
                                  Buat Tiket
                              </a>
                          </li>
                      @endcan

                  </ul> --}}

              </li>
          {{-- @endcan --}}

          {{-- @can('access permission') --}}
              <li><a class="nav-link" href={{ route('permission.index') }}><i class="fas fa-pencil-ruler"></i>
                      <span>Permission</span></a>
              </li>
          {{-- @endcan --}}

          {{-- @can('access role') --}}
              <li><a class="nav-link" href="{{ route('roles.index') }}"><i class="fas fa-pencil-ruler"></i>
                      <span>Access</span></a>
              </li>
          {{-- @endcan --}}
  </aside>
</div>
