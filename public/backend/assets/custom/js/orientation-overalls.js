$(() => {
    'use strict'
    let tableOrientationOverall = $('#dataTableOrientationOverall').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: getDataFromOrientationOverallURL,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        columns: [
            { data: 'id', visible: false },
            { data: 'orientation_date' },
            { data: 'agency_lgu' },
            { data: 'office' },
            { data: 'citymunDesc' },
            { data: 'provDesc' },
            { data: 'regDesc' },
            { data: 'is_ra_11032' },
            { data: 'is_cart' },
            { data: 'is_programs_and_services' },
            { data: 'is_cc_orientation' },
            { data: 'is_cc_workshop' },
            { data: 'is_bpm_workshop' },
            { data: 'is_ria' },
            { data: 'is_eboss' },
            { data: 'is_csm' },
            { data: 'is_reeng' },
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
        createdRow: function (row, data, dataIndex) {
            function setCellClass(cell, value) {
                if (value === 'Yes') {
                    $(cell).addClass('bg-success', 'text-white');
                } else {
                    $(cell).addClass('bg-danger', 'text-white');
                }
            }
            setCellClass($('td', row).eq(6), data.is_ra_11032);
            setCellClass($('td', row).eq(7), data.is_cart);
            setCellClass($('td', row).eq(8), data.is_programs_and_services);
            setCellClass($('td', row).eq(9), data.is_cc_orientation);
            setCellClass($('td', row).eq(10), data.is_cc_workshop);
            setCellClass($('td', row).eq(11), data.is_bpm_workshop);
            setCellClass($('td', row).eq(12), data.is_ria);
            setCellClass($('td', row).eq(13), data.is_eboss);
            setCellClass($('td', row).eq(14), data.is_csm);
            setCellClass($('td', row).eq(15), data.is_reeng);
        },
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
                    provinceSelect.append(`<option value = ${province.provCode} > ${province.provDesc} </option>`);
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
                    citymunicipalitySelect.append(`<option value = ${citymunicipality.citymunCode} > ${citymunicipality.citymunDesc} </option>`);
                });
            },
            error: (error) => {
                console.log('Error fetching city/municipality: ', error);
            }
        });
    });
    // add new orientation (overall)
    $('#formOrientationOverall').submit(function (event) {
        event.preventDefault();
        let form = $('#formOrientationOverall')[0];
        let formData = new FormData(form);
        let id = formData.get('id');
        // validate first before proceed
        if (this.checkValidity()) {
            // if id is empty then store
            if (!id) {
                $.ajax({
                    url: storeOrientationOverallURL,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: (s) => {
                        Swal.fire({
                            icon: 'success', title: 'Success', text: s.success
                        }).then(() => {
                            tableOrientationOverall.ajax.reload();
                            $('#modal-add-new-orientation-overalls').modal('hide');
                        });
                    },
                    error: (e) => {
                        Swal.fire({ icon: 'error', title: 'Error', text: e.responseJSON.errors });
                    }
                });
            } else {
                // if id is not empty then update
                let orientationOverallData = {
                    orientation_date: formData.get('orientation_date'),
                    agency_lgu: formData.get('agency_lgu'),
                    office: formData.get('office'),
                    region: formData.get('region'),
                    province: formData.get('province'),
                    city_municipality: formData.get('city_municipality'),
                    is_ra_11032: formData.get('is_ra_11032'),
                    is_cart: formData.get('is_cart'),
                    is_programs_and_services: formData.get('is_programs_and_services'),
                    is_cc_orientation: formData.get('is_cc_orientation'),
                    is_cc_workshop: formData.get('is_cc_workshop'),
                    is_bpm_workshop: formData.get('is_bpm_workshop'),
                    is_ria: formData.get('is_ria'),
                    is_eboss: formData.get('is_eboss'),
                    is_csm: formData.get('is_csm'),
                    is_reeng: formData.get('is_reeng')
                };
                $.ajax({
                    url: `${updateOrientationOverallURL}/${id}`,
                    type: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: orientationOverallData,
                    dataType: 'JSON',
                    success: (s) => {
                        Swal.fire({
                            icon: 'success', title: 'Success', text: s.success
                        }).then(() => {
                            tableOrientationOverall.ajax.reload();
                            $('#modal-add-new-orientation-overalls').modal('hide');
                        });
                    },
                    error: (e) => {
                        Swal.fire({ icon: 'error', title: 'Error', text: e.responseJSON.errors });
                    }
                });
            }
        }
    });
    // get data for updating
    $(document).on('click', '#btnEdit', function () {
        let row = $(this).closest('tr');
        let data = tableOrientationOverall.row(row).data();
        let id = data.id;
        $.ajax({
            url: `${editOrientationOverallURL}/${id}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (response) => {
                $('#modal-add-new-orientation-overalls').modal('show');
                $('#id').val(response.id);
                $('#orientation_date').val(response.orientation_date);
                $('#agency_lgu').val(response.agency_lgu);
                $('#office').val(response.office);
                $('#region').val(response.region);
                $('#province').val(response.province);
                $('#city_municipality').val(response.city_municipality);
                $('#is_ra_11032').val(response.is_ra_11032);
                $('#is_cart').val(response.is_cart);
                $('#is_programs_and_services').val(response.is_programs_and_services);
                $('#is_cc_orientation').val(response.is_cc_orientation);
                $('#is_cc_workshop').val(response.is_cc_workshop);
                $('#is_bpm_workshop').val(response.is_bpm_workshop);
                $('#is_ria').val(response.is_ria);
                $('#is_eboss').val(response.is_eboss);
                $('#is_csm').val(response.is_csm);
                $('#is_reeng').val(response.is_reeng);
            },
            error: (e) => {
                Swal.fire({ icon: 'error', title: 'Error', text: e.responseJSON.errors });
            }
        });
    });
    // delete data
    $(document).on('click', '#btnDelete', function (e) {
        let row = $(this).closest('tr');
        let data = tableOrientationOverall.row(row).data();
        let id = data.id;
        Swal.fire({
            title: 'Are you sure?', text: 'You will not be able to revert this.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${editOrientationOverallURL}/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (s) => {
                        Swal.fire({
                            icon: 'success', title: 'Success', text: s.success
                        }).then(() => {
                            tableOrientationOverall.ajax.reload();
                        });
                    },
                    error: (e) => {
                        Swal.fire({ icon: 'error', title: 'Error', text: e.responseJSON.errors });
                    }
                });
            }
        });
    });
    // check validation form
    $(document).ready(() => {
        let form = $('.needs-validation');
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
        $('#orientation_date').val('');
        $('#agency_lgu').val('');
        $('#office').val('');
        $('#region').val('Choose');
        $('#province').val('Choose');
        $('#city_municipality').val('Choose');
        $('#is_ra_11032').val('Choose');
        $('#is_cart').val('Choose');
        $('#is_programs_and_services').val('Choose');
        $('#is_cc_orientation').val('Choose');
        $('#is_cc_workshop').val('Choose');
        $('#is_bpm_workshop').val('Choose');
        $('#is_ria').val('Choose');
        $('#is_eboss').val('Choose');
        $('#is_csm').val('Choose');
        $('#is_reeng').val('Choose');
    }
    $('#modal-add-new-orientation-overalls').on('hidden.bs.modal', (e) => {
        clearForm();
    });
});