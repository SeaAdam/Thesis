<?php
include 'includes/dbconn.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT status, COUNT(*) as total FROM client_booking GROUP BY status";
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

<div class="col-md-6 col-sm-6">
    <div class="x_panel">
        <div class="x_title">
            <h2>Client Booking Overview <small>Transaction Summary</small></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="chart-container" style="position: relative; width: 100%; height: 300px;">
                <canvas id="statusDoughnutChart2"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx2 = document.getElementById('statusDoughnutChart2').getContext('2d');

        // Data from PHP
        var statusData = <?php echo json_encode($statusCounts); ?>;

        var statusLabels = Object.keys(statusData);
        var statusValues = Object.values(statusData);

        var statusDoughnutChart = new Chart(ctx2, {
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
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 14
                            }
                        }
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
