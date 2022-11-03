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
                                                            <span class="badge badge-warning">{{ $count_progress }}</span>
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
                                                            <span
                                                                class="badge badge-danger">{{ $count_close }}</span>
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

    </aside>
</div>
