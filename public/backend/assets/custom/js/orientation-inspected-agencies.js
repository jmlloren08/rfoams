$(() => {
    'use strict'
    let tableOrientationIA = $('#dataTableOrientationInspectedAgencies').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: getDataFromOrientationIAURL,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        columns: [
            { data: 'id', visible: false },
            { data: 'agency_lgu' },
            { data: 'date_of_inspection' },
            { data: 'office' },
            { data: 'citymun_desc' },
            { data: 'prov_desc' },
            { data: 'reg_desc' },
            { data: 'action_plan_and_inspection_report_date_sent_to_cmeo' },
            { data: 'feedback_date_sent_to_oddgo' },
            { data: 'official_report_date_sent_to_oddgo' },
            { data: 'feedback_date_received_from_oddgo' },
            { data: 'official_report_date_received_from_oddgo' },
            { data: 'feedback_date_sent_to_agencies_lgus' },
            { data: 'official_report_date_sent_to_agencies_lgus' },
            { data: 'orientation' },
            { data: 'setup' },
            { data: 'resource_speakers' },
            { data: 'bpm_workshop' },
            { data: 're_engineering' },
            { data: 'cc_workshop' },
            {
                data: '',
                defaultContent: `<td class="text-right py-0 align-middle">
                    <div class="btn-group btn-group-sm">
                    <a class="btn btn-info" id="btnEdit" title="Edit data"><i class="fas fa-edit"></i></a>
                    <a class="btn btn-danger" id="btnDelete" title="Delete data"><i class="fas fa-times-circle"></i></a>
                    </div>
                    </td>`
            }
        ],
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        order: [
            [0, 'desc']
        ],
        info: true,
        autoWidth: true,
        lengthMenu: [10, 20, 30, 40, 50],
        scrollX: true
    });
    // load province where region = ''
    $('#region').on('change', function () {
        let region = $(this).val();
        $.ajax({
            url: getProvincesByRegionURL,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                region: region
            },
            success: (response) => {
                let provinceSelect = $('#province');
                provinceSelect.empty();
                provinceSelect.append('<option value="" selected disabled>Choose</option>');
                let citymunicipalitySelect = $('#city_municipality');
                citymunicipalitySelect.empty();
                citymunicipalitySelect.append('<option value="" selected disabled>Choose</option>');
                response.forEach((province) => {
                    provinceSelect.append(`<option value = ${province.prov_code} > ${province.prov_desc} </option>`);
                });
            },
            error: (error) => {
                console.log('Error fetching province: ', error);
            }
        });
    });
    // load city_municipality where province = ''
    $('#province').on('change', function () {
        let province = $(this).val();
        $.ajax({
            url: getCityMunicipalityByProvinceURL,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                province: province
            },
            success: (response) => {
                let citymunicipalitySelect = $('#city_municipality');
                citymunicipalitySelect.empty();
                citymunicipalitySelect.append('<option value="" selected disabled>Choose</option>');
                response.forEach((citymunicipality) => {
                    citymunicipalitySelect.append(`<option value = ${citymunicipality.citymun_code} > ${citymunicipality.citymun_desc} </option>`);
                });
            },
            error: (error) => {
                console.log('Error fetching city/municipality: ', error);
            }
        });
    });
    // add new orientation (inspected agencies)
    $('#formOrientationIA').submit(function (event) {
        event.preventDefault();
        let form = $('#formOrientationIA')[0];
        let formData = new FormData(form);
        let id = formData.get('id');
        // validate first before proceed
        if (this.checkValidity()) {
            // if id is not empty
            if (!id) {
                $.ajax({
                    url: storeOrientationIAURL,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: (s) => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: s.success
                        }).then(() => {
                            tableOrientationIA.ajax.reload();
                            $('#modal-add-new-orientation-ia').modal('hide');
                        });
                    },
                    error: (e) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: e.responseJSON.errors
                        });
                    }
                });
            } else {
                // if id is not empty
                let orientationIAData = {
                    agency_lgu: formData.get('agency_lgu'),
                    date_of_inspection: formData.get('date_of_inspection'),
                    office: formData.get('office'),
                    region: formData.get('region'),
                    province: formData.get('province'),
                    city_municipality: formData.get('city_municipality'),
                    action_plan_and_inspection_report_date_sent_to_cmeo: formData.get('action_plan_and_inspection_report_date_sent_to_cmeo'),
                    feedback_date_sent_to_oddgo: formData.get('feedback_date_sent_to_oddgo'),
                    official_report_date_sent_to_oddgo: formData.get('official_report_date_sent_to_oddgo'),
                    feedback_date_received_from_oddgo: formData.get('feedback_date_received_from_oddgo'),
                    official_report_date_received_from_oddgo: formData.get('official_report_date_received_from_oddgo'),
                    feedback_date_sent_to_agencies_lgus: formData.get('feedback_date_sent_to_agencies_lgus'),
                    official_report_date_sent_to_agencies_lgus: formData.get('official_report_date_sent_to_agencies_lgus'),
                    orientation: formData.get('orientation'),
                    setup: formData.get('setup'),
                    resource_speakers: formData.get('resource_speakers'),
                    bpm_workshop: formData.get('bpm_workshop'),
                    re_engineering: formData.get('re_engineering'),
                    cc_workshop: formData.get('cc_workshop')
                };
                $.ajax({
                    url: `${updateOrientationIAURL}/${id}`,
                    type: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: orientationIAData,
                    dataType: 'JSON',
                    success: (s) => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: s.success
                        }).then(() => {
                            tableOrientationIA.ajax.reload();
                            $('#modal-add-new-orientation-ia').modal('hide');
                        });
                    },
                    error: (e) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: e.responseJSON.errors
                        });
                    }
                });
            }
        }
    });
    // get data for updating
    $(document).on('click', '#btnEdit', function () {
        let row = $(this).closest('tr');
        let data = tableOrientationIA.row(row).data();
        let id = data.id;
        $.ajax({
            url: `${editOrientationIAURL}/${id}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (response) => {
                $('#modal-add-new-orientation-ia').modal('show');
                $('#id').val(response.id);
                $('#agency_lgu').val(response.agency_lgu);
                $('#date_of_inspection').val(response.date_of_inspection);
                $('#office').val(response.office);
                $('#region').val(response.region);
                $('#province').val(response.province);
                $('#city_municipality').val(response.city_municipality);
                $('#action_plan_and_inspection_report_date_sent_to_cmeo').val(response.action_plan_and_inspection_report_date_sent_to_cmeo);
                $('#feedback_date_sent_to_oddgo').val(response.feedback_date_sent_to_oddgo);
                $('#official_report_date_sent_to_oddgo').val(response.official_report_date_sent_to_oddgo);
                $('#feedback_date_received_from_oddgo').val(response.feedback_date_received_from_oddgo);
                $('#official_report_date_received_from_oddgo').val(response.official_report_date_received_from_oddgo);
                $('#feedback_date_sent_to_agencies_lgus').val(response.feedback_date_sent_to_agencies_lgus);
                $('#official_report_date_sent_to_agencies_lgus').val(response.official_report_date_sent_to_agencies_lgus);
                $('#orientation').val(response.orientation);
                $('#setup').val(response.setup);
                $('#resource_speakers').val(response.resource_speakers);
                $('#bpm_workshop').val(response.bpm_workshop);
                $('#re_engineering').val(response.re_engineering);
                $('#cc_workshop').val(response.cc_workshop);
            },
            error: (e) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: e.responseJSON.errors
                });
            }
        });
    });
    // delete data
    $(document).on('click', '#btnDelete', function (e) {
        let row = $(this).closest('tr');
        let data = tableOrientationIA.row(row).data();
        let id = data.id;
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to revert this.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${editOrientationIAURL}/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (s) => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: s.success
                        }).then(() => {
                            tableOrientationIA.ajax.reload();
                        });
                    },
                    error: (e) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: e.responseJSON.errors
                        });
                    }
                });
            }
        });
    });
    // check validation
    $(document).ready(() => {
        let form = $(".needs-validation");
        form.each(function () {
            $(this).on('submit', function (event) {
                if (this.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                $(this).addClass('was-validated');
            });
        });
    });
    // clear form fields after event
    function clearForm() {
        $('#id').val('');
        $('#agency_lgu').val('');
        $('#date_of_inspection').val('mm/dd/yyy/');
        $('#office').val('');
        $('#region').val('Choose');
        $('#province').val('Choose');
        $('#city_municipality').val('Choose');
        $('#action_plan_and_inspection_report_date_sent_to_cmeo').val('mm/dd/yyy/');
        $('#feedback_date_sent_to_oddgo').val('mm/dd/yyy/');
        $('#official_report_date_sent_to_oddgo').val('mm/dd/yyy/');
        $('#feedback_date_received_from_oddgo').val('mm/dd/yyy/');
        $('#official_report_date_received_from_oddgo').val('mm/dd/yyy/');
        $('#feedback_date_sent_to_agencies_lgus').val('mm/dd/yyy/');
        $('#official_report_date_sent_to_agencies_lgus').val('mm/dd/yyy/');
        $('#orientation').val('');
        $('#setup').val('');
        $('#resource_speakers').val('');
        $('#bpm_workshop').val('');
        $('#re_engineering').val('');
        $('#cc_workshop').val('');
    }
    $('#modal-add-new-orientation-ia').on('hidden.bs.modal', (e) => {
        clearForm();
    });
});