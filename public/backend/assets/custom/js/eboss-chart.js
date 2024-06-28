$(document).ready(() => {
    setTimeout(() => {
        $(() => {
            'use strict'
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
            var chartLabels = chartData.map((item) => {
                return item.region;
            });
            var chartDataSets = types.map((type, index) => {
                return {
                    label: type,
                    backgroundColor: colors[index],
                    borderColor: colors[index],
                    data: chartData.map((item) => {
                        return item.data[index];
                    })
                }
            });
            var $ebossChart = $('#eboss-chart')
            // eslint-disable-next-line no-unused-vars
            var ebossChart = new Chart($ebossChart, {
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
            // download csv
            function downloadCSV(csv, filename) {
                // initialize
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
                // click the download link
                downloadLink.click();
            }
            function exportChartDataToCSV(filename) {
                // initialize
                let csvData = [];
                let headers = ['Region'];
                // add chart data headers
                types.forEach(type => {
                    headers.push(type);
                });
                csvData.push(headers.join(','));
                // add chart data rows
                chartData.forEach(data => {
                    let row = [data.region];
                    data.data.forEach(value => {
                        row.push(value);
                    });
                    csvData.push(row.join(','));
                });
                // convert CSV data to string
                let csvString = csvData.join('\n');
                // download CSV
                downloadCSV(csvString, filename);
            }
            // event listener for csv download
            document.getElementById('export-csv-eboss').addEventListener('click', () => {
                exportChartDataToCSV('chart-data-eboss.csv');
            });
            // download jpeg
            document.getElementById('download-jpg-eboss').addEventListener('click', () => {
                let link = document.createElement('a');
                link.href = ebossChart.toBase64Image();
                link.download = 'chart-data-eboss.jpeg';
                link.click();
            });
        });
    }, 1000);
});
