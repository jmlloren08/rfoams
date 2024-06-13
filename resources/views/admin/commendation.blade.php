<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RFOAMiS | Commendation Page</title>
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
                            <a href="{{ route('admin.commendation') }}" class="nav-link active">
                                <i class="nav-icon fas fa-award"></i>
                                <p>Commendation</p>
                            </a>
                        </li>
                        <li class="nav-header">MANAGEMENT</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
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
                        <li class="nav-header">Roles and Assignment</li>
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
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Commendation</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Commendation</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <div class="modal fade" id="modal-add-new-commendation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-add-new-commendation-label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">New Commendation</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="formCommendation" class="needs-validation" novalidate>
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" id="id" name="id">
                                    <div class="form-group mb-2">
                                        <label for="date_of_commendation">Date of Commendation</label>
                                        <input type="date" class="form-control @if ($errors->has('date_of_commendation')) is-invalid @endif" id="date_of_commendation" name="date_of_commendation" placeholder="Date of Commendation" required>
                                        @if ($errors->has('date_of_commendation'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('date_of_commendation') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="region">Region</label>
                                        <select class="form-control custom-select" name="region" id="region" required>
                                            <option value="" selected disabled>Choose</option>
                                            @foreach ($regions as $region)
                                            <option value="{{ $region->regCode }}">{{ $region->regDesc }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('region'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('region') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="province">Province</label>
                                        <select class="form-control custom-select" name="province" id="province" required>
                                            <option value="" selected disabled>Choose</option>
                                        </select>
                                        @if ($errors->has('province'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('province') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="city_municipality">City/Municipality</label>
                                        <select class="form-control custom-select" name="city_municipality" id="city_municipality" required>
                                            <option value="" selected disabled>Choose</option>
                                        </select>
                                        @if ($errors->has('city_municipality'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('city_municipality') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="date_of_inspection">Date of Inspection</label>
                                        <input type="date" class="form-control @if ($errors->has('date_of_inspection')) is-invalid @endif" id="date_of_inspection" name="date_of_inspection" placeholder="e.g. 30-May-2023" required>
                                        @if ($errors->has('date_of_inspection'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('date_of_inspection') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="service_provider">Service Provider</label>
                                        <input type="text" class="form-control @if ($errors->has('service_provider')) is-invalid @endif" id="service_provider" name="service_provider">
                                        @if ($errors->has('service_provider'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('service_provider') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="first_validation">Date of First Validation</label>
                                        <input type="date" class="form-control @if ($errors->has('first_validation')) is-invalid @endif" id="first_validation" name="first_validation" placeholder="e.g. 30-May-2023" required>
                                        @if ($errors->has('first_validation'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('first_validation') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="remarks_1">Remarks</label>
                                        <input type="text" class="form-control @if ($errors->has('remarks_1')) is-invalid @endif" id="remarks_1" name="remarks_1">
                                        @if ($errors->has('remarks_1'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('remarks_1') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="second_validation">Date of Second Validation</label>
                                        <input type="date" class="form-control @if ($errors->has('second_validation')) is-invalid @endif" id="second_validation" name="second_validation" placeholder="e.g. 30-May-2023" required>
                                        @if ($errors->has('second_validation'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('second_validation') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="remarks_2">Remarks</label>
                                        <input type="text" class="form-control @if ($errors->has('remarks_2')) is-invalid @endif" id="remarks_2" name="remarks_2">
                                        @if ($errors->has('remarks_2'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('remarks_2') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="other_activity">Other activity</label>
                                        <input type="text" class="form-control @if ($errors->has('other_activity')) is-invalid @endif" id="other_activity" name="other_activity">
                                        @if ($errors->has('other_activity'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('other_activity') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="number_of_brgys"># of Barangays</label>
                                        <input type="number" class="form-control @if ($errors->has('number_of_brgys')) is-invalid @endif" id="number_of_brgys" name="number_of_brgys">
                                        @if ($errors->has('number_of_brgys'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('number_of_brgys') }}
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
            </div>
            <!-- /.modal-dialog -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- button -->
                    @if (Auth::user()->roles === 'User')
                    <div class="row mb-4">
                        <div class="col-xl-3">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-new-commendation">
                                New Commendation
                            </button>
                        </div>
                    </div>
                    @endif
                    <!-- regions -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-list"></i>
                                        Approved List
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="dataTableCommendation" class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="display: none;">#</th>
                                                    <th>DATE_OF_COMMENDATION</th>
                                                    <th>LGU_NAME</th>
                                                    <th>CITY/MUNICIPALITY</th>
                                                    <th>REGION</th>
                                                    <th>DATE_OF_INSPECTION</th>
                                                    <th>SERVICE_PROVIDER</th>
                                                    <th>VALIDATION_1</th>
                                                    <th>REMARKS</th>
                                                    <th>VALIDATION_2</th>
                                                    <th>REMARKS</th>
                                                    <th>OTHER_ACTIVITY</th>
                                                    <th>BRGYS</th>
                                                    <th>ACTION</th>
                                                </tr>
                                            </thead><!-- end thead -->
                                        </table> <!-- end table -->
                                    </div>
                                </div><!-- end card -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div>
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
        let getDataFromCommendationURL = "{{ route('admin.commendation.getDataFromCommendation') }}";
        let storeCommendationURL = "{{ route('admin.commendation.store') }}";
        let editCommendationURL = "/admin/commendation";
        let updateCommendationURL = "/admin/commendation";
        let getProvincesByRegionURL = "/get-provinces-by-region";
        let getCityMunicipalityByProvinceURL = "/get-city-municipality-by-province";
    </script>
    <script src="{{ url('backend/assets/custom/js/commendation.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
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