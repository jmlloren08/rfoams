@extends('admin.admin_master')
@section('admin')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $counteBOSS }}</h3>
                            <p>eBOSS Inspection</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-laptop"></i>
                        </div>
                        <a href="{{ route('admin.eboss') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $countCommendation }}</h3>
                            <p>Commendation</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ribbon-a"></i>
                        </div>
                        <a href="{{ route('admin.commendation')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $countOrientationIA + $countOrientationOverall }}</h3>
                            <p>Orientations</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-people"></i>
                        </div>
                        <a href="{{ route('admin.orientation-overalls') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>0</h3>
                            <p>Citizen's Charter Inspection</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-closed-captioning"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title"><i class="fas fa-laptop-code"></i> Overall eBOSS</h3>
                                <div class="card-tools">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                                            <i class="fas fa-bars"></i>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a href="#" class="dropdown-item" id="download-jpg-eboss">Download JPG</a>
                                            <a href="#" class="dropdown-item" id="export-csv-eboss">Export CSV</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span>Per Region</span>
                                </p>
                            </div>
                            <div class="position-relative mb-4">
                                <canvas id="eboss-chart" height="200"></canvas>
                            </div>
                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary" data-color="#007bff"></i> Fully-Automated
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-square text-info" data-color="#17a2b8"></i> Partly-Automated
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-square text-warning" data-color="#ffc107"></i> Physical/Collocated BOSS
                                </span>
                                <span>
                                    <i class="fas fa-square text-danger" data-color="#dc3545"></i> No Collocated Boss
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card bg-gradient-info">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title"><i class="fas fa-award"></i> Overall Commendation</h3>
                                <div class="card-tools">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                                            <i class="fas fa-bars"></i>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a href="#" class="dropdown-item" id="download-jpg-commendation">Download JPG</a>
                                            <a href="#" class="dropdown-item" id="export-csv-commendation">Export CSV</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span>Per Month</span>
                                </p>
                            </div>
                            <div class="position-relative mb-4">
                                <canvas id="commendation-chart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title"><i class="fas fa-chart-bar"></i> Orientation (Compliance with R.A. 11032, and other programs)</h3>
                                <div class="card-tools">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                                            <i class="fas fa-bars"></i>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a href="#" class="dropdown-item" id="download-jpg-orientation-overall">Download JPG</a>
                                            <a href="#" class="dropdown-item" id="export-csv-orientation-overall">Export CSV</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="orientation-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
@section('page-scripts')
@if (!is_null(Auth::user()->roles))
<script>
    let chartData = @json($chartData);
    let types = @json($types);
    let commendationsData = @json($commendationsData);
    let programsData = @json($programsData);
    let countYes = programsData.map(item => item.countYes);
    let countNo = programsData.map(item => item.countNo);
</script>
<script src="{{ url('backend/assets/custom/js/eboss-chart.min.js') }}"></script>
<script src="{{ url('backend/assets/custom/js/commendation-chart.min.js') }}"></script>
<script src="{{ url('backend/assets/custom/js/orientation-chart.min.js') }}"></script>
@endif
@endsection