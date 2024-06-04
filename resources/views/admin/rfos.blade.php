<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RFOAMiS | RFO Page</title>
    <!-- jQuery -->
    <script src="{{ url('backend/assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ url('backend/assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- moment js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- DataTables -->
    <link href="{{ url('backend/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- sweetalert -->
    <link rel="stylesheet" href="{{ url('backend/assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('backend/assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ url('backend/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ url('backend/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ url('backend/assets/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('backend/assets/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ url('backend/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ url('backend/assets/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ url('backend/assets/plugins/summernote/summernote-bs4.min.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.body.header')
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
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
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
                            <a href="{{ route('admin.rfos') }}" class="nav-link active">
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
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Regional Field Office/s</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Regional Field Office/s</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <div class="modal fade" id="modal-add-new-rfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-add-new-rfo-label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add New RFO</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="formRFO" class="needs-validation" novalidate>
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" id="id" name="id">
                                    <div class="input-group mb-3">
                                        <select class="form-control custom-select @if ($errors->has('rfo')) is-invalid @endif" name="rfo" id="rfo" required>
                                            <option value="" selected disabled>Select RFO</option>
                                            <script>
                                                var selectRole = document.getElementById('rfo');
                                                var values = ['Southern Luzon', 'Northern Luzon','Central Luzon', 'Western Visayas','Eastern Visayas','Northern Mindanao','Western Mindanao','Eastern Mindanao'];
                                                values.forEach(function(value) {
                                                    var option = document.createElement('option');
                                                    option.value = value;
                                                    option.innerHTML = value;
                                                    selectRole.appendChild(option);
                                                });
                                            </script>
                                        </select>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-city"></span>
                                            </div>
                                        </div>
                                        @if ($errors->has('rfo'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('rfo') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control @if ($errors->has('focal_person')) is-invalid @endif" id="focal_person" name="focal_person" placeholder="Focal Person" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-user-tie"></span>
                                            </div>
                                        </div>
                                        @if ($errors->has('focal_person'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('focal_person') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control @if ($errors->has('position')) is-invalid @endif" id="position" name="position" placeholder="Position" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-user-tag"></span>
                                            </div>
                                        </div>
                                        @if ($errors->has('position'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('position') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control @if ($errors->has('contact_number')) is-invalid @endif" id="contact_number" name="contact_number" placeholder="Contact Number (e.g. 09123456789)" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-mobile-alt"></span>
                                            </div>
                                        </div>
                                        @if ($errors->has('contact_number'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('contact_number') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="email" class="form-control @if ($errors->has('email_address')) is-invalid @endif" id="email_address" name="email_address" placeholder="Email Address" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-envelope"></span>
                                            </div>
                                        </div>
                                        @if ($errors->has('email_address'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email_address') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                            <!-- /.form-box -->
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row mb-4">
                        <div class="col-xl-3">
                            <!-- button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-new-rfo">
                                Add New
                            </button>
                        </div>
                    </div>
                    <!-- regions -->
                    <div class="col-xl-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-list"></i>
                                    Regional Field Office/s
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="dataTableRFOs" class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="display: none;">#</th>
                                                <th>RFO</th>
                                                <th>FOCAL_PERSON</th>
                                                <th>POSITION</th>
                                                <th>CONTACT_NUMBER</th>
                                                <th>EMAIL_ADDRESS</th>
                                                <th>CREATED_AT</th>
                                                <th>UPDATED_AT</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead><!-- end thead -->
                                    </table> <!-- end table -->
                                </div>
                            </div><!-- end card -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        @include('admin.body.footer')
    </div>
    <!-- ./wrapper -->
    <!-- custom js -->
    <script>
        let getDataFromRFOsURL = "{{ route('admin.rfos.getDataFromRFOs') }}";
        let storeRFOsURL = "{{ route('admin.rfos.store') }}";
        let editRFOsURL = "/admin/rfos";
        let updateRFOsURL = "/admin/rfos";
    </script>
    <script src="{{ url('backend/assets/custom/js/rfo.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- moment js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- Required datatable js -->
    <script src="{{ url('backend/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('backend/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- sweetalert -->
    <script src="{{ url('backend/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('backend/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ url('backend/assets/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ url('backend/assets/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ url('backend/assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ url('backend/assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ url('backend/assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ url('backend/assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ url('backend/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ url('backend/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ url('backend/assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ url('backend/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('backend/assets/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ url('backend/assets/dist/js/demo.js') }}"></script>
</body>

</html>