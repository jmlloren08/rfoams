@extends('admin.admin_master')
@section('admin')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">eBOSS</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">eBOSS</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- modal -->
    <div class="modal fade" id="modal-add-new-eboss" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-add-new-eboss-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New eBOSS Inspection</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formeBOSS" class="needs-validation" novalidate>
                        @csrf
                        <div class="card-body">
                            <input type="hidden" id="id" name="id">
                            <div class="form-group mb-2">
                                <label for="date_of_inspection">Date of Inspection</label>
                                <input type="date" class="form-control @if ($errors->has('date_of_inspection')) is-invalid @endif" id="date_of_inspection" name="date_of_inspection" placeholder="Date of Inspection" required>
                                @if ($errors->has('date_of_inspection'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('date_of_inspection') }}
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
                                <label for="eboss_submission">eBOSS Submission</label>
                                <div class="row">
                                    <div class="col-md-5 d-flex align-items-center">
                                        <input type="date" class="form-control @if ($errors->has('eboss_submission')) is-invalid @endif" id="eboss_submission" name="eboss_submission" placeholder="e.g. 30-May-2023" required>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-center"></div>
                                    <div class="col-md-6 d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input" id="no_submission" name="no_submission">
                                        <label class="form-check-label" for="no_submission">No Submission</label>
                                    </div>
                                </div>
                                @if ($errors->has('eboss_submission'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('eboss_submission') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="type_of_boss">Type of BOSS</label>
                                <select class="form-control custom-select @if ($errors->has('type_of_boss')) is-invalid @endif" name="type_of_boss" id="type_of_boss" required>
                                    <option value="" selected disabled>Choose</option>
                                    <script>
                                        let selectRole = document.getElementById('type_of_boss');
                                        let values = ['Fully-Automated', 'Partly-Automated', 'Physical/Collocated BOSS', 'No Collocated BOSS'];
                                        values.forEach(function(value) {
                                            let option = document.createElement('option');
                                            option.value = value;
                                            option.innerHTML = value;
                                            selectRole.appendChild(option);
                                        });
                                    </script>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="deadline_of_action_plan">Deadline of Action Plan</label>
                                <div class="row">
                                    <div class="col-md-5 d-flex align-items-center">
                                        <input type="date" class="form-control @if ($errors->has('deadline_of_action_plan')) is-invalid @endif" id="deadline_of_action_plan" name="deadline_of_action_plan" placeholder="e.g. 30-May-2023" required>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-center"></div>
                                    <div class="col-md-6 d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input" id="not_applicable_doap" name="not_applicable_doap">
                                        <label class="form-check-label" for="not_applicable_doap">Not Applicable</label>
                                    </div>
                                </div>
                                @if ($errors->has('deadline_of_action_plan'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('deadline_of_action_plan') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="submission_of_action_plan">Submission of Action Plan/Letter of Explanation</label>
                                <div class="row">
                                    <div class="col-md-5 d-flex align-items-center">
                                        <input type="date" class="form-control @if ($errors->has('submission_of_action_plan')) is-invalid @endif" id="submission_of_action_plan" name="submission_of_action_plan" placeholder="e.g. 30-May-2023" required>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-center"></div>
                                    <div class="col-md-6 d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input" id="not_applicable_soap" name="not_applicable_soap">
                                        <label class="form-check-label" for="not_applicable_soap">Not Applicable</label>
                                    </div>
                                </div>
                                @if ($errors->has('submission_of_action_plan'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('submission_of_action_plan') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="remarks">Remarks</label>
                                <input type="text" class="form-control @if ($errors->has('remarks')) is-invalid @endif" id="remarks" name="remarks">
                                @if ($errors->has('remarks'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('remarks') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="bplo_head">BPLO Head</label>
                                <input type="text" class="form-control @if ($errors->has('bplo_head')) is-invalid @endif" id="bplo_head" name="bplo_head">
                                @if ($errors->has('bplo_head'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('bplo_head') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="contact_no">Contact No.</label>
                                <input type="number" class="form-control @if ($errors->has('contact_no')) is-invalid @endif" id="contact_no" name="contact_no" placeholder="e.g. 09123456789">
                                @if ($errors->has('contact_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('contact_no') }}
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
            <!-- card -->
            <div class="row mb-2">
                <!-- full-automated -->
                <div class="col-lg-3">
                    <div class="card card-primary">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Fully-Automated</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">Per Year</span>
                                    <span>Total: {{ $fullyAutomated2023 + $fullyAutomated2024 }}</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    @if ($fullyAutomated2023 != 0) <span class="text-{{ ($fullyAutomated2024 > $fullyAutomated2023) ? 'success' : 'danger' }}">
                                        <i class="fas fa-{{ ($fullyAutomated2024 > $fullyAutomated2023) ? 'arrow-up' : 'arrow-down' }}"></i>
                                        {{ number_format((abs($fullyAutomated2024 - $fullyAutomated2023) / $fullyAutomated2023)* 100, 2)}}%
                                    </span>
                                    @elseif ($fullyAutomated2023 == 0 && $fullyAutomated2024 == 0)
                                    <span class="text-muted">No data</span>
                                    @else
                                    <span class="text-muted">No data for 2023</span>
                                    @endif
                                    <span class="text-muted">Since last year</span>
                                </p>
                            </div>
                            <div class="position-relative mb-4">
                                <canvas id="fa-chart" height="200"></canvas>
                            </div>
                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-teal" data-color="#20c997"></i> 2023
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-square text-orange" data-color="#fd7e14"></i> 2024
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- partly-automated -->
                <div class="col-lg-3">
                    <div class="card card-info">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Partly-Automated</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">Per Year</span>
                                    <span>Total: {{ $partlyAutomated2023 + $partlyAutomated2024 }}</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    @if ($partlyAutomated2023 != 0) <span class="text-{{ ($partlyAutomated2024 > $partlyAutomated2023) ? 'success' : 'danger' }}">
                                        <i class="fas fa-{{ ($partlyAutomated2024 > $partlyAutomated2023) ? 'arrow-up' : 'arrow-down' }}"></i>
                                        {{ number_format((abs($partlyAutomated2024 - $partlyAutomated2023) / $partlyAutomated2023) * 100, 2)}}%
                                    </span>
                                    @elseif ($fullyAutomated2023 == 0 && $fullyAutomated2024 == 0)
                                    <span class="text-muted">No data</span>
                                    @else
                                    <span class="text-muted">No data for 2023</span>
                                    @endif
                                    <span class="text-muted">Since last year</span>
                                </p>
                            </div>
                            <div class="position-relative mb-4">
                                <canvas id="pa-chart" height="200"></canvas>
                            </div>
                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-teal" data-color="#20c997"></i> 2023
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-square text-orange" data-color="#fd7e14"></i> 2024
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- physical-collocated -->
                <div class="col-lg-3">
                    <div class="card card-warning">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Physical/Collocated BOSS</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">Per Year</span>
                                    <span>Total: {{ $physicalCollocated2023 + $physicalCollocated2024 }}</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    @if ($physicalCollocated2023 != 0) <span class="text-{{ ($physicalCollocated2024 > $physicalCollocated2023) ? 'success' : 'danger' }}">
                                        <i class="fas fa-{{ ($physicalCollocated2024 > $physicalCollocated2023) ? 'arrow-up' : 'arrow-down' }}"></i>
                                        {{ number_format((abs($physicalCollocated2024 - $physicalCollocated2023) / $physicalCollocated2023) * 100, 2)}}%
                                    </span>
                                    @elseif ($fullyAutomated2023 == 0 && $fullyAutomated2024 == 0)
                                    <span class="text-muted">No data</span>
                                    @else
                                    <span class="text-muted">No data for 2023</span>
                                    @endif
                                    <span class="text-muted">Since last year</span>
                                </p>
                            </div>
                            <div class="position-relative mb-4">
                                <canvas id="pc-chart" height="200"></canvas>
                            </div>
                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-teal" data-color="#20c997"></i> 2023
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-square text-orange" data-color="#fd7e14"></i> 2024
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- no-collocated -->
                <div class="col-lg-3">
                    <div class="card card-danger">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">No Collocated BOSS</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">Per Year</span>
                                    <span>Total: {{ $noCollocatedBOSS2023 + $noCollocatedBOSS2024 }}</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    @if ($noCollocatedBOSS2023 != 0) <span class="text-{{ ($noCollocatedBOSS2024 > $noCollocatedBOSS2024) ? 'success' : 'danger' }}">
                                        <i class="fas fa-{{ ($noCollocatedBOSS2024 > $noCollocatedBOSS2023) ? 'arrow-up' : 'arrow-down' }}"></i>
                                        {{ number_format((abs($noCollocatedBOSS2024 - $noCollocatedBOSS2023) / $noCollocatedBOSS2023) * 100, 2)}}%
                                    </span>
                                    @elseif ($fullyAutomated2023 == 0 && $fullyAutomated2024 == 0)
                                    <span class="text-muted">No data</span>
                                    @else
                                    <span class="text-muted">No data for 2023</span>
                                    @endif
                                    <span class="text-muted">Since last year</span>
                                </p>
                            </div>
                            <div class="position-relative mb-4">
                                <canvas id="nc-chart" height="200"></canvas>
                            </div>
                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-teal" data-color="#20c997"></i> 2023
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-square text-orange" data-color="#fd7e14"></i> 2024
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- button -->
            @if (Auth::user()->roles === 'User')
            <div class="row mb-4">
                <div class="col-xl-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-new-eboss">
                        New Inspection
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
                                <table id="dataTableeBOSS" class="table table-hover table-striped table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="display: none;">#</th>
                                            <th>DATE_OF_INSPECTION</th>
                                            <th>CITY/MUNICIPALITY</th>
                                            <th>PROVINCE</th>
                                            <th>REGION</th>
                                            <th>DATE_SUBMITTED</th>
                                            <th>TYPE_OF_BOSS</th>
                                            <th>DEADLINE_OF_ACTION_PLAN</th>
                                            <th>SUBMISSION_OF_ACTION_PLAN</th>
                                            <th>REMARKS</th>
                                            <th>BPLO_HEAD</th>
                                            <th>CONTACT_NO</th>
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
    let getDataFromeBOSSURL = "{{ route('admin.eboss.getDataFromeBOSS') }}";
    let storeeBOSSURL = "{{ route('admin.eboss.store') }}";
    let editeBOSSURL = "/admin/eboss";
    let updateeBOSSURL = "/admin/eboss";
    let getProvincesByRegionURL = "/get-provinces-by-region";
    let getCityMuncipalityByProvinceURL = "/get-city-municipality-by-province";
    let fullyAutomated2023 = @json($fullyAutomated2023);
    let fullyAutomated2024 = @json($fullyAutomated2024);
    let partlyAutomated2023 = @json($partlyAutomated2023);
    let partlyAutomated2024 = @json($partlyAutomated2024);
    let physicalCollocated2023 = @json($physicalCollocated2023);
    let physicalCollocated2024 = @json($physicalCollocated2024);
    let noCollocatedBOSS2023 = @json($noCollocatedBOSS2023);
    let noCollocatedBOSS2024 = @json($noCollocatedBOSS2024);
</script>
<script src="{{ url('backend/assets/custom/js/eboss.js') }}"></script>
@endsection