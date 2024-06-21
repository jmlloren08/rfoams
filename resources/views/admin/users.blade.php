@extends('admin.admin_master')
@section('admin')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="modal fade" id="modal-edit-users" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-edit-users-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update user role</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formUser" class="needs-validation" novalidate>
                        @csrf
                        <div class="card-body">
                            <input type="hidden" id="id" name="id">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @if ($errors->has('name')) is-invalid @endif" id="name" name="name" required readonly>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user-tie"></span>
                                    </div>
                                </div>
                                @if ($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                                @endif
                            </div>
                            <div class="input-group mb-3">
                                <input type="email" class="form-control @if ($errors->has('email')) is-invalid @endif" id="email" name="email" required readonly>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                                @if ($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                                @endif
                            </div>
                            <div class="input-group mb-3">
                                <select class="form-control custom-select @if ($errors->has('roles')) is-invalid @endif" name="roles" id="roles" required>
                                    <option value="" selected disabled>Select role</option>
                                    <script>
                                        var selectRole = document.getElementById('roles');
                                        var values = ['User', 'Administrator', 'Super-Administrator'];
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
                                        <span class="fas fa-user-tag"></span>
                                    </div>
                                </div>
                                @if ($errors->has('roles'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('roles') }}
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
            <!-- regions -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-list"></i>
                                Users
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTableUsers" class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="display: none;">#</th>
                                            <th>NAME</th>
                                            <th>EMAIL_ADDRESS</th>
                                            <th>STATUS</th>
                                            <th>ROLES</th>
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
    let getDataFromUsersURL = "{{ route('admin.users.getDataFromUsers') }}";
    let editUsersURL = "/admin/users";
    let updateUsersURL = "/admin/users";
    let removeUserURL = "/admin/users";
    let deleteUserURL = "/admin/users";
</script>
<script src="{{ url('backend/assets/custom/js/users.js') }}"></script>
@endsection