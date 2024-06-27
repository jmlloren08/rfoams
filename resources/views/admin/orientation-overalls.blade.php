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
    <!-- modal show dialog -->
    <div class="modal fade" id="modal-add-new-orientation-overalls" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-add-new-orientation-overalls" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formOrientationOverall" class="needs-validation" novalidate>
                        @csrf
                        <div class="card-body">
                            <input type="hidden" id="id" name="id">
                            <div class="form-group mb-2">
                                <label for="orientation_date">DATE</label>
                                <input type="text" class="form-control @if ($errors->has('orientation_date')) is-invalid @endif" id="reservation" name="orientation_date" placeholder="Date" required>
                                @if ($errors->has('orientation_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('orientation_date') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="agency_lgu">Agency/LGUs</label>
                                <input class="form-control  @if ($errors->has('agency_lgu')) is-invalid @endif" list="datalistOptions" id="agency_lgu" name="agency_lgu" placeholder="Type to search..." required>
                                <datalist id="datalistOptions">
                                    @foreach ($agencies_lgus as $agency_lgu)
                                    <option value="{{ $agency_lgu->department_agencies }}" data-id="{{ $agency_lgu->id }}">
                                        @endforeach
                                </datalist>
                            </div>
                            <div class="form-group mb-2">
                                <label for="office">Office</label>
                                <input type="text" class="form-control @if ($errors->has('office')) is-invalid @endif" id="office" name="office" required>
                                @if ($errors->has('office'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('office') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="region">Region</label>
                                <select class="form-control custom-select" name="region" id="region" required>
                                    <option value="" selected disabled>Choose</option>
                                    @foreach ($regions_overall as $regions)
                                    <option value="{{ $regions->regCode }}">{{ $regions->regDesc }}</option>
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
                                <label for="is_ra_11032">R.A. 11032</label>
                                <select class="form-control custom-select @if ($errors->has('is_ra_11032')) is-invalid @endif" name="is_ra_11032" id="is_ra_11032" required>
                                    <option value="" selected disabled>Choose</option>
                                    <script>
                                        var selectYN = document.getElementById('is_ra_11032');
                                        var values = ['Yes', 'No'];
                                        values.forEach(function(value) {
                                            var option = document.createElement('option');
                                            option.value = value;
                                            option.innerHTML = value;
                                            selectYN.appendChild(option);
                                        });
                                    </script>
                                </select>
                                @if ($errors->has('is_ra_11032'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('is_ra_11032') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="is_cart">CART</label>
                                <select class="form-control custom-select @if ($errors->has('is_cart')) is-invalid @endif" name="is_cart" id="is_cart" required>
                                    <option value="" selected disabled>Choose</option>
                                    <script>
                                        var selectYN = document.getElementById('is_cart');
                                        var values = ['Yes', 'No'];
                                        values.forEach(function(value) {
                                            var option = document.createElement('option');
                                            option.value = value;
                                            option.innerHTML = value;
                                            selectYN.appendChild(option);
                                        });
                                    </script>
                                </select>
                                @if ($errors->has('is_cart'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('is_cart') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="is_programs_and_services">PROGRAMS_AND_SERVICES</label>
                                <select class="form-control custom-select @if ($errors->has('is_programs_and_services')) is-invalid @endif" name="is_programs_and_services" id="is_programs_and_services" required>
                                    <option value="" selected disabled>Choose</option>
                                    <script>
                                        var selectYN = document.getElementById('is_programs_and_services');
                                        var values = ['Yes', 'No'];
                                        values.forEach(function(value) {
                                            var option = document.createElement('option');
                                            option.value = value;
                                            option.innerHTML = value;
                                            selectYN.appendChild(option);
                                        });
                                    </script>
                                </select>
                                @if ($errors->has('is_programs_and_services'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('is_programs_and_services') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="is_cc_orientation">CC_ORIENTATION</label>
                                <select class="form-control custom-select @if ($errors->has('is_cc_orientation')) is-invalid @endif" name="is_cc_orientation" id="is_cc_orientation" required>
                                    <option value="" selected disabled>Choose</option>
                                    <script>
                                        var selectYN = document.getElementById('is_cc_orientation');
                                        var values = ['Yes', 'No'];
                                        values.forEach(function(value) {
                                            var option = document.createElement('option');
                                            option.value = value;
                                            option.innerHTML = value;
                                            selectYN.appendChild(option);
                                        });
                                    </script>
                                </select>
                                @if ($errors->has('is_cc_orientation'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('is_cc_orientation') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="is_cc_workshop">CC_WORKSHOP</label>
                                <select class="form-control custom-select @if ($errors->has('is_cc_workshop')) is-invalid @endif" name="is_cc_workshop" id="is_cc_workshop" required>
                                    <option value="" selected disabled>Choose</option>
                                    <script>
                                        var selectYN = document.getElementById('is_cc_workshop');
                                        var values = ['Yes', 'No'];
                                        values.forEach(function(value) {
                                            var option = document.createElement('option');
                                            option.value = value;
                                            option.innerHTML = value;
                                            selectYN.appendChild(option);
                                        });
                                    </script>
                                </select>
                                @if ($errors->has('is_cc_workshop'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('is_cc_workshop') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="is_bpm_workshop">BPM_WORKSHOP</label>
                                <select class="form-control custom-select @if ($errors->has('is_bpm_workshop')) is-invalid @endif" name="is_bpm_workshop" id="is_bpm_workshop" required>
                                    <option value="" selected disabled>Choose</option>
                                    <script>
                                        var selectYN = document.getElementById('is_bpm_workshop');
                                        var values = ['Yes', 'No'];
                                        values.forEach(function(value) {
                                            var option = document.createElement('option');
                                            option.value = value;
                                            option.innerHTML = value;
                                            selectYN.appendChild(option);
                                        });
                                    </script>
                                </select>
                                @if ($errors->has('is_bpm_workshop'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('is_bpm_workshop') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="is_ria">RIA</label>
                                <select class="form-control custom-select @if ($errors->has('is_ria')) is-invalid @endif" name="is_ria" id="is_ria" required>
                                    <option value="" selected disabled>Choose</option>
                                    <script>
                                        var selectYN = document.getElementById('is_ria');
                                        var values = ['Yes', 'No'];
                                        values.forEach(function(value) {
                                            var option = document.createElement('option');
                                            option.value = value;
                                            option.innerHTML = value;
                                            selectYN.appendChild(option);
                                        });
                                    </script>
                                </select>
                                @if ($errors->has('is_ria'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('is_ria') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="is_eboss">eBOSS</label>
                                <select class="form-control custom-select @if ($errors->has('is_eboss')) is-invalid @endif" name="is_eboss" id="is_eboss" required>
                                    <option value="" selected disabled>Choose</option>
                                    <script>
                                        var selectYN = document.getElementById('is_eboss');
                                        var values = ['Yes', 'No'];
                                        values.forEach(function(value) {
                                            var option = document.createElement('option');
                                            option.value = value;
                                            option.innerHTML = value;
                                            selectYN.appendChild(option);
                                        });
                                    </script>
                                </select>
                                @if ($errors->has('is_eboss'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('is_eboss') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="is_csm">CSM</label>
                                <select class="form-control custom-select @if ($errors->has('is_csm')) is-invalid @endif" name="is_csm" id="is_csm" required>
                                    <option value="" selected disabled>Choose</option>
                                    <script>
                                        var selectYN = document.getElementById('is_csm');
                                        var values = ['Yes', 'No'];
                                        values.forEach(function(value) {
                                            var option = document.createElement('option');
                                            option.value = value;
                                            option.innerHTML = value;
                                            selectYN.appendChild(option);
                                        });
                                    </script>
                                </select>
                                @if ($errors->has('is_csm'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('is_csm') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="is_reeng">REENG</label>
                                <select class="form-control custom-select @if ($errors->has('is_reeng')) is-invalid @endif" name="is_reeng" id="is_reeng" required>
                                    <option value="" selected disabled>Choose</option>
                                    <script>
                                        var selectYN = document.getElementById('is_reeng');
                                        var values = ['Yes', 'No'];
                                        values.forEach(function(value) {
                                            var option = document.createElement('option');
                                            option.value = value;
                                            option.innerHTML = value;
                                            selectYN.appendChild(option);
                                        });
                                    </script>
                                </select>
                                @if ($errors->has('is_reeng'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('is_reeng') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- button -->
            @if (Auth::user()->roles === 'User')
            <div class="row mb-4">
                <div class="col-xl-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-new-orientation-overalls">
                        Add New
                    </button>
                </div>
            </div>
            @endif
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
                                <table id="dataTableOrientationOverall" class="table table-hover table-striped table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="display: none;">#</th>
                                            <th>DATE</th>
                                            <th>AGENCY/LGU</th>
                                            <th>OFFICE</th>
                                            <th>CITY/MUNICIPALITY</th>
                                            <th>PROVINCE</th>
                                            <th>REGION</th>
                                            <th>R.A.11032</th>
                                            <th>CART</th>
                                            <th>PROGRAMS_AND_SERVICES</th>
                                            <th>CC_ORIENTATION</th>
                                            <th>CC_WORKSHOP</th>
                                            <th>BPM_WORKSHOP</th>
                                            <th>RIA</th>
                                            <th>eBOSS</th>
                                            <th>CSM</th>
                                            <th>REENG</th>
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
<!-- custom js -->
@section('page-scripts')
<script>
    let getDataFromOrientationOverallURL = "{{ route('admin.orientation-overalls.getDataFromOrientationOverall') }}";
    let storeOrientationOverallURL = "{{ route('admin.orientation-overalls.store') }}";
    let editOrientationOverallURL = "/admin/orientation-overalls";
    let updateOrientationOverallURL = "/admin/orientation-overalls";
    let getProvincesByRegionURL = "/get-provinces-by-region";
    let getCityMunicipalityByProvinceURL = "/get-city-municipality-by-province";
    $(() => {
        $('#reservation').daterangepicker();
    });
</script>
<script src="{{ url('backend/assets/custom/js/orientation-overalls.js') }}"></script>
@endsection