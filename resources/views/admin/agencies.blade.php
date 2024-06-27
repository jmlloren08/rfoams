@extends('admin.admin_master')
@section('admin')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Departments/Agencies</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Departments/Agencies</li>
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
                <!-- regions -->
                <div class="col-xl-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-list"></i>
                                Departments/Agencies
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTableDepartmentAgency" class="table table-hover table-striped table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="display: none;">#</th>
                                            <th>DEPARTMENT/AGENCY</th>
                                            <th>ADDRESS</th>
                                            <th>CONTACT_INFORMATION</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead><!-- end thead -->
                                </table> <!-- end table -->
                            </div>
                        </div><!-- end card -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div><!-- end row -->
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
@section('page-scripts')
<!-- custom js -->
<script>
    let getDataFromDepartmentAgencyURL = "{{ route('admin.agencies.getDataFromDepartmentAgency') }}";
    let editDataFromDepartmentAgencyURL = "/admin/agencies";
</script>
<script src="{{ url('backend/assets/custom/js/da.min.js') }}"></script>
@endsection