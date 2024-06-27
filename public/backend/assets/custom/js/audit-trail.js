$(function () {
    'use strict'
    let tableAuditLogs = $('#dataTableAuditLogs').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: getDataFromAuditLogsURL,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        columns: [
            { data: 'id' },
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
            { data: 'name' },
            { data: 'event' },
            { data: 'ip_address' },
            { data: 'location' }
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
});