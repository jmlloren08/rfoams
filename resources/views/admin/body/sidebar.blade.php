<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="javascript:void(0)" class="brand-link">
        <img src="{{ url('backend/assets/dist/img/logo-arta.png') }}" alt="ARTA Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">RFOAMiS | Insight</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ url('backend/assets/dist/img/avatar5.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="javascript:void(0)" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>
        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @if (Auth::user()->roles !== 'Guest' && Auth::user()->roles !== NULL)
                <li class="nav-header">NAVIGATION</li>
                <li class="nav-item">
                    <a href="{{ route('admin.eboss') }}" class="nav-link {{ Request::is('admin/eboss') ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-laptop-house"></i>
                        <p>eBOSS</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.commendation') }}" class="nav-link {{ Request::is('admin/commendation') ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-award"></i>
                        <p>Commendation</p>
                    </a>
                </li>
                <li class="nav-item menu-{{ Request::is('admin/orientation-inspected-agencies') || Request::is('admin/orientation-overall') ? 'open' : 'close' }}">
                    <a href="#" class="nav-link {{ Request::is('admin/orientation-inspected-agencies') || Request::is('admin/orientation-overall') ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                        <p>
                            Orientation
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.orientation-inspected-agencies')}}" class="nav-link {{ Request::is('admin/orientation-inspected-agencies') ? 'active' : '' }} ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Inspected Agencies</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.orientation-overall') }}" class="nav-link {{ Request::is('admin/orientation-overall') ? 'active' : '' }} ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Overall</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.citizens-charter') }}" class="nav-link {{ Request::is('admin/citizen-charter') ? 'active' : '' }} ">
                        <i class="nav-icon far fa-newspaper"></i>
                        <p> Citizen's Charter</p>
                    </a>
                </li>
                <li class="nav-header">MANAGEMENT</li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ Request::is('admin/for-approval') ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-thumbs-up"></i>
                        <p>For Approval</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-undo"></i>
                        <p>Returned</p>
                    </a>
                </li>
                @if (Auth::user()->roles === 'Administrator')
                <li class="nav-item">
                    <a href="{{ route('admin.agencies') }}" class="nav-link {{ Request::is('admin/for-approval') ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Agencies</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.lgus') }}" class="nav-link {{ Request::is('admin/lgus') ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-university"></i>
                        <p>LGUs</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.rfos') }}" class="nav-link {{ Request::is('admin/rfos') ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-city"></i>
                        <p>RFOs</p>
                    </a>
                </li>
                <li class="nav-header">Roles</li>
                <li class="nav-item">
                    <a href="{{ route('admin.users') }}" class="nav-link {{ Request::is('admin/users') ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>Users</p>
                    </a>
                </li>
                @endif
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>