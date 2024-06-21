@extends('admin.admin_master')
@section('admin')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Orientation (Overall)</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Orientation (Overall)</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- button -->
            @if (Auth::user()->roles === 'User')
            <div class="row mb-4">
                <div class="col-xl-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-new-commendation">
                        Add New
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
@endsection