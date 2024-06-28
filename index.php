<!DOCTYPE html>
<html>
<head>
    <title>Intelligence Cyber Force (ICF)</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: black;
            color: lime;
            font-family: monospace;
        }
        h1 {
            color: lime;
            text-align: center;
            font-size: 36px;
        }
        button {
            background-color: lime;
            color: black;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            cursor: pointer;
        }
        button:hover {
            background-color: darkgreen;
        }
        input {
            padding: 10px;
            font-size: 18px;
            margin-right: 10px;
            width: 300px;
        }
        .logo {
            position: absolute;
            top: 10px;
            left: 10px; /* Adjusted to top-left corner */
            width: 150px;
            height: auto;
        }
        .status {
            position: absolute;
            top: 40px;
            right: 170px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: red; /* default color */
        }
        form {
            text-align: center;
            margin-top: 40px;
        }
        canvas {
            display: block;
            margin: 40px auto;
            width: 80%;
            height: 400px;
            background-color: white;
        }
    </style>
</head>
<body>

<img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEh8OW62K12-q1MxdV7I8W2LafJpFFOGox_819GuTWGn-0SHROos-qdsVWsrvzfhC-n0JXz0GSTkiU666HKHlDwbAQw-_4XfM38s4vaeEIw0UC-MgPQTz_V6ZHn12eTc1OUijjgYH1Zrw3mHR3DcrXcroY0qLdqIZRuWNVqebDc5d2W4t9AfHREI5sQ0zb41/s514/LOGO.png" alt="ICF Logo" class="logo">
<div class="status" id="statusIndicator"></div>

<h1>Website DDOS Checker</h1>
<form id="urlForm">
    <label for="url">Enter Website URL:</label>
    <input type="text" id="url" name="url" required>
    <button type="submit">Go</button>
</form>

<canvas id="myChart"></canvas>

<script>
$(document).ready(function() {
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Requests Sent',
                data: [],
                borderColor: 'lime',
                fill: false
            }, {
                label: 'Response Time (ms)',
                data: [],
                borderColor: 'red',
                fill: false
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'linear',
                    position: 'bottom'
                }
            }
        }
    });

    var requestData = function(url) {
        $.post('requestData.php', { url: url }, function(data) {
            var result = JSON.parse(data);
            myChart.data.labels.push(result.time);
            myChart.data.datasets[0].data.push(result.requestCount);
            myChart.data.datasets[1].data.push(result.responseTime);
            myChart.update();
            
            // Update status indicator
            var statusIndicator = document.getElementById('statusIndicator');
            if (result.status === 'up') {
                statusIndicator.style.backgroundColor = 'lime';
            } else {
                statusIndicator.style.backgroundColor = 'red';
            }
        });
    };

    $('#urlForm').submit(function(event) {
        event.preventDefault();
        var url = $('#url').val();
        myChart.data.labels = [];
        myChart.data.datasets[0].data = [];
        myChart.data.datasets[1].data = [];
        setInterval(function() {
            requestData(url);
        }, 1000);
    });
});
</script>

</body>
</html>
