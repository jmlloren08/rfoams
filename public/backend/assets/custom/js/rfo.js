'use strict';
// load RFOs
$(function () {
    let tableRFOs = $("#dataTableRFOs").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: getDataFromRFOsURL,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        columns: [{
            data: 'id', visible: false
        },
        {
            data: 'rfo',
        },
        {
            data: 'focal_person',
        },
        {
            data: 'position',
        },
        {
            data: 'contact_number',
        },
        {
            data: 'email_address',
        },
        {
            data: 'created_at',
            render: function (data) {
                return moment(data).format('YYYY-MM-DD HH:mm:ss');
            }
        },
        {
            data: 'updated_at',
            render: function (data) {
                return moment(data).format('YYYY-MM-DD HH:mm:ss');
            }
        },
        {
            data: '',
            defaultContent: `<td class="text-right py-0 align-middle">
                    <div class="btn-group btn-group-sm">
                    <a class="btn btn-info" id="btnEdit" title="Edit RFO"><i class="fas fa-edit"></i></a>
                    <a class="btn btn-danger" id="btnDelete" title="Delete RFO"><i class="fas fa-times-circle"></i></a>
                    </div>
                    </td>`
        }
        ],
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: true,
        lengthMenu: [10, 20, 30, 40, 50],
        scrollX: true
    });
    // add new rfo
    $("#formRFO").submit(function (event) {
        event.preventDefault();
        let form = $("#formRFO")[0];
        let formData = new FormData(form);
        let id = formData.get('id');
        if (this.checkValidity()) {
            if (!id) {
                $.ajax({
                    url: storeRFOsURL,
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
                            tableRFOs.ajax.reload(); //reload datatable
                            $("#modal-add-new-rfo").modal('hide'); //hide modal
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
                let rfoData = {
                    rfo: formData.get('rfo'),
                    focal_person: formData.get('focal_person'),
                    position: formData.get('position'),
                    contact_number: formData.get('contact_number'),
                    email_address: formData.get('email_address')
                };
                $.ajax({
                    url: `${updateRFOsURL}/${id}`,
                    type: "PUT",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: rfoData,
                    dataType: 'JSON',
                    success: function (s) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: s.success
                        }).then(() => {
                            tableRFOs.ajax.reload(); //reload datatable
                            $("#modal-add-new-rfo").modal('hide'); //hide modal
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
    }); //end of adding/updating product
    // get data
    $(document).on("click", "#btnEdit", function (e) {
        let row = $(this).closest("tr");
        let data = tableRFOs.row(row).data();
        let id = data.id;
        $.ajax({
            url: `${editRFOsURL}/${id}`,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $("#modal-add-new-rfo").modal("show");
                $("#id").val(response.id);
                $("#rfo").val(response.rfo);
                $("#focal_person").val(response.focal_person);
                $("#position").val(response.position);
                $("#contact_number").val(response.contact_number);
                $("#email_address").val(response.email_address);
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
    // delete product
    $(document).on("click", "#btnDelete", function (e) {
        let row = $(this).closest("tr");
        let data = tableRFOs.row(row).data();
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
                    url: `${editRFOsURL}/${id}`,
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
                            tableRFOs.ajax.reload();
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
        $("#rfo").val("");
        $("#focal_person").val("");
        $("#position").val("");
        $("#contact_number").val("");
        $("#email_address").val("");
    }
    // function if modal hide
    $("#modal-add-new-rfo").on('hidden.bs.modal', function (e) {
        clearForm();
    }); //end function
});
