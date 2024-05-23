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
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @if (Auth::user()->roles !== 'Guest' && Auth::user()->roles !== NULL)
                <li class="nav-header">NAVIGATION</li>
                <li class="nav-item">
                    <a href="{{ route('admin.eboss') }}" class="nav-link">
                        <i class="nav-icon fas fa-laptop-house"></i>
                        <p>eBOSS</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.citizens-charter') }}" class="nav-link">
                        <i class="nav-icon far fa-newspaper"></i>
                        <p> Citizen's Charter</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.orientation') }}" class="nav-link">
                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                        <p>Orientation</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.commendation') }}" class="nav-link">
                        <i class="nav-icon fas fa-award"></i>
                        <p>Commendation</p>
                    </a>
                </li>
                @if (Auth::user()->roles === 'Admin')
                <li class="nav-header">MANAGEMENT</li>
                <li class="nav-item">
                    <a href="{{ route('admin.agencies') }}" class="nav-link">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Agencies</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.lgus') }}" class="nav-link">
                        <i class="nav-icon fas fa-university"></i>
                        <p>LGUs</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.rfos') }}" class="nav-link">
                        <i class="nav-icon fas fa-city"></i>
                        <p>RFOs</p>
                    </a>
                </li>
                <li class="nav-header">Roles</li>
                <li class="nav-item">
                    <a href="{{ route('admin.users') }}" class="nav-link">
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