<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Analytics Dashboard</title>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<style>
    body {
        margin: 0;
        padding: 30px;
        font-family: "Inter", Arial, sans-serif;
        background: #f3f6fb;
        color: #1f2937;
    }

    h1 {
        margin-bottom: 25px;
        font-size: 26px;
        font-weight: 600;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
    }

    .chart-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px 20px 25px;
        box-shadow: 0 12px 30px rgba(0,0,0,0.08);
        transition: transform 0.2s ease;
    }

    .chart-card:hover {
        transform: translateY(-3px);
    }

    .chart-title {
        font-size: 15px;
        font-weight: 600;
        text-align: center;
        margin-bottom: 10px;
        color: #374151;
    }

    .chart-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
</head>

<body>

<h1 style="text-align: center;">System Analytics Overview</h1>

<div class="dashboard-grid">

<div class="chart-card">
        <div class="chart-title">User Type</div>
        <div class="chart-wrapper">
            <div id="userTypeChart"></div>
        </div>
    </div>
    
    <div class="chart-card">
        <div class="chart-title">Device Type</div>
        <div class="chart-wrapper">
            <div id="deviceTypeChart"></div>
        </div>
    </div>

    <div class="chart-card">
        <div class="chart-title">Device OS</div>
        <div class="chart-wrapper">
            <div id="deviceOSChart"></div>
        </div>
    </div>

    <div class="chart-card">
        <div class="chart-title">Browser</div>
        <div class="chart-wrapper">
            <div id="browserChart"></div>
        </div>
    </div>

    <div class="chart-card">
        <div class="chart-title">User Actions</div>
        <div class="chart-wrapper">
            <div id="actionChart"></div>
        </div>
    </div>

    
</div>

<script>
function donutChart(selector, title, data) {
    new ApexCharts(document.querySelector(selector), {
        chart: {
            type: 'donut',
            height: 260
        },

        labels: data.map(d => d.label),
        series: data.map(d => d.total),

        colors: ['#2563eb','#16a34a','#f59e0b','#ef4444','#6366f1'],

        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val.toFixed(1) + '%';
            },
            style: {
                fontSize: '10px',
                fontWeight: '600',
                colors: ['#111827']
            }
        },

        plotOptions: {
            pie: {
                donut: {
                    size: '68%',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '14px',
                            fontWeight: 600
                        },
                        value: {
                            show: true,
                            fontSize: '14px',
                            fontWeight: 600,
                            formatter: val => val + '%'
                        },
                        total: {
                            show: true,
                            label: title.toUpperCase(),
                            fontSize: '12px',
                            fontWeight: 700,
                            color: '#111827',
                            formatter: function () {
                                return '100%';
                            }
                        }
                    }
                }
            }
        },

        legend: {
            show: true,
            position: 'bottom',
            fontSize: '12px',
            labels: {
                colors: '#374151'
            }
        },

        tooltip: {
            enabled: true,
            y: {
                formatter: val => val + '%'
            }
        }
    }).render();
}

// Render charts using backend data
donutChart('#userTypeChart', 'User Type', @json($userType));
donutChart('#deviceTypeChart', 'Device Type', @json($deviceType));
donutChart('#deviceOSChart', 'Device OS', @json($deviceOS));
donutChart('#browserChart', 'Browser', @json($browser));
donutChart('#actionChart', 'User Action', @json($userAction));

</script>

</body>
</html>
