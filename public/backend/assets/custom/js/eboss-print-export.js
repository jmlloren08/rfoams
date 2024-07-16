document.getElementById('print-report-eboss').addEventListener('click', () => {
    printReport();
});
function printReport() {

    let table = $('#dataTableeBOSS').DataTable();
    let data = table.rows().data().toArray();

    // Create a new window for the printable report
    let printWindow = window.open('', '', 'height=800, width=1000');
    printWindow.document.write('<html><head><title>eBOSS Report</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('@media print { @page {margin: 0; } body { margin: 1cm; } }');
    printWindow.document.write('body{font-family: Arial, sans-serif;} table{width: 100%; border-collapse: collapse;} table, th, td{border: 1px solid black;} th, td{padding: 8px; text-align: left;} th{background-background-color: #f2f2f2;}</style>');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<div style="text-align: center;">');
    printWindow.document.write('<img src="https://arta.gov.ph/wp-content/uploads/2023/09/new-logo4.png" alt="Logo" style=width: 100px; height: auto;">')
    printWindow.document.write('<h2>eBOSS Report</h2>');
    printWindow.document.write('</div>');
    printWindow.document.write('<table>');
    printWindow.document.write('<thead><tr><th>#</th><th>DATE_OF_INSPECTION</th><th>CITY_MUNICIPALITY</th><th>PROVINCE</th><th>REGION</th><th>eBOSS_SUBMISSION</th><th>TYPE_OF_BOSS</th><th>DEADLINE_OF_ACTION_PLAN</th><th>SUBMISSION_OF_ACTION_PLAN</th><th>REMARKS</th><th>BPLO_HEAD</th><th>CONTACT_NO</th></tr></thead>');
    printWindow.document.write('<tbody>');

    // Loop through the data and create table rows
    data.forEach((row, index) => {
        printWindow.document.write('<tr>');
        printWindow.document.write(`<td> ${index + 1} </td>`);
        printWindow.document.write(`<td> ${row.date_of_inspection} </td>`);
        printWindow.document.write(`<td> ${row.citymunDesc} </td>`);
        printWindow.document.write(`<td> ${row.provDesc} </td>`);
        printWindow.document.write(`<td> ${row.regDesc} </td>`);
        printWindow.document.write(`<td> ${row.eboss_submission} </td>`);
        printWindow.document.write(`<td> ${row.type_of_boss} </td>`);
        printWindow.document.write(`<td> ${row.deadline_of_action_plan === 'null' ? 'No data' : row.deadline_of_action_plan} </td>`);
        printWindow.document.write(`<td> ${row.submission_of_action_plan === 'null' ? 'No data' : row.submission_of_action_plan} </td>`);
        printWindow.document.write(`<td> ${row.remarks !== null ? row.remarks : 'No data'} </td>`);
        printWindow.document.write(`<td> ${row.bplo_head !== null ? row.bplo_head : 'No data'} </td>`);
        printWindow.document.write(`<td> ${row.contact_no !== null ? row.contact_no : 'No data'} </td>`);
        printWindow.document.write('</tr>');
    });

    printWindow.document.write('</tbody>');
    printWindow.document.write('</table>');
    printWindow.document.write('</body></html>');

    // Trigger the print dialog
    printWindow.document.close();
    printWindow.print();
}
function downloadCSV(csv, filename) {
    // initialization
    let csvFile;
    let downloadLink;
    // create csv blob
    csvFile = new Blob([csv], { type: 'text/csv' });
    // create download link
    downloadLink = document.createElement('a');
    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = 'none';
    // append link to dom
    document.body.appendChild(downloadLink);
    // simulate click on download link
    downloadLink.click();
    // clean up
    document.body.appendChild(downloadLink);
}
function exportDataTableToCSV(filename) {
    // initialize
    let csvData = [];
    let headers = [
        '#',
        'DATE_OF_INSPECTION',
        'CITY/MUNICIPALITY',
        'PROVINCE',
        'REGION',
        'eBOSS_SUBMISSION',
        'TYPE_OF_BOSS',
        'DEADLINE_OF_ACTION_PLAN',
        'SUBMISSION_OF_ACTION_PLAN',
        'REMARKS',
        'BPLO_HEAD',
        'CONTACT_NO'
    ];
    // add headers to csv data
    csvData.push(headers.join(','));
    let table = $('#dataTableeBOSS').DataTable();
    // add row to csv data
    table.rows().every(function (index) {
        let rowData = this.data();
        let row = [
            index + 1,
            rowData.date_of_inspection,
            rowData.citymunDesc,
            rowData.provDesc,
            rowData.regDesc,
            rowData.eboss_submission,
            rowData.type_of_boss,
            rowData.deadline_of_action_plan === 'null' ? 'No data' : rowData.deadline_of_action_plan,
            rowData.submission_of_action_plan === 'null' ? 'No data' : rowData.submission_of_action_plan,
            rowData.remarks !== null ? rowData.remarks : 'No data',
            rowData.bplo_head !== null ? rowData.bplo_head : 'No data',
            rowData.contact_no !== null ? rowData.contact_no : 'No data'
        ];
        csvData.push(row.join(','));
    });
    // convert csv data to string
    let csvString = csvData.join('\n');
    // download csv
    downloadCSV(csvString, filename);
}
document.getElementById('export-csv-eboss').addEventListener('click', () => {
    exportDataTableToCSV('eBOSS_report.csv');
});
