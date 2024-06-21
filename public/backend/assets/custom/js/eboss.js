$(function () {
    'use strict'
    $('#no_submission').on('change', function () {
        if ($(this).is(':checked')) {
            $('#eboss_submission').val('');
            $('#eboss_submission').prop('disabled', true);
        } else {
            $('#eboss_submission').prop('disabled', false);
        }
    });
    $('#not_applicable_doap').on('change', function () {
        if ($(this).is(':checked')) {
            $('#deadline_of_action_plan').val('');
            $('#deadline_of_action_plan').prop('disabled', true);
        } else {
            $('#deadline_of_action_plan').prop('disabled', false);
        }
    });
    $('#not_applicable_soap').on('change', function () {
        if ($(this).is(':checked')) {
            $('#submission_of_action_plan').val('');
            $('#submission_of_action_plan').prop('disabled', true);
        } else {
            $('#submission_of_action_plan').prop('disabled', false);
        }
    });
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
                        return `<span class="badge bg-danger"> ${data} </span>`;
                    } else {
                        return `<span class="badge bg-success"> ${data} </span>`;
                    }
                }
            },
            {
                data: 'type_of_boss',
                render: function (data) {
                    if (data === 'Fully-Automated') {
                        return `<span class="badge bg-primary"> ${data} </span>`;
                    } else if (data === 'Partly-Automated') {
                        return `<span class="badge bg-info"> ${data} </span>`;
                    } else if (data === 'Physical/Collocated BOSS') {
                        return `<span class="badge bg-warning"> ${data} </span>`;
                    } else {
                        return `<span class="badge bg-danger"> ${data} </span>`;
                    }
                }
            },
            {
                data: 'deadline_of_action_plan',
                render: function (data) {
                    if (data === 'Not applicable') {
                        return `<span class="badge bg-warning"> ${data} </span>`;
                    } else {
                        return `<span class="badge bg-success"> ${data} </span>`;
                    }
                }
            },
            {
                data: null,
                render: function (data) {
                    const submissionDate = new Date(data.submission_of_action_plan);
                    const deadlineDate = new Date(data.deadline_of_action_plan);
                    if (data.submission_of_action_plan === 'Not applicable') {
                        return `'<span class="badge bg-warning"> ${data.submission_of_action_plan} </span>`;
                    } else if (submissionDate <= deadlineDate) {
                        return `<span class="badge bg-success"> ${data.submission_of_action_plan} </span>`;
                    } else {
                        return `<span class="badge bg-danger"> ${data.submission_of_action_plan} </span>`;
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
        // check if submission is date or not applicable
        if ($('#not_applicable_doap').is(':checked')) {
            formData.set('submission_of_action_plan', 'Not applicable');
        } else {
            formData.set('submission_of_action_plan', formData.get('submission_of_action_plan'));
        }
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
    // get data
    $(document).on("click", "#btnEdit", function (e) {
        let row = $(this).closest("tr");
        let data = tableeBOSS.row(row).data();
        let id = data.id;
        $.ajax({
            url: `${editeBOSSURL}/${id}`,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $("#modal-add-new-eboss").modal("show");
                $("#id").val(response.id);
                $("#date_of_inspection").val(response.date_of_inspection);
                $("#region").val(response.region);
                $("#province").val(response.province);
                $("#city_municipality").val(response.city_municipality);
                $("#eboss_submission").val(response.eboss_submission);
                $("#type_of_boss").val(response.type_of_boss);
                $("#deadline_of_action_plan").val(response.deadline_of_action_plan);
                $("#submission_of_action_plan").val(response.submission_of_action_plan);
                $("#remarks").val(response.remarks);
                $("#bplo_head").val(response.bplo_head);
                $("#contact_no").val(response.contact_no);
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
    $(document).on("click", "#btnDelete", function (e) {
        let row = $(this).closest("tr");
        let data = tableeBOSS.row(row).data();
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
                    url: `${editeBOSSURL}/${id}`,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (s) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: s.success
                        }).then(() => {
                            tableeBOSS.ajax.reload();
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
// chart
$(document).ready(function () {
    setTimeout(function () {
        // fully-automated
        $(function () {
            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }
            var mode = 'index'
            var intersect = true
            var colors = [];
            $('.fa-square').each(function () {
                colors.push($(this).data('color'));
            });
            var chartLabels = ['Fully-Automated'];
            var chartDataSets = [
                {
                    label: '2023',
                    backgroundColor: colors[0],
                    borderColor: colors[0],
                    data: [fullyAutomated2023]
                },
                {
                    label: '2024',
                    backgroundColor: colors[1],
                    borderColor: colors[1],
                    data: [fullyAutomated2024]
                }
            ];
            var $faChart = $('#fa-chart')
            var faChart = new Chart($faChart, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: chartDataSets
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: $.extend({
                                beginAtZero: true
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: true
                            },
                            ticks: ticksStyle
                        }]
                    }
                }
            });
        });
        // partly-automated
        $(function () {
            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }
            var mode = 'index'
            var intersect = true
            var colors = [];
            $('.fa-square').each(function () {
                colors.push($(this).data('color'));
            });
            var chartLabels = ['Partly-Automated'];
            var chartDataSets = [
                {
                    label: '2023',
                    backgroundColor: colors[0],
                    borderColor: colors[0],
                    data: [partlyAutomated2023]
                },
                {
                    label: '2024',
                    backgroundColor: colors[1],
                    borderColor: colors[1],
                    data: [partlyAutomated2024]
                }
            ];
            var $paChart = $('#pa-chart')
            var paChart = new Chart($paChart, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: chartDataSets
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: $.extend({
                                beginAtZero: true
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: true
                            },
                            ticks: ticksStyle
                        }]
                    }
                }
            });
        });
        // physical-collocated
        $(function () {
            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }
            var mode = 'index'
            var intersect = true
            var colors = [];
            $('.fa-square').each(function () {
                colors.push($(this).data('color'));
            });
            var chartLabels = ['Physical/Collocated BOSS'];
            var chartDataSets = [
                {
                    label: '2023',
                    backgroundColor: colors[0],
                    borderColor: colors[0],
                    data: [physicalCollocated2023]
                },
                {
                    label: '2024',
                    backgroundColor: colors[1],
                    borderColor: colors[1],
                    data: [physicalCollocated2024]
                }
            ];
            var $pcChart = $('#pc-chart')
            var pcChart = new Chart($pcChart, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: chartDataSets
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: $.extend({
                                beginAtZero: true
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: true
                            },
                            ticks: ticksStyle
                        }]
                    }
                }
            });
        });
        // no-collocated
        $(function () {
            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }
            var mode = 'index'
            var intersect = true
            var colors = [];
            $('.fa-square').each(function () {
                colors.push($(this).data('color'));
            });
            var chartLabels = ['No Collocated BOSS'];
            var chartDataSets = [
                {
                    label: '2023',
                    backgroundColor: colors[0],
                    borderColor: colors[0],
                    data: [noCollocatedBOSS2023]
                },
                {
                    label: '2024',
                    backgroundColor: colors[1],
                    borderColor: colors[1],
                    data: [noCollocatedBOSS2024]
                }
            ];
            var $ncChart = $('#nc-chart')
            var ncChart = new Chart($ncChart, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: chartDataSets
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: $.extend({
                                beginAtZero: true
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: true
                            },
                            ticks: ticksStyle
                        }]
                    }
                }
            });
        });
    }, 500);
});