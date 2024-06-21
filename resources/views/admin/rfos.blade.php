@extends('admin.admin_master')
@section('admin')
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
                                        var values = ['Southern Luzon', 'Northern Luzon', 'Central Luzon', 'Western Visayas', 'Eastern Visayas', 'Northern Mindanao', 'Western Mindanao', 'Eastern Mindanao'];
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
                                <select class="form-control custom-select @if ($errors->has('user_id')) is-invalid @endif" name="user_id" id="user_id" required>
                                    <option value="" selected disabled>Select user</option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user-tie"></span>
                                    </div>
                                </div>
                                @if ($errors->has('user_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('user_id') }}
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
                            <div class="input-group mb-2">
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
                                <label>Assign region(s)</label>
                                <select name="regCode[]" id="regCode[]" class="select2 @if ($errors->has('regCode')) is-invalid @endif" multiple="multiple" data-placeholder="Search region" style="width: 100%;" required>
                                    @foreach ($regions as $region)
                                    <option value="{{ $region->regCode }}">{{ $region->regDesc }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('regCode'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('regCode') }}
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
            <div class="row">
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
                                            <th>ASSIGNED_REGIONS</th>
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
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
<!-- ./wrapper -->
<!-- custom js -->
@section('page-scripts')
<script>
    let getDataFromRFOsURL = "{{ route('admin.rfos.getDataFromRFOs') }}";
    let storeRFOsURL = "{{ route('admin.rfos.store') }}";
    let editRFOsURL = "/admin/rfos";
    let updateRFOsURL = "/admin/rfos";
</script>
<script src="{{ url('backend/assets/custom/js/rfo.js') }}"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
    });
</script>
@endsection