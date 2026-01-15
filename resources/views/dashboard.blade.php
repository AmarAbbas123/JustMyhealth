<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donut Charts Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        body { font-family: Arial; background:#f2f4f8; padding:40px; }
        .chart-container { display:flex; flex-wrap: wrap; gap:40px; justify-content:center; }
        .chart-box { width: 350px; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Regional Donut Charts</h2>
<div class="chart-container">
    @foreach($charts as $index => $chart)
    <div class="chart-box">
        <div id="donut-chart-{{ $index }}"></div>
    </div>
    @endforeach
</div>

<script>
    @foreach($charts as $index => $chart)
    var options{{ $index }} = {
        chart: { type: 'donut', height: 400 },
        series: @json($chart['values']),
        labels: @json($chart['labels']),
        colors: ['#1abc9c','#2ecc71','#3498db','#9b59b6','#34495e','#95a5a6'],
        dataLabels: {
            enabled: true,
            formatter: function(val) { return val + "%"; },
            style: { fontSize: '12px', colors: ['#000'] }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '60%',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '18px',
                            fontWeight: 'bold',
                            color: '#333',
                            offsetY: 10
                        },
                        value: {
                            show: true,
                            fontSize: '14px',
                            fontWeight: 'bold',
                            color: '#111',
                            formatter: function(val) { return val + "%"; }
                        },
                        total: {
                            show: true,
                            label: "{{ $chart['region'] }}",
                            color: '#000',
                            formatter: function(w) {
                                return "{{ $chart['region'] }}";
                            }
                        }
                    }
                }
            }
        },
        legend: { position: 'bottom' },
        tooltip: {
            y: { formatter: function(val){ return val + "%"; } }
        }
    };

    var chart{{ $index }} = new ApexCharts(document.querySelector("#donut-chart-{{ $index }}"), options{{ $index }});
    chart{{ $index }}.render();
    @endforeach
</script>

</body>
</html>
