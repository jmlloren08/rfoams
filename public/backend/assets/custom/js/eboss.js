'use strict';
// load eboss
$(function () {
    let tableeBOSS = $("#dataTableeBOSS").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: getDataFromeBOSSURL,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        columns: [
            { data: 'id', visible: false },
            { data: 'date_of_inspection' },
            { data: 'citymunDesc' },
            { data: 'provDesc' },
            { data: 'regDesc' },
            {
                data: 'eboss_submission',
                render: function (data) {
                    if (data === 'No submission') {
                        return '<span class="badge bg-danger">' + data + '</span>';
                    } else {
                        return '<span class="badge bg-success">' + data + '</span>';
                    }
                }
            },
            {
                data: 'type_of_boss',
                render: function (data) {
                    if (data === 'Fully-Automated') {
                        return '<span class="badge bg-primary">' + data + '</span>';
                    } else {
                        return data;
                    }
                }
            },
            {
                data: 'deadline_of_action_plan',
                render: function (data) {
                    if (data === 'Not applicable') {
                        return '<span class="badge bg-warning">' + data + '</span>';
                    } else {
                        return '<span class="badge bg-success">' + data + '</span>';
                    }
                }
            },
            {
                data: null,
                render: function (data) {
                    const submissionDate = new Date(data.submission_of_action_plan);
                    const deadlineDate = new Date(data.deadline_of_action_plan);
                    if (data.submission_of_action_plan === 'Not applicable') {
                        return '<span class="badge bg-warning">' + data.submission_of_action_plan + '</span>';
                    } else if (submissionDate <= deadlineDate) {
                        return '<span class="badge bg-success">' + data.submission_of_action_plan + '</span>';
                    } else {
                        return '<span class="badge bg-danger">' + data.submission_of_action_plan + '</span>';
                    }
                }
            },
            { data: 'remarks' },
            { data: 'bplo_head' },
            { data: 'contact_no' },
            {
                data: '',
                defaultContent: `<td class="text-right py-0 align-middle">
                    <div class="btn-group btn-group-sm">
                    <a class="btn btn-info" id="btnEdit" title="Edit eBOSS"><i class="fas fa-edit"></i></a>
                    <a class="btn btn-danger" id="btnDelete" title="Delete eBOSS"><i class="fas fa-times-circle"></i></a>
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
                console.log('Error fetching province: ', error);
            }
        });
    });
    // load city_municipality where province = ''
    $('#province').on('change', function () {
        let province = $(this).val();
        $.ajax({
            url: getCityMuncipalityByProvinceURL,
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
                console.log('Error fetching city/municipality: ', error);
            }
        });
    });
    // add new rfo
    $("#formeBOSS").submit(function (event) {
        event.preventDefault();
        let form = $("#formeBOSS")[0];
        let formData = new FormData(form);
        let id = formData.get('id');
        // convert checkbox values to boolean
        formData.set('no_submission', $('#no_submission').is(':checked'));
        formData.set('not_applicable_doap', $('#not_applicable_doap').is(':checked'));
        formData.set('not_applicable_soap', $('#not_applicable_soap').is(':checked'));
        // check if eboss_submission is date or no submission
        if ($('#no_submission').is(':checked')) {
            formData.set('eboss_submission', 'No submission');
        } else {
            formData.set('eboss_submission', formData.get('eboss_submission'));
        }
        // check if deadline is date or not applicable
        if ($('#not_applicable_doap').is(':checked')) {
            formData.set('deadline_of_action_plan', 'Not applicable');
        } else {
            formData.set('deadline_of_action_plan', formData.get('deadline_of_action_plan'));
        }
        // check if submission is date or not applicabler
        if ($('#not_applicable_doap').is(':checked')) {
            formData.set('submission_of_action_plan', 'Not applicable');
        } else {
            formData.set('submission_of_action_plan', formData.get('submission_of_action_plan'));
        }
        // for (var pair of formData.entries()) {
        //     console.log(pair[0]+ ': ' + pair[1]);
        // }
        // add
        if (this.checkValidity()) {
            if (!id) {
                $.ajax({
                    url: storeeBOSSURL,
                    type: "POST",
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
                            tableeBOSS.ajax.reload(); //reload datatable
                            $("#modal-add-new-eboss").modal('hide'); //hide modal
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
                // update
            } else {
                let ebossData = {
                    date_of_inspection: formData.get('date_of_inspection'),
                    region: formData.get('region'),
                    province: formData.get('province'),
                    city_municipality: formData.get('city_municipality'),
                    eboss_submission: formData.get('eboss_submission'),
                    no_submission: $('#no_submission').is(':checked'),
                    type_of_boss: formData.get('type_of_boss'),
                    deadline_of_action_plan: formData.get('deadline_of_action_plan'),
                    not_applicable_doap: $('#not_applicable_doap').is(':checked'),
                    submission_of_action_plan: formData.get('submission_of_action_plan'),
                    not_applicable_soap: $('#not_applicable_soap').is(':checked'),
                    remarks: formData.get('remarks'),
                    bplo_head: formData.get('bplo_head'),
                    contact_no: formData.get('contact_no')
                };
                $.ajax({
                    url: `${updateeBOSSURL}/${id}`,
                    type: "PUT",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: ebossData,
                    dataType: 'JSON',
                    success: function (s) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: s.success
                        }).then(() => {
                            tableeBOSS.ajax.reload(); //reload datatable
                            $("#modal-add-new-eboss").modal('hide'); //hide modal
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
    }); //end of adding/updating eboss
    // check validation
    $(document).ready(function () {
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
    // clear form after event
    function clearForm() {
        $("#id").val("");
        $("#date_of_inspection").val("mm/dd/yyyy");
        $("#region").val("Choose");
        $("#province").val("Choose");
        $("#city_municipality").val("Choose");
        $("#eboss_submission").val("mm/dd/yyyy");
        $("#type_of_boss").val("Choose");
        $("#deadline_of_action_plan").val("mm/dd/yyyy");
        $("#submission_of_action_plan").val("mm/dd/yyyy");
        $("#remarks").val("");
        $("#bplo_head").val("");
        $("#contact_no").val("");
        $("#no_submission").prop('checked', false);
        $('#eboss_submission').prop('disabled', false);
        $('#deadline_of_action_plan').prop('disabled', false)
        $("#not_applicable_doap").prop('checked', false);
        $('#submission_of_action_plan').prop('disabled', false);
        $("#not_applicable_soap").prop('checked', false);
    }
    // function if modal hide
    $("#modal-add-new-eboss").on('hidden.bs.modal', function (e) {
        clearForm();
    }); //end function
});