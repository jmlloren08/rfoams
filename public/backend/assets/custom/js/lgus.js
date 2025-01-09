$(document).ready(function () {
    setTimeout(function () {
        'use strict'
        $(function () {
            let tableRegion = $("#dataTableRefRegion").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: getDataFromRefRegionURL,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: 'id', visible: false },
                    { data: 'psgc_code' },
                    { data: 'reg_desc' },
                    { data: 'reg_code' },
                    {
                        data: '',
                        defaultContent: `<td class="text-right py-0 align-middle">
                    <div class="btn-group btn-group-sm">
                    <a class="btn btn-info" id="btnEdit" title="Edit region"><i class="fas fa-edit"></i></a>
                    <a class="btn btn-danger" id="btnDelete" title="Delete region"><i class="fas fa-times-circle"></i></a>
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
        // load provinces
        $(function () {
            let tableProvince = $("#dataTableRefProvince").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: getDataFromRefProvinceURL,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: 'id', visible: false },
                    { data: 'psgc_code' },
                    { data: 'prov_desc' },
                    { data: 'reg_code' },
                    { data: 'prov_code' },
                    {
                        data: '',
                        defaultContent: `<td class="text-right py-0 align-middle">
                    <div class="btn-group btn-group-sm">
                    <a class="btn btn-info" id="btnEdit" title="Edit province"><i class="fas fa-edit"></i></a>
                    <a class="btn btn-danger" id="btnDelete" title="Delete province"><i class="fas fa-times-circle"></i></a>
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
        // load cities/municipalities
        $(function () {
            let tableCityMun = $("#dataTableRefCityMun").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: getDataFromRefCityMunURL,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: 'id', visible: false },
                    { data: 'psgc_code' },
                    { data: 'citymun_desc' },
                    { data: 'reg_code' },
                    { data: 'prov_code' },
                    { data: 'citymun_code' },
                    {
                        data: '',
                        defaultContent: `<td class="text-right py-0 align-middle">
                    <div class="btn-group btn-group-sm">
                    <a class="btn btn-info" id="btnEdit" title="Edit city/municipality"><i class="fas fa-edit"></i></a>
                    <a class="btn btn-danger" id="btnDelete" title="Delete city/municipality"><i class="fas fa-times-circle"></i></a>
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
        // load barangays
        $(function () {
            let tableBarangay = $("#dataTableRefBarangay").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: getDataFromRefBarangayURL,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: 'id', visible: false },
                    { data: 'brgy_code' },
                    { data: 'brgy_desc' },
                    { data: 'reg_code' },
                    { data: 'prov_code' },
                    { data: 'citymun_code' },
                    {
                        data: '',
                        defaultContent: `<td class="text-right py-0 align-middle">
                    <div class="btn-group btn-group-sm">
                    <a class="btn btn-info" id="btnEdit" title="Edit barangay"><i class="fas fa-edit"></i></a>
                    <a class="btn btn-danger" id="btnDelete" title="Delete barangay"><i class="fas fa-times-circle"></i></a>
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
