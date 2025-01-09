@extends('admin.admin_master')
@section('admin')
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
                                    <option value="{{ $region->reg_code }}">{{ $region->reg_desc }}</option>
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
                                <table id="dataTableCommendation" class="table table-hover table-striped table-bordered">
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
<!-- ./wrapper -->
<!-- custom js -->
@section('page-scripts')
<script>
    let getDataFromCommendationURL = "{{ route('admin.commendation.getDataFromCommendation') }}";
    let storeCommendationURL = "{{ route('admin.commendation.store') }}";
    let editCommendationURL = "/admin/commendation";
    let updateCommendationURL = "/admin/commendation";
    let getProvincesByRegionURL = "/get-provinces-by-region";
    let getCityMunicipalityByProvinceURL = "/get-city-municipality-by-province";
</script>
<script src="{{ url('backend/assets/custom/js/commendation.min.js') }}"></script>
@endsection