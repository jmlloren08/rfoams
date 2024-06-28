$(document).ready(() => {
    setTimeout(() => {
        $(() => {
            'use strict'
            let lineGraphChartCanvas = $('#commendation-chart').get(0).getContext('2d');
            let lineGraphChartData = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [
                    {
                        label: 'Commendations',
                        fill: false,
                        borderWidth: 2,
                        lineTension: 0,
                        spanGaps: true,
                        borderColor: '#efefef',
                        pointRadius: 3,
                        pointHoverRadius: 7,
                        pointColor: '#efefef',
                        pointBackgroundColor: '#efefef',
                        data: Object.values(commendationsData)
                    }
                ]
            }
            let lineGraphChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            fontColor: '#efefef'
                        },
                        gridLines: {
                            display: false,
                            color: '#efefef',
                            drawBorder: false
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            stepSize: 5000,
                            fontColor: '#efefef'
                        },
                        gridLines: {
                            display: true,
                            color: '#efefef',
                            drawBorder: false
                        }
                    }]
                }
            }
            let lineGraphChart = new Chart(lineGraphChartCanvas, {
                type: 'line',
                data: lineGraphChartData,
                options: lineGraphChartOptions
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
                // filename
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
            // export chart to csv
            function exportChartDataToCSV(filename) {
                // initialize
                let csvData = [];
                let headers = ['Month', 'Commendations'];

                csvData.push(headers.join(','));

                lineGraphChartData.labels.forEach((label, index) => {
                    let row = [label, lineGraphChartData.datasets[0].data[index]];
                    csvData.push(row.join(','))
                });
                // convert csv data to string
                let csvString = csvData.join('\n');
                // download csv
                downloadCSV(csvString, filename);
            }
            // event listener
            document.getElementById('export-csv-commendation').addEventListener('click', () => {
                exportChartDataToCSV('chart-data-commendation.csv');
            });
            // download jpg
            document.getElementById('download-jpg-commendation').addEventListener('click', () => {
                let link = document.createElement('a');
                link.href = lineGraphChart.toBase64Image();
                link.download = 'chart-data-commendation.jpeg';
                link.click();
            });
        });
    }, 1000);
});