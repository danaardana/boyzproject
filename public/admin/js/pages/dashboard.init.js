/*
Template Name: Minia - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Dashboard Init Js File
*/

/*!
 * Dashboard Init Script
 * E-commerce Motorcycle Spare Parts Dashboard
 */

// get colors array from the string
function getChartColorsArray(chartId) {
    if (document.getElementById(chartId) !== null) {
        var colors = document.getElementById(chartId).getAttribute("data-colors");
        if (colors) {
            colors = JSON.parse(colors);
            return colors.map(function (value) {
                var newValue = value.replace(" ", "");
                if (newValue.indexOf("--") != -1) {
                    var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
                    if (color) return color;
                } else {
                    return newValue;
                }
            });
        }
    }
    return [];
}

//  MINI CHART

// mini-1
var minichart1Colors = getChartColorsArray("#mini-chart1");
var options = {
    series: [{
        data: [2, 10, 18, 22, 36, 15, 47, 75, 65, 19, 14, 2, 47, 42, 15, ]
    }],
    chart: {
        type: 'line',
        height: 50,
        sparkline: {
            enabled: true
        }
    },
    colors: minichart1Colors,
    stroke: {
        curve: 'smooth',
        width: 2,
    },
    tooltip: {
        fixed: {
            enabled: false
        },
        x: {
            show: false
        },
        y: {
            title: {
                formatter: function (seriesName) {
                    return ''
                }
            }
        },
        marker: {
            show: false
        }
    }
};

var chart = new ApexCharts(document.querySelector("#mini-chart1"), options);
chart.render();

// mini-2
var minichart2Colors = getChartColorsArray("#mini-chart2");
var options = {
    series: [{
        data: [15, 42, 47, 2, 14, 19, 65, 75, 47, 15, 42, 47, 2, 14, 12, ]
    }],
    chart: {
        type: 'line',
        height: 50,
        sparkline: {
            enabled: true
        }
    },
    colors: minichart2Colors,
    stroke: {
        curve: 'smooth',
        width: 2,
    },
    tooltip: {
        fixed: {
            enabled: false
        },
        x: {
            show: false
        },
        y: {
            title: {
                formatter: function (seriesName) {
                    return ''
                }
            }
        },
        marker: {
            show: false
        }
    }
};

var chart = new ApexCharts(document.querySelector("#mini-chart2"), options);
chart.render();

// mini-3
var minichart3Colors = getChartColorsArray("#mini-chart3");
var options = {
    series: [{
        data: [47, 15, 2, 67, 22, 20, 36, 60, 60, 30, 50, 11, 12, 3, 8, ]
    }],
    chart: {
        type: 'line',
        height: 50,
        sparkline: {
            enabled: true
        }
    },
    colors: minichart3Colors,
    stroke: {
        curve: 'smooth',
        width: 2,
    },
    tooltip: {
        fixed: {
            enabled: false
        },
        x: {
            show: false
        },
        y: {
            title: {
                formatter: function (seriesName) {
                    return ''
                }
            }
        },
        marker: {
            show: false
        }
    }
};

var chart = new ApexCharts(document.querySelector("#mini-chart3"), options);
chart.render();

// mini-4
var minichart4Colors = getChartColorsArray("#mini-chart4");
var options = {
    series: [{
        data: [12, 14, 2, 47, 42, 15, 47, 75, 65, 19, 14, 2, 47, 42, 15, ]
    }],
    chart: {
        type: 'line',
        height: 50,
        sparkline: {
            enabled: true
        }
    },
    colors: minichart4Colors,
    stroke: {
        curve: 'smooth',
        width: 2,
    },
    tooltip: {
        fixed: {
            enabled: false
        },
        x: {
            show: false
        },
        y: {
            title: {
                formatter: function (seriesName) {
                    return ''
                }
            }
        },
        marker: {
            show: false
        }
    }
};

var chart = new ApexCharts(document.querySelector("#mini-chart4"), options);
chart.render();

// 
// Wallet Balance
//
var piechartColors = getChartColorsArray("#wallet-balance");
var options = {
    series: [35, 70, 15],
    chart: {
        width: 227,
        height: 227,
        type: 'pie',
    },
    labels: ['Ethereum', 'Bitcoin', 'Litecoin'],
    colors: piechartColors,
    stroke: {
        width: 0,
    },
    legend: {
        show: false
    },
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 200
            },
        }
    }]
};

var chart = new ApexCharts(document.querySelector("#wallet-balance"), options);
chart.render();

//
// Invested Overview
//

