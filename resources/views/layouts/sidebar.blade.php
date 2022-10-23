<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="index-0.html">General Dashboard</a></li>
                    <li><a class="nav-link" href="index.html">Ecommerce Dashboard</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i>
                    <span>Pengaduan</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <div class="row">
                            <div class="col-md-6">
                                <a class="nav-link" href="{{route("list-open-ticket")}}">
                                    Open
                                </a>
                            </div>
                            <div class="col-md-4">
                                <span class="badge badge-success">{{$count_open}}</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-md-6">
                                <a class="nav-link" href="{{route("list-progress-ticket")}}">
                                    Progress
                                </a>
                            </div>
                            <div class="col-md-4">
                                <span class="badge badge-warning">{{$count_progress}}</span>
                            </div>
                        </div>
                    </li>
                    <li><div class="row">
                      <div class="col-md-6">
                          <a class="nav-link" href="{{route("list-close-ticket")}}">
                              close
                          </a>
                      </div>
                      <div class="col-md-4">
                          <span class="badge badge-danger">{{$count_close}}</span>
                      </div>
                  </div></li>

                </ul>
            </li>
            
            <li><a class="nav-link" href="credits.html"><i class="fas fa-pencil-ruler"></i> <span>Report</span></a>
            </li>
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div>
    </aside>
</div>
