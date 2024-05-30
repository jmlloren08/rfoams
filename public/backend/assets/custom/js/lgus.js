'use strict';
$(document).ready(function () {
    setTimeout(function () {
        // load regions
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
                    { data: 'psgcCode' },
                    { data: 'regDesc' },
                    { data: 'regCode' },
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
                    { data: 'psgcCode' },
                    { data: 'provDesc' },
                    { data: 'regCode' },
                    { data: 'provCode' },
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
                    { data: 'psgcCode' },
                    { data: 'citymunDesc' },
                    { data: 'regCode' },
                    { data: 'provCode' },
                    { data: 'citymunCode' },
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
                    { data: 'brgyCode' },
                    { data: 'brgyDesc' },
                    { data: 'regCode' },
                    { data: 'provCode' },
                    { data: 'citymunCode' },
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
