<?php
include 'includes/dbconn.php';

// Fetch action counts from the database
$actionCountsQuery = "SELECT action, COUNT(*) as count FROM action_logs GROUP BY action";
$actionCountsResult = $conn->query($actionCountsQuery);

// Fetch user activity counts from the database
$userActivityQuery = "SELECT user_id, COUNT(*) as count FROM action_logs GROUP BY user_id";
$userActivityResult = $conn->query($userActivityQuery);

$action_counts = array();
$user_activity = array();

// Store action counts in an associative array
while ($row = $actionCountsResult->fetch_assoc()) {
    $action_counts[$row['action']] = $row['count'];
}

// Store user activity counts in an associative array
while ($row = $userActivityResult->fetch_assoc()) {
    $user_activity[$row['user_id']] = $row['count'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Analytics - Admin Logs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js">
</head>

<body>
    <div class="container mt-4">

        <hr>

        <!-- Action Counts Chart -->
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="chart-container" style="max-width: 100%; margin: 0 auto;">
                    <canvas id="actionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Prepare data for Action Counts chart
        const actionCounts = <?php echo json_encode($action_counts); ?>;
        const actionLabels = Object.keys(actionCounts);
        const actionData = Object.values(actionCounts);

        // Prepare data for User Activity chart
        const userActivity = <?php echo json_encode($user_activity); ?>;
        const userLabels = Object.keys(userActivity);
        const userData = Object.values(userActivity);

        // Create Action Counts Chart
        const actionCtx = document.getElementById('actionChart').getContext('2d');

        // Create a gradient color for the bars
        const gradient = actionCtx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(54, 162, 235, 0.8)'); // Light blue
        gradient.addColorStop(1, 'rgba(75, 192, 192, 0.8)'); // Light green

        new Chart(actionCtx, {
            type: 'bar',
            data: {
                labels: actionLabels,
                datasets: [{
                    label: 'Action Count',
                    data: actionData,
                    backgroundColor: gradient,
                    borderColor: 'rgba(54, 162, 235, 1)', // Border color for bars
                    borderWidth: 1,
                    hoverBackgroundColor: 'rgba(54, 162, 235, 0.6)', // Hover effect color
                    hoverBorderColor: 'rgba(54, 162, 235, 1)', // Hover border color
                    hoverBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        ticks: {
                            beginAtZero: true,
                            font: {
                                size: 14,
                                family: 'Arial, sans-serif',
                                weight: 'bold'
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 14,
                                family: 'Arial, sans-serif',
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Action Counts by Type',
                        font: {
                            size: 18,
                            family: 'Arial, sans-serif',
                            weight: 'bold'
                        },
                        color: '#333'
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' actions';
                            }
                        },
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleColor: 'white',
                        bodyColor: 'white',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2
                    }
                }
            }
        });
    </script>

</body>

</html>



