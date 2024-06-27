// load RFOs
$(function () {
    'use strict'
    let tableUsers = $("#dataTableUsers").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: getDataFromUsersURL,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        columns: [
            { data: 'id', visible: false },
            { data: 'name' },
            { data: 'email' },
            {
                data: 'email_verified_at',
                render: function (data) {
                    if (!data || data === '' || data === null) {
                        return `<span class="badge bg-danger">Unverified</span>`;
                    } else {
                        return `<span class="badge bg-success">Verified</span>`;
                    }
                }
            },
            {
                data: 'roles',
                render: function (data) {
                    if (data === 'Administrator') {
                        return `<span class="badge bg-success"> ${data} </span>`;
                    } else if (data === 'User') {
                        return `<span class="badge bg-primary"> ${data} </span>`;
                    } else {
                        return `<span class="badge bg-danger"> ${data} </span>`;
                    }
                }
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
                data: 'roles',
                render: function (data) {
                    if (!data || data === 'Guest' || data === null) {
                        return `<td class="text-right py-0 align-middle">
                        <div class="btn-group btn-group-sm">
                        <a class="btn btn-info" id="btnAssign" title="Assign role"><i class="fas fa-user-check"></i></a>
                        <a class="btn btn-danger" id="btnDelete" title="Delete user"><i class="fas fa-user-slash"></i></a>
                        </div>
                        </td>`
                    } else {
                        return `<td class="text-right py-0 align-middle">
                        <div class="btn-group btn-group-sm">
                        <a class="btn btn-warning" id="btnRemove" title="Remove role"><i class="fas fa-user-times"></i></a>
                        <a class="btn btn-danger" id="btnDelete" title="Delete user"><i class="fas fa-user-slash"></i></a>
                        </div>
                        </td>`
                    }
                }
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
    // get data
    $(document).on("click", "#btnAssign", function (e) {
        let row = $(this).closest("tr");
        let data = tableUsers.row(row).data();
        let id = data.id;
        $.ajax({
            url: `${editUsersURL}/${id}`,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $("#modal-edit-users").modal("show");
                $("#id").val(response.id);
                $("#name").val(response.name);
                $("#email").val(response.email);
                $("#roles").val(response.roles);
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
    // update role
    $("#formUser").submit(function (event) {
        event.preventDefault();
        let form = $("#formUser")[0];
        let formData = new FormData(form);
        let id = formData.get('id');
        if (this.checkValidity()) {
            if (id) {
                let roles = { roles: formData.get('roles') };
                $.ajax({
                    url: `${updateUsersURL}/${id}`,
                    type: "PUT",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: roles,
                    dataType: 'JSON',
                    success: function (s) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'User role was successfully assigned.'
                        }).then(() => {
                            tableUsers.ajax.reload();
                            $("#modal-edit-users").modal('hide');
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
    // remove role
    $(document).on("click", "#btnRemove", function (e) {
        let row = $(this).closest("tr");
        let data = tableUsers.row(row).data();
        let id = data.id;
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to revert this.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let roles = null;
                $.ajax({
                    url: `${removeUserURL}/${id}`,
                    type: "PUT",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: roles,
                    dataType: 'JSON',
                    success: function (s) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: s.removed
                        }).then(() => {
                            tableUsers.ajax.reload();
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
    // delete data
    $(document).on("click", "#btnDelete", function (e) {
        let row = $(this).closest("tr");
        let data = tableUsers.row(row).data();
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
                    url: `${deleteUserURL}/${id}`,
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
                            tableUsers.ajax.reload();
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
        $("#name").val("");
        $("#email").val("");
        $("#role").val("");
    }
    // function if modal hide
    $("#modal-edit-users").on('hidden.bs.modal', function (e) {
        clearForm();
    }); //end function
});