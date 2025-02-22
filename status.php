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

<div class="col-md-6 col-sm-6 booking-overview">
    <div class="x_panel">
        <div class="x_title">
            <h2>Patient Booking Overview <small>Transaction Summary</small></h2>

            <!-- Report Button -->
            <button class="btn btn-info report-btn">View Report</button>

            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        
        <!-- Report Summary (Hidden Initially) -->
        <div class="report-card">
            <h4>📊 Booking Summary</h4>
            <table class="table table-bordered">
                <tbody>
                    <tr><th>Pending</th><td><?= $statusCounts['Pending'] ?></td></tr>
                    <tr><th>Approved</th><td><?= $statusCounts['Approved'] ?></td></tr>
                    <tr><th>Completed</th><td><?= $statusCounts['Completed'] ?></td></tr>
                    <tr><th>Rejected</th><td><?= $statusCounts['Rejected'] ?></td></tr>
                </tbody>
            </table>
            <p><b>Summary:</b> Out of all transactions, <b><?= $statusCounts['Completed'] ?></b> were completed, <b><?= $statusCounts['Pending'] ?></b> are still pending, while <b><?= $statusCounts['Rejected'] ?></b> were rejected.</p>
        </div>

        <div class="x_content">
            <div class="chart-container" style="position: relative; width: 100%; height: 300px;">
                <canvas id="statusDoughnutChart1"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx1 = document.getElementById('statusDoughnutChart1').getContext('2d');

        // Data from PHP
        var statusData = <?php echo json_encode($statusCounts); ?>;

        var statusLabels = Object.keys(statusData);
        var statusValues = Object.values(statusData);

        var statusDoughnutChart = new Chart(ctx1, {
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

        // Report Button Hover Effect
        let reportBtn = document.querySelector(".report-btn");
        let reportCard = document.querySelector(".report-card");

        reportBtn.addEventListener("mouseenter", function () {
            reportCard.style.display = "block";
        });

        reportBtn.addEventListener("mouseleave", function () {
            setTimeout(() => {
                if (!reportCard.matches(":hover")) {
                    reportCard.style.display = "none";
                }
            }, 200);
        });

        reportCard.addEventListener("mouseleave", function () {
            reportCard.style.display = "none";
        });

    });
</script>
