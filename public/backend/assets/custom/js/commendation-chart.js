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
        });
    }, 1000);
});