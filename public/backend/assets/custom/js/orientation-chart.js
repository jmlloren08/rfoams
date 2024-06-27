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
            new Chart(stackedBarChartCanvas, {
                type: 'bar',
                data: stackedBarChartData,
                options: stackedBarChartOptions
            });
        });
    }, 1000);
});