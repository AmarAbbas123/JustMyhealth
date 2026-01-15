<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Interactive Dashboard</title>

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Axios for AJAX -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        body { font-family: Arial; background:#f2f4f8; padding:40px; }
        .container { width: 800px; margin:auto; }
        table { width:100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 10px; text-align:center; }
        input[type=number], input[type=text] { width:100px; padding:5px; }
        button { padding:5px 10px; cursor:pointer; }
        .form-inline { margin-bottom:20px; text-align:center; }
    </style>
</head>
<body>

<div class="container">
    <h2 style="text-align:center;">Lead Sources Dashboard</h2>

    <!-- Add New Lead Form -->
    <div class="form-inline">
        <input type="text" id="new-source" placeholder="Source name">
        <input type="number" id="new-value" placeholder="Value">
        <button onclick="addLead()">Add</button>
    </div>

    <!-- Chart -->
    <div id="chart"></div>

    <!-- Editable Table -->
    <table>
        <thead>
            <tr>
                <th>Source</th>
                <th>Value</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $lead)
            <tr data-id="{{ $lead->id }}">
                <td>{{ $lead->source }}</td>
                <td>
                    <input type="number" value="{{ $lead->value }}" id="value-{{ $lead->id }}">
                </td>
                <td>
                    <button onclick="updateLead({{ $lead->id }})">Update</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    // Initial data from PHP
    let labels = @json($labels);
    let values = @json($values);

    // ApexCharts Pie Chart
    let options = {
        chart: { type: 'pie', height: 400 },
        series: values,
        labels: labels,
        dataLabels: {
            enabled: true,
            formatter: function(val) { return val + "%"; },
            style: { fontSize: '14px', colors: ['#fff'] }
        },
        tooltip: { y: { formatter: function(val){ return val + "%" } } },
        legend: { position: 'bottom' },
    };

    let chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();

    // Update lead value
    function updateLead(id){
        let input = document.getElementById('value-' + id);
        let value = parseInt(input.value);

        axios.post('/update-lead', { id: id, value: value })
        .then(function(response){
            if(response.data.success){
                // Find index in labels array
                let row = document.querySelector(`tr[data-id='${id}']`);
                let label = row.querySelector('td:first-child').innerText;
                let index = labels.indexOf(label);

                if(index !== -1){
                    values[index] = value;
                    chart.updateSeries(values);
                }
            }
        })
        .catch(function(error){ console.log(error); });
    }

    // Add new lead
    function addLead(){
        let source = document.getElementById('new-source').value;
        let value = document.getElementById('new-value').value;

        if(source === '' || value === ''){
            alert('Please enter both source and value');
            return;
        }

        axios.post('/add-lead', { source: source, value: value })
        .then(function(response){
            if(response.data.success){
                let newId = response.data.id; // actual database ID

                // Add row in table
                let table = document.querySelector('tbody');
                let row = document.createElement('tr');
                row.setAttribute('data-id', newId);
                row.innerHTML = `
                    <td>${source}</td>
                    <td><input type="number" value="${value}" id="value-${newId}"></td>
                    <td><button onclick="updateLead(${newId})">Update</button></td>
                `;
                table.appendChild(row);

                // Add data to chart
                labels.push(source);
                values.push(parseInt(value));
                chart.updateOptions({ labels: labels });
                chart.updateSeries(values);

                // Clear inputs
                document.getElementById('new-source').value = '';
                document.getElementById('new-value').value = '';
            }
        })
        .catch(function(error){ console.log(error); });
    }
</script>

</body>
</html>