var radialchartColors = getChartColorsArray("#invested-overview");
var options = {
    chart: {
        height: 270,
        type: 'radialBar',
        offsetY: -10
    },
    plotOptions: {
        radialBar: {
            startAngle: -130,
            endAngle: 130,
            dataLabels: {
                name: {
                    show: false
                },
                value: {
                    offsetY: 10,
                    fontSize: '18px',
                    color: undefined,
                    formatter: function (val) {
                        return val + "%";
                    }
                }
            }
        }
    },
    colors: [radialchartColors[0]],
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'dark',
            type: 'horizontal',
            gradientToColors: [radialchartColors[1]],
            shadeIntensity: 0.15,
            inverseColors: false,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [20, 60]
        },
    },
    stroke: {
        dashArray: 4,
    },
    legend: {
        show: false
    },
    series: [80],
    labels: ['Series A'],
}

var chart = new ApexCharts(
    document.querySelector("#invested-overview"),
    options
);

chart.render();

//
// Market Overview
//
var barchartColors = getChartColorsArray("#market-overview");
var options = {
    series: [{
        name: 'Profit',
        data: [12.45, 16.2, 8.9, 11.42, 12.6, 18.1, 18.2, 14.16, 11.1, 8.09, 16.34, 12.88]
    }, {
        name: 'Loss',
        data: [-11.45, -15.42, -7.9, -12.42, -12.6, -18.1, -18.2, -14.16, -11.1, -7.09, -15.34, -11.88]
    }],
    chart: {
        type: 'bar',
        height: 400,
        stacked: true,
        toolbar: {
            show: false
        },
    },
    plotOptions: {
        bar: {
            columnWidth: '20%',
        },
    },
    colors: barchartColors,
    fill: {
        opacity: 1
    },
    dataLabels: {
        enabled: false,
    },
    legend: {
        show: false,
    },
    yaxis: {
        labels: {
            formatter: function (y) {
                return y.toFixed(0) + "%";
            }
        }
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        labels: {
            rotate: -90
        }
    }
};

var chart = new ApexCharts(document.querySelector("#market-overview"), options);
chart.render();

// MAp

var vectormapColors = getChartColorsArray("#sales-by-locations");
$('#sales-by-locations').vectorMap({
    map: 'world_mill_en',
    normalizeFunction: 'polynomial',
    hoverOpacity: 0.7,
    hoverColor: false,
    regionStyle: {
        initial: {
            fill: '#e9e9ef'
        }
    },
    markerStyle: {
        initial: {
            r: 9,
            'fill': vectormapColors[0] || '#5156be',
            'fill-opacity': 0.9,
            'stroke': '#fff',
            'stroke-width': 7,
            'stroke-opacity': 0.4
        },

        hover: {
            'stroke': '#fff',
            'fill-opacity': 1,
            'stroke-width': 1.5
        }
    },
    backgroundColor: 'transparent',
    markers: [{
        latLng: [41.90, 12.45],
        name: 'USA'
    }, {
        latLng: [12.05, -61.75],
        name: 'Russia'
    }, {
        latLng: [1.3, 103.8],
        name: 'Australia'
    }]
});

// Transaction Distribution Pie Chart
var transactionDistributionChart = {
    series: [647, 287, 59],
    chart: {
        type: 'pie',
        height: 320,
        fontFamily: 'Poppins, sans-serif'
    },
    labels: ['Shopee', 'Tokopedia', 'Direct Sales'],
    colors: ['#5156be', '#34c38f', '#f1b44c'],
    legend: {
        show: false
    },
    dataLabels: {
        enabled: true,
        formatter: function (val) {
            return val.toFixed(1) + "%"
        }
    },
    plotOptions: {
        pie: {
            expandOnClick: false,
            donut: {
                size: '70%'
            }
        }
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return val + " transactions"
            }
        }
    },
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                height: 250
            }
        }
    }]
};

// Revenue by Platform Chart (Donut Chart)
var revenueChart = {
    series: [8700000, 3200000, 900000],
    chart: {
        type: 'donut',
        height: 220,
        fontFamily: 'Poppins, sans-serif'
    },
    labels: ['Shopee', 'Tokopedia', 'Direct Sales'],
    colors: ['#5156be', '#34c38f', '#f1b44c'],
    legend: {
        show: false
    },
    dataLabels: {
        enabled: false
    },
    plotOptions: {
        pie: {
            donut: {
                size: '75%',
                labels: {
                    show: true,
                    name: {
                        show: true,
                        fontSize: '16px',
                        fontWeight: 600,
                        color: '#495057'
                    },
                    value: {
                        show: true,
                        fontSize: '24px',
                        fontWeight: 700,
                        color: '#495057',
                        formatter: function (val) {
                            return 'Rp ' + (val / 1000000).toFixed(1) + 'M'
                        }
                    },
                    total: {
                        show: true,
                        showAlways: true,
                        label: 'Total Revenue',
                        fontSize: '14px',
                        fontWeight: 400,
                        color: '#74788d',
                        formatter: function (w) {
                            var total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                            return 'Rp ' + (total / 1000000).toFixed(1) + 'M'
                        }
                    }
                }
            }
        }
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return 'Rp ' + (val / 1000000).toFixed(1) + 'M'
            }
        }
    },
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                height: 200
            }
        }
    }]
};

