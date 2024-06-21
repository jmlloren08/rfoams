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
            var chartLabels = chartData.map(function (item) {
                return item.region;
            });
            var chartDataSets = types.map(function (type, index) {
                return {
                    label: type,
                    backgroundColor: colors[index],
                    borderColor: colors[index],
                    data: chartData.map(function (item) {
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
        });
    }, 1000);
});