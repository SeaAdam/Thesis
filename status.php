<?php
include 'includes/dbconn.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT status, COUNT(*) as total FROM transactions GROUP BY status";
$result = $conn->query($sql);

$statusCounts = [
    'Pending' => 0,
    'Approved' => 0,
    'Completed' => 0,
    'Rejected' => 0
];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $statusCounts[$row['status']] = $row['total'];
    }
}

$conn->close();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            position: relative;
            width: 100%;
            /* Adjust width as needed */
            height: 200px;
            /* Adjust height as needed */
        }

        #statusDoughnutChart {
            width: 100% !important;
            height: 100% !important;
        }

    </style>
</head>

<body>
    <div class="col-sm-3 py-3">
        <div class="card h-100 ">
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="statusDoughnutChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('statusDoughnutChart').getContext('2d');

            // Data from PHP
            var statusData = <?php echo json_encode($statusCounts); ?>;

            var statusLabels = Object.keys(statusData);
            var statusValues = Object.values(statusData);

            var statusDoughnutChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: statusValues,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Ensure it adapts to container
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>