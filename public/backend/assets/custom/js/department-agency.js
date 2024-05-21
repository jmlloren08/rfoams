'use strict';
$(document).ready(function () {
    setTimeout(function () {
        // load departments/agencies
        $(function () {
            let tableDepartmentAgency = $("#dataTableDepartmentAgency").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: getDataFromDepartmentAgencyURL,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                    data: 'id',
                },
                {
                    data: 'department_agencies',
                },
                {
                    data: 'address',
                },
                {
                    data: 'contact_number',
                },
                {
                    data: '',
                    defaultContent: `<td class="text-right py-0 align-middle">
                    <div class="btn-group btn-group-sm">
                    <a class="btn btn-info" id="btnEdit" title="Edit department/agency"><i class="fas fa-edit"></i></a>
                    <a class="btn btn-danger" id="btnDelete" title="Delete department/agency"><i class="fas fa-times-circle"></i></a>
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
        });
    }, 1000);
});