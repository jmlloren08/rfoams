$(document).ready(function () {
    setTimeout(() => {
        $(() => {
            'use strict'
            let stackedBarChartCanvas = $('#orientation-chart').get(0).getContext('2d');
            let stackedBarChartData = {
                labels: ['R.A. 11032', 'CART', 'PROGRAMS_AND_SERVICES', 'CC_ORIENTATION', 'CC_WORKSHOP', 'BPM_WORKSHOP', 'RIA', 'eBOSS', 'CSM', 'REENG'],
                datasets: [
                    {
                        label: 'Yes',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: countYes
                    },
                    {
                        label: 'No',
                        backgroundColor: 'rgba(210, 214, 222, 1)',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(210, 214, 222, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: countNo
                    },
                ]
            }
            let stackedBarChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }
            let orientationStackedBarChart = new Chart(stackedBarChartCanvas, {
                type: 'bar',
                data: stackedBarChartData,
                options: stackedBarChartOptions
            });
            // function download csv
            function downloadCSV(csv, filename) {
                let csvFile;
                let downloadLink;
                // csv file
                csvFile = new Blob([csv], { type: 'text/csv' });
                // download link
                downloadLink = document.createElement('a');
                // file name
                downloadLink.download = filename;
                // create a link to the file
                downloadLink.href = window.URL.createObjectURL(csvFile);
                // hide download link
                downloadLink.style.display = 'none';
                // add the link to the DOM
                document.body.appendChild(downloadLink);
                // click download link
                downloadLink.click();
            }
            // function export chart data to csv
            function exportOrientationChartDataToCSV(filename) {
                // initialize
                let csvData = [];
                let headers = ['Programs', 'Yes', 'No'];

                csvData.push(headers.join(','));

                // add chart data rows
                stackedBarChartData.labels.forEach((label, index) => {
                    let row = [label, stackedBarChartData.datasets[0].data[index], stackedBarChartData.datasets[1].data[index]];
                    csvData.push(row.join(','));
                });
                // convert csv data to string
                let csvString = csvData.join('\n');
                // download csv
                downloadCSV(csvString, filename);
            }
            // event listener
            document.getElementById('export-csv-orientation-overall').addEventListener('click', () => {
                exportOrientationChartDataToCSV('chart-data-orientation-overall.csv');
            });
            // download jpeg
            document.getElementById('download-jpg-orientation-overall').addEventListener('click', () => {
                let link = document.createElement('a');
                link.href = orientationStackedBarChart.toBase64Image();
                link.download = 'chart-data-orientation-overall.jpeg';
                link.click();
            });
        });
    }, 1000);
});