// Top-Selling Categories Chart (existing chart)
var categoryChart = {
    series: [524, 312, 89],
    chart: {
        type: 'donut',
        height: 280,
        fontFamily: 'Poppins, sans-serif'
    },
    labels: ['Mounting & Body', 'Lighting', 'Installation Service'],
    colors: ['#34c38f', '#5156be', '#a8aada'],
    legend: {
        show: false
    },
    dataLabels: {
        enabled: true,
        formatter: function (val) {
            return val.toFixed(1) + "%"
        }
    },
    plotOptions: {
        pie: {
            donut: {
                size: '70%'
            }
        }
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return val + " units"
            }
        }
    },
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                height: 200
            }
        }
    }]
};

// Mini charts for the metric cards
var miniChart1 = {
    series: [{
        data: [25, 30, 25, 45, 30, 55, 40]
    }],
    chart: {
        type: 'line',
        height: 50,
        sparkline: {
            enabled: true
        }
    },
    stroke: {
        curve: 'smooth',
        width: 2
    },
    colors: ['#5156be'],
    tooltip: {
        enabled: false
    }
};

var miniChart2 = {
    series: [{
        data: [10, 15, 12, 18, 15, 25, 20, 30, 25, 35]
    }],
    chart: {
        type: 'line',
        height: 50,
        sparkline: {
            enabled: true
        }
    },
    stroke: {
        curve: 'smooth',
        width: 2
    },
    colors: ['#5156be'],
    tooltip: {
        enabled: false
    }
};

var miniChart3 = {
    series: [{
        data: [20, 25, 30, 25, 35, 30, 40, 35, 45]
    }],
    chart: {
        type: 'line',
        height: 50,
        sparkline: {
            enabled: true
        }
    },
    stroke: {
        curve: 'smooth',
        width: 2
    },
    colors: ['#5156be'],
    tooltip: {
        enabled: false
    }
};

var miniChart4 = {
    series: [{
        data: [4.5, 4.6, 4.7, 4.8, 4.7, 4.9, 4.8]
    }],
    chart: {
        type: 'line',
        height: 50,
        sparkline: {
            enabled: true
        }
    },
    stroke: {
        curve: 'smooth',
        width: 2
    },
    colors: ['#5156be'],
    tooltip: {
        enabled: false
    }
};

// Counter animation
function animateCounters() {
    var counters = document.querySelectorAll('.counter-value');
    counters.forEach(function(counter) {
        var target = parseFloat(counter.getAttribute('data-target'));
        var current = 0;
        var increment = target / 100;
        var timer = setInterval(function() {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            counter.textContent = current.toFixed(1);
        }, 20);
    });
}

// Initialize dashboard when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize Transaction Distribution Chart
    if (document.getElementById('transaction-distribution-chart')) {
        var transDistChart = new ApexCharts(
            document.querySelector("#transaction-distribution-chart"), 
            transactionDistributionChart
        );
        transDistChart.render();
    }

    // Initialize Revenue Chart
    if (document.getElementById('revenue-chart')) {
        var revChart = new ApexCharts(
            document.querySelector("#revenue-chart"), 
            revenueChart
        );
        revChart.render();
    }

    // Initialize Category Chart
    if (document.getElementById('category-chart')) {
        var catChart = new ApexCharts(
            document.querySelector("#category-chart"), 
            categoryChart
        );
        catChart.render();
    }

    // Initialize Mini Charts
    if (document.getElementById('mini-chart1')) {
        var chart1 = new ApexCharts(document.querySelector("#mini-chart1"), miniChart1);
        chart1.render();
    }

    if (document.getElementById('mini-chart2')) {
        var chart2 = new ApexCharts(document.querySelector("#mini-chart2"), miniChart2);
        chart2.render();
    }

    if (document.getElementById('mini-chart3')) {
        var chart3 = new ApexCharts(document.querySelector("#mini-chart3"), miniChart3);
        chart3.render();
    }

    if (document.getElementById('mini-chart4')) {
        var chart4 = new ApexCharts(document.querySelector("#mini-chart4"), miniChart4);
        chart4.render();
    }

    // Initialize counter animation
    animateCounters();
});

// Export for external use
window.dashboardCharts = {
    transactionDistributionChart: transactionDistributionChart,
    revenueChart: revenueChart,
    categoryChart: categoryChart
};