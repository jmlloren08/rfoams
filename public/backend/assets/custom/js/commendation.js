$(function () {
    'use strict'
    let tableCommendation = $('#dataTableCommendation').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: getDataFromCommendationURL,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        columns: [
            { data: 'id', visible: false },
            { data: 'date_of_commendation' },
            { data: 'citymunDesc' },
            { data: 'provDesc' },
            { data: 'regDesc' },
            { data: 'date_of_inspection' },
            { data: 'service_provider' },
            { data: 'first_validation' },
            { data: 'remarks_1' },
            { data: 'second_validation' },
            { data: 'remarks_2' },
            { data: 'other_activity' },
            { data: 'number_of_brgys' },
            {
                data: '',
                defaultContent: `<td class="text-right py-0 align-middle">
                    <div class="btn-group btn-group-sm">
                    <a class="btn btn-info" id="btnEdit" title="Edit Commendation"><i class="fas fa-edit"></i></a>
                    <a class="btn btn-danger" id="btnDelete" title="Delete Commendation"><i class="fas fa-times-circle"></i></a>
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
            success: function (response) {
                let provinceSelect = $('#province');
                let citymunicipalitySelect = $('#city_municipality');
                citymunicipalitySelect.empty();
                citymunicipalitySelect.append('<option value="" selected disabled>Choose</option>');
                provinceSelect.empty();
                provinceSelect.append('<option value="" selected disabled>Choose</option>');
                response.forEach(function (province) {
                    provinceSelect.append(`<option value = ${province.provCode} > ${province.provDesc} </option>`);
                });
            },
            error: function (error) {
                console.log(`Error fetching province: ${error}`);
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
            success: function (response) {
                let citymunicipalitySelect = $('#city_municipality');
                citymunicipalitySelect.empty();
                citymunicipalitySelect.append('<option value="" selected disabled>Choose</option>');
                response.forEach(function (citymunicipality) {
                    citymunicipalitySelect.append(`<option value = ${citymunicipality.citymunCode} > ${citymunicipality.citymunDesc} </option>`);
                });
            },
            error: function (error) {
                console.log(`Error fetching city/municipality: ${error}`);
            }
        });
    });
    // add new commendation
    $('#formCommendation').submit(function (event) {
        event.preventDefault();
        let form = $('#formCommendation')[0];
        let formData = new FormData(form);
        let id = formData.get('id');
        // for add
        // check first before proceed
        if (this.checkValidity()) {
            // check if id has value
            if (!id) {
                $.ajax({
                    url: storeCommendationURL,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (s) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: s.success
                        }).then(() => {
                            tableCommendation.ajax.reload();
                            $('#modal-add-new-commendation').modal('hide');
                        });
                    },
                    error: function (e) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: e.responseJSON.errors
                        });
                    }
                });
            } else {
                let commendationData = {
                    date_of_commendation: formData.get('date_of_commendation'),
                    region: formData.get('region'),
                    province: formData.get('province'),
                    city_municipality: formData.get('city_municipality'),
                    date_of_inspection: formData.get('date_of_inspection'),
                    service_provider: formData.get('service_provider'),
                    first_validation: formData.get('first_validation'),
                    remarks_1: formData.get('remarks_1'),
                    second_validation: formData.get('second_validation'),
                    remarks_2: formData.get('remarks_2'),
                    other_activity: formData.get('other_activity'),
                    number_of_brgys: formData.get('number_of_brgys')
                };
                // if id has value then update
                $.ajax({
                    url: `${updateCommendationURL}/${id}`,
                    type: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: commendationData,
                    dataType: 'JSON',
                    success: function (s) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: s.success
                        }).then(() => {
                            tableCommendation.ajax.reload();
                            $('#modal-add-new-commendation').modal('hide');
                        });
                    },
                    error: function (e) {
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
    // get data
    $(document).on('click', '#btnEdit', function (e) {
        let row = $(this).closest('tr');
        let data = tableCommendation.row(row).data();
        let id = data.id;
        $.ajax({
            url: `${editCommendationURL}/${id}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#modal-add-new-commendation').modal('show');
                $('#id').val(response.id);
                $('#date_of_commendation').val(response.date_of_commendation);
                $("#region").val(response.region);
                $("#province").val(response.province);
                $("#city_municipality").val(response.city_municipality);
                $('#service_provider').val(response.service_provider);
                $('#first_validation').val(response.first_validation);
                $('#remarks_1').val(response.remarks_1);
                $('#second_validation').val(response.second_validation);
                $('#remarks_2').val(response.remarks_2);
                $('#other_activity').val(response.other_activity);
                $('#number_of_brgys').val(response.number_of_brgys);
            },
            error: function (e) {
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
        let data = tableCommendation.row(row).data();
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
                    url: `${editCommendationURL}/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (s) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: s.success
                        }).then(() => {
                            tableCommendation.ajax.reload();
                        });
                    },
                    error: function (e) {
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
    $(document).ready(function () {
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
    // clear form after event
    function clearForm() {
        $('#id').val('');
        $('#date_of_commendation').val('mm/dd/yyy/');
        $('#region').val('Choose');
        $('#province').val('Choose');
        $('#city_municipality').val('Choose');
        $('#date_of_inspection').val('mm/dd/yyyy');
        $('#service_provider').val('');
        $('#first_validation').val('');
        $('#remarks_1').val('');
        $('#second_validation').val('');
        $('#remarks_2').val('');
        $('#other_activity').val('');
        $('#number_of_brgys').val('');
    }
    $('#modal-add-new-commendation').on('hidden.bs.modal', function (e) {
        clearForm();
    });
});