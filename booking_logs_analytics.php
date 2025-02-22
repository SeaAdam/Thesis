<?php
include 'includes/dbconn.php';

// Fetch logs data
$sql = "SELECT COUNT(*) as total_logs, 
               COUNT(CASE WHEN message LIKE '%successful%' THEN 1 END) as success_logs, 
               COUNT(CASE WHEN message LIKE '%failed%' THEN 1 END) as failed_logs, 
               DATE(timestamp) as log_date
        FROM booking_logs 
        GROUP BY DATE(timestamp)";
$result = $conn->query($sql);

$logsData = [];
while ($row = $result->fetch_assoc()) {
    $logsData[] = $row;
}

// Prepare data for visualizations
$logDates = array_column($logsData, 'log_date');
$totalLogs = array_column($logsData, 'total_logs');
$successLogs = array_column($logsData, 'success_logs');
$failedLogs = array_column($logsData, 'failed_logs');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Logs Analytics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <!-- Line Chart -->
    <div class="row mt-4">
        <div class="col-md-8">
            <canvas id="logTrendChart"></canvas>
        </div>

        <!-- Performance Overview -->
        <div class="col-md-4">
            <h4>Performance Overview</h4>
            <p>Total Logs</p>
            <div class="progress">
                <div class="progress-bar bg-info" style="width: 100%;"><?= array_sum($totalLogs) ?></div>
            </div>
            <p>Successful Logs</p>
            <div class="progress">
                <div class="progress-bar bg-success"
                    style="width: <?= (array_sum($successLogs) / array_sum($totalLogs)) * 100 ?>%;"></div>
            </div>
            <p>Failed Logs</p>
            <div class="progress">
                <div class="progress-bar bg-danger"
                    style="width: <?= (array_sum($failedLogs) / array_sum($totalLogs)) * 100 ?>%;"></div>
            </div>

            <button class="btn btn-info overview-btn">View Details</button>

            <!-- Performance Report (Initially Hidden) -->
            <div id="performanceReport" class="overview-card">
                <h4>📊 Performance Summary</h4>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Total Logs</th>
                            <td><?= array_sum($totalLogs) ?></td>
                        </tr>
                        <tr>
                            <th>Successful Logs</th>
                            <td><?= array_sum($successLogs) ?>
                                (<?= round((array_sum($successLogs) / array_sum($totalLogs)) * 100, 2) ?>%)</td>
                        </tr>
                        <tr>
                            <th>Failed Logs</th>
                            <td><?= array_sum($failedLogs) ?>
                                (<?= round((array_sum($failedLogs) / array_sum($totalLogs)) * 100, 2) ?>%)</td>
                        </tr>
                    </tbody>
                </table>
                <p><b>Summary:</b> Out of <b><?= array_sum($totalLogs) ?></b> logs,
                    <b><?= array_sum($successLogs) ?></b> were successful, achieving a success rate of
                    <b><?= round((array_sum($successLogs) / array_sum($totalLogs)) * 100, 2) ?>%</b>. However,
                    <b><?= array_sum($failedLogs) ?></b> logs failed, accounting for
                    <b><?= round((array_sum($failedLogs) / array_sum($totalLogs)) * 100, 2) ?>%</b> of total attempts.
                </p>
            </div>

        </div>
    </div>



    <script>
        const logDates = <?= json_encode($logDates) ?>;
        const totalLogs = <?= json_encode($totalLogs) ?>;
        const successLogs = <?= json_encode($successLogs) ?>;
        const failedLogs = <?= json_encode($failedLogs) ?>;

        // Line Chart Configuration
        const ctx = document.getElementById('logTrendChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: logDates,
                datasets: [
                    {
                        label: 'Total Logs',
                        data: totalLogs,
                        borderColor: 'blue',
                        fill: false
                    },
                    {
                        label: 'Successful Logs',
                        data: successLogs,
                        borderColor: 'green',
                        fill: false
                    },
                    {
                        label: 'Failed Logs',
                        data: failedLogs,
                        borderColor: 'red',
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Booking Logs Analytics'
                    }
                }
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            let overviewSection = document.querySelector(".performance-overview");
            let overviewBtn = overviewSection.querySelector(".overview-btn");
            let overviewCard = overviewSection.querySelector(".overview-card");

            overviewBtn.addEventListener("mouseenter", function () {
                overviewCard.style.display = "block";
            });

            overviewBtn.addEventListener("mouseleave", function () {
                setTimeout(() => {
                    if (!overviewCard.matches(":hover")) {
                        overviewCard.style.display = "none";
                    }
                }, 200);
            });

            overviewCard.addEventListener("mouseleave", function () {
                overviewCard.style.display = "none";
            });
        });
    </script>
</body>

</html>