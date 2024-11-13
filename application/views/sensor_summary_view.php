<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensor Summary Dashboard</title>
    <style>
        /* Enhanced styling for a more elegant and colorful look */
        body {
            font-family: 'Arial', sans-serif;
            background: #e8f4f8; /* Light blue background */
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 30px;
            border-radius: 15px;
            background: linear-gradient(145deg, #ffffff, #f0f4f8);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            font-size: 36px;
            color: #2d4b7d;
            font-weight: bold;
            margin-bottom: 40px;
            text-transform: uppercase;
            letter-spacing: 3px;
        }
        .summary {
            display: flex;
            gap: 20px;
            justify-content: space-between;
            margin-bottom: 40px;
        }
        .summary-item {
            background: linear-gradient(145deg, #ffffff, #e0e5ec);
            border-radius: 10px;
            padding: 30px;
            flex: 1;
            text-align: center;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.1), -5px -5px 15px rgba(255, 255, 255, 0.8);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .summary-item:hover {
            transform: translateY(-7px);
            box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.2), -5px -5px 20px rgba(255, 255, 255, 0.8);
        }
        .summary-item h2 {
            font-size: 22px;
            color: #4a4e69;
            margin-bottom: 15px;
            font-weight: normal;
        }
        .summary-item p {
            font-size: 26px;
            color: #0077b6;
            font-weight: bold;
            margin-top: 10px;
        }
        .table-container {
            margin-top: 40px;
            background: #ffffff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 18px;
            text-align: center;
            border-bottom: 2px solid #f2f2f2;
        }
        th {
            background: linear-gradient(145deg, #0077b6, #00bcd4);
            color: #ffffff;
            font-weight: bold;
        }
        tr:hover {
            background-color: #e0f7fa;
        }
        .month-list {
            margin-top: 30px;
            text-align: center;
        }
        .month-list ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }
        .month-list li {
            background: linear-gradient(145deg, #ffffff, #e0e5ec);
            padding: 12px 25px;
            border-radius: 8px;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.1), -5px -5px 10px rgba(255, 255, 255, 0.8);
            color: #0077b6;
            font-weight: bold;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .month-list li:hover {
            transform: translateY(-5px);
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2), -5px -5px 15px rgba(255, 255, 255, 0.8);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sensor Summary Dashboard</h1>

        <!-- Summary Boxes -->
        <div class="summary">
            <div class="summary-item max-temp">
                <h2>Max Temperature</h2>
                <p id="suhu-max">Loading...</p>
            </div>
            <div class="summary-item min-temp">
                <h2>Min Temperature</h2>
                <p id="suhu-min">Loading...</p>
            </div>
            <div class="summary-item avg-temp">
                <h2>Avg Temperature</h2>
                <p id="suhu-avg">Loading...</p>
            </div>
        </div>

        <!-- Data Table -->
        <div class="table-container">
            <h2>Details of Max Temperature & Max Humidity</h2>
            <table>
                <thead>
                    <tr>
                        <th>Record ID</th>
                        <th>Temperature (°C)</th>
                        <th>Humidity (%)</th>
                        <th>Brightness (Lux)</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody id="data-table">
                    <tr><td colspan="5">Loading...</td></tr>
                </tbody>
            </table>
        </div>

        <!-- Month-Year List -->
        <div class="month-list">
            <h3>Month-Year for Max Temperature & Max Humidity Records</h3>
            <ul id="month-list">
                <li>Loading...</li>
            </ul>
        </div>
    </div>

    <script>
        // Fetch JSON data from the API endpoint and render it on the page
        async function fetchSensorData() {
            try {
                const response = await fetch('http://localhost/uts_iot/api/sensor_summary');
                const data = await response.json();

                // Display summary data
                document.getElementById('suhu-max').textContent = data.suhumax + ' °C';
                document.getElementById('suhu-min').textContent = data.suhumin + ' °C';
                document.getElementById('suhu-avg').textContent = data.suhurata + ' °C';

                // Render data table
                const dataTable = document.getElementById('data-table');
                dataTable.innerHTML = ''; // Clear loading message
                data.nilai_suhu_max_humid_max.forEach(record => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${record.idx}</td>
                        <td>${record.suhun}</td>
                        <td>${record.humid}</td>
                        <td>${record.kecerahan}</td>
                        <td>${record.timestamp}</td>
                    `;
                    dataTable.appendChild(row);
                });

                // Render month-year list
                const monthList = document.getElementById('month-list');
                monthList.innerHTML = ''; // Clear loading message
                data.month_year_max.forEach(month => {
                    const listItem = document.createElement('li');
                    listItem.textContent = month.month_year;
                    monthList.appendChild(listItem);
                });
            } catch (error) {
                console.error('Error fetching sensor data:', error);
            }
        }

        // Fetch data on page load
        fetchSensorData();
    </script>
</body>
</html>
