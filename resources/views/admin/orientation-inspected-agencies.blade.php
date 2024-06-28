@extends('admin.admin_master')
@section('admin')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Orientation (Inspected Agencies)</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Orientation (Inspected Agencies)</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- modal show dialog -->
    <div class="modal fade" id="modal-add-new-orientation-ia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-add-new-orientation-ia" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formOrientationIA" class="needs-validation" novalidate>
                        @csrf
                        <div class="card-body">
                            <input type="hidden" id="id" name="id">
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
                                <label for="date_of_inspection">Date of Inspection</label>
                                <input type="date" class="form-control @if ($errors->has('date_of_inspection')) is-invalid @endif" id="date_of_inspection" name="date_of_inspection" placeholder="Date of Inspection" required>
                                @if ($errors->has('date_of_inspection'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('date_of_inspection') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="office">Office</label>
                                <input type="text" class="form-control @if ($errors->has('office')) is-invalid @endif" id="office" name="office">
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
                                <label for="action_plan_and_inspection_report_date_sent_to_cmeo">Action Plan (Date Sent to CMEO)</label>
                                <input type="date" class="form-control @if ($errors->has('action_plan_and_inspection_report_date_sent_to_cmeo')) is-invalid @endif" id="action_plan_and_inspection_report_date_sent_to_cmeo" name="action_plan_and_inspection_report_date_sent_to_cmeo">
                                @if ($errors->has('action_plan_and_inspection_report_date_sent_to_cmeo'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('action_plan_and_inspection_report_date_sent_to_cmeo') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="feedback_date_sent_to_oddgo">Feedback (Date Sent to ODDGO)</label>
                                <input type="date" class="form-control @if ($errors->has('feedback_date_sent_to_oddgo')) is-invalid @endif" id="feedback_date_sent_to_oddgo" name="feedback_date_sent_to_oddgo">
                                @if ($errors->has('feedback_date_sent_to_oddgo'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('feedback_date_sent_to_oddgo') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="official_report_date_sent_to_oddgo">Official Reports (Date Sent to ODDGO)</label>
                                <input type="date" class="form-control @if ($errors->has('official_report_date_sent_to_oddgo')) is-invalid @endif" id="official_report_date_sent_to_oddgo" name="official_report_date_sent_to_oddgo">
                                @if ($errors->has('official_report_date_sent_to_oddgo'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('official_report_date_sent_to_oddgo') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="feedback_date_received_from_oddgo">Feedback (Date Received from ODDGO)</label>
                                <input type="date" class="form-control @if ($errors->has('feedback_date_received_from_oddgo')) is-invalid @endif" id="feedback_date_received_from_oddgo" name="feedback_date_received_from_oddgo">
                                @if ($errors->has('feedback_date_received_from_oddgo'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('feedback_date_received_from_oddgo') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="official_report_date_received_from_oddgo">Official Reports (Date Received from ODDGO)</label>
                                <input type="date" class="form-control @if ($errors->has('official_report_date_received_from_oddgo')) is-invalid @endif" id="official_report_date_received_from_oddgo" name="official_report_date_received_from_oddgo">
                                @if ($errors->has('official_report_date_received_from_oddgo'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('official_report_date_received_from_oddgo') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="feedback_date_sent_to_agencies_lgus">Feedback (Date Sent to Agencies/LGUs)</label>
                                <input type="date" class="form-control @if ($errors->has('feedback_date_sent_to_agencies_lgus')) is-invalid @endif" id="feedback_date_sent_to_agencies_lgus" name="feedback_date_sent_to_agencies_lgus">
                                @if ($errors->has('feedback_date_sent_to_agencies_lgus'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('feedback_date_sent_to_agencies_lgus') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="official_report_date_sent_to_agencies_lgus">Official Reports (Date Sent to Agencies/LGUs)</label>
                                <input type="date" class="form-control @if ($errors->has('official_report_date_sent_to_agencies_lgus')) is-invalid @endif" id="official_report_date_sent_to_agencies_lgus" name="official_report_date_sent_to_agencies_lgus">
                                @if ($errors->has('official_report_date_sent_to_agencies_lgus'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('official_report_date_sent_to_agencies_lgus') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="orientation">Orientation</label>
                                <input type="text" class="form-control @if ($errors->has('orientation')) is-invalid @endif" id="orientation" name="orientation">
                                @if ($errors->has('orientation'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('orientation') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="setup">Setup</label>
                                <input type="text" class="form-control @if ($errors->has('setup')) is-invalid @endif" id="setup" name="setup">
                                @if ($errors->has('setup'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('setup') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="resource_speakers">Resource Speakers</label>
                                <input type="text" class="form-control @if ($errors->has('resource_speakers')) is-invalid @endif" id="resource_speakers" name="resource_speakers">
                                @if ($errors->has('resource_speakers'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('resource_speakers') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="bpm_workshop">BPM Workshop</label>
                                <input type="text" class="form-control @if ($errors->has('bpm_workshop')) is-invalid @endif" id="bpm_workshop" name="bpm_workshop">
                                @if ($errors->has('bpm_workshop'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('bpm_workshop') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="re_engineering">Re-engineering</label>
                                <input type="text" class="form-control @if ($errors->has('re_engineering')) is-invalid @endif" id="re_engineering" name="re_engineering">
                                @if ($errors->has('re_engineering'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('re_engineering') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="cc_workshop">CC Workshop</label>
                                <input type="text" class="form-control @if ($errors->has('cc_workshop')) is-invalid @endif" id="cc_workshop" name="cc_workshop">
                                @if ($errors->has('cc_workshop'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('cc_workshop') }}
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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-new-orientation-ia">
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
                                <table id="dataTableOrientationInspectedAgencies" class="table table-hover table-striped table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="display: none;">#</th>
                                            <th>AGENCY/LGU</th>
                                            <th>DATE_OF_INSPECTION</th>
                                            <th>OFFICE</th>
                                            <th>CITY/MUNICIPALITY</th>
                                            <th>PROVINCE</th>
                                            <th>REGION</th>
                                            <th>ACTION_PLAN_AND_INSPECTION_REPORT (DATE_SENT_TO_CMEO)</th>
                                            <th>FEEDBACK (DATE_SENT_TO_ODDGO)</th>
                                            <th>OFFICIAL_REPORTS (DATE_SENT_TO_ODDGO)</th>
                                            <th>FEEDBACK (DATE_RECEIVED_FROM_ODDGO)</th>
                                            <th>OFFICIAL_REPORTS (DATE_RECEIVED_FROM_ODDGO)</th>
                                            <th>FEEDBACK (DATE_SENT_TO_AGENCIES/LGUs)</th>
                                            <th>OFFICIAL_REPORTS (DATE_SENT_TO_AGENCIES/LGUs)</th>
                                            <th>ORIENTATION</th>
                                            <th>SETUP</th>
                                            <th>RESOURCE_SPEAKERS</th>
                                            <th>BPM_WORKSHOP</th>
                                            <th>RE_ENGINEERING</th>
                                            <th>CC_WORKSHOP</th>
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
    let getDataFromOrientationIAURL = "{{ route('admin.orientation-inspected-agencies.getDataFromOrientationIA') }}";
    let storeOrientationIAURL = "{{ route('admin.orientation-inspected-agencies.store') }}";
    let editOrientationIAURL = "/admin/orientation-inspected-agencies";
    let updateOrientationIAURL = "/admin/orientation-inspected-agencies";
    let getProvincesByRegionURL = "/get-provinces-by-region";
    let getCityMunicipalityByProvinceURL = "/get-city-municipality-by-province";
</script>
<script src="{{ url('backend/assets/custom/js/orientation-inspected-agencies.min.js') }}"></script>
@endsection