@extends('admin.admin_master')
@section('admin')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">List of cities and municipalities</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">List of cities and municipalities</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- start table -->
            <div class="row">
                <!-- regions -->
                <div class="col-xl-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-list"></i>
                                Regions
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTableRefRegion" class="table table-hover table-striped table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="display: none;">#</th>
                                            <th>PSGCCODE</th>
                                            <th>REGION</th>
                                            <th>REGCODE</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead><!-- end thead -->
                                </table> <!-- end table -->
                            </div>
                        </div><!-- end card -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div><!-- end row -->
            <!-- province -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-list"></i>
                                Provinces
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTableRefProvince" class="table table-hover table-striped table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="display: none;">#</th>
                                            <th>PSGCCODE</th>
                                            <th>PROVINCES</th>
                                            <th>REGCODE</th>
                                            <th>PROVCODE</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead><!-- end thead -->
                                </table> <!-- end table -->
                            </div>
                        </div><!-- end card -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div>
            <!-- city/municipality -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-list"></i>
                                Cities/Municipalities
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTableRefCityMun" class="table table-hover table-striped table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="display: none;">#</th>
                                            <th>PSGCCODE</th>
                                            <th>CITIES/MUNICIPALITIES</th>
                                            <th>REGCODE</th>
                                            <th>PROVCODE</th>
                                            <th>CITYMUNCODE</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead><!-- end thead -->
                                </table> <!-- end table -->
                            </div>
                        </div><!-- end card -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div>
            <!-- Barangays -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card card-warning card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-list"></i>
                                Barangays
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTableRefBarangay" class="table table-hover table-striped table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="display: none;">#</th>
                                            <th>BRGYCODE</th>
                                            <th>BARANGAYS</th>
                                            <th>REGCODE</th>
                                            <th>PROVCODE</th>
                                            <th>CITYMUNCODE</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead><!-- end thead -->
                                </table> <!-- end table -->
                            </div>
                        </div><!-- end card -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div>
            <!-- end table -->
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
<!-- custom js -->
@section('page-scripts')
<script>
    let getDataFromRefRegionURL = "{{ route('admin.lgus.getDataFromRefRegion') }}";
    let getDataFromRefProvinceURL = "{{ route('admin.lgus.getDataFromRefProvince') }}";
    let getDataFromRefCityMunURL = "{{ route('admin.lgus.getDataFromRefCityMun') }}";
    let getDataFromRefBarangayURL = "{{ route('admin.lgus.getDataFromRefBarangay') }}";
    let editDataFromRefRegionURL = "/admin/lgus";
</script>
<script src="{{ url('backend/assets/custom/js/lgus.min.js') }}"></script>
@endsection