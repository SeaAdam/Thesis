<?php
include 'includes/dbconn.php';

$actionCountsQuery = "SELECT action, COUNT(*) as count FROM action_logs GROUP BY action";
$actionCountsResult = $conn->query($actionCountsQuery);

$userActivityQuery = "SELECT user_id, COUNT(*) as count FROM action_logs GROUP BY user_id";
$userActivityResult = $conn->query($userActivityQuery);

$action_counts = array();
$user_activity = array();

while ($row = $actionCountsResult->fetch_assoc()) {
    $action_counts[$row['action']] = $row['count'];
}

while ($row = $userActivityResult->fetch_assoc()) {
    $user_activity[$row['user_id']] = $row['count'];
}
?>

<div class="right_col" role="main">

    <div class="row" style="display: inline-block;">
        <div class="tile_count">
            <div class="col-md-2 col-sm-4 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Total Patients</span>
                <div class="count"><?php echo $countPatient; ?></div>
                <span class="count_bottom"><i class="green"><i
                            class="fa fa-sort-asc"></i><?php echo round($percentPatient, 2); ?>% </i> Of 100</span>
            </div>
            <div class="col-md-2 col-sm-4 tile_stats_count">
                <span class="count_top"><i class="fa fa-line-chart"></i> Services</span>
                <div class="count"><?php echo $countServices; ?></div>
                <span class="count_bottom"><i class="green"><i
                            class="fa fa-sort-asc"></i><?php echo round($percentServices, 2); ?>% </i> Of 100</span>
            </div>
            <div class="col-md-2 col-sm-4 tile_stats_count">
                <span class="count_top"><i class="fa fa-calendar"></i> Patient Schedules</span>
                <div class="count"><?php echo $countSchedules; ?></div>
                <span class="count_bottom"><i class="red"><i
                            class="fa fa-sort-desc"></i><?php echo round($percentSchedules, 2); ?>% </i> Of 100</span>
            </div>
            <div class="col-md-2 col-sm-4 tile_stats_count">
                <span class="count_top"><i class="fa fa-users"></i> Admin Users</span>
                <div class="count"><?php echo $countAdmin; ?></div>
                <span class="count_bottom"><i class="green"><?php echo round($percentAdmin, 2); ?>% </i> Of 100</span>
            </div>
            <div class="col-md-2 col-sm-4 tile_stats_count">
                <span class="count_top"><i class="fa fa-ban"></i> Blocked Users</span>
                <div class="count"><?php echo $countBlocked; ?></div>
                <span class="count_bottom"><i class="red"><?php echo round($percentBlocked, 2); ?>% </i> Of 100</span>
            </div>
            <div class="col-md-2 col-sm-4 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i>Clients</span>
                <div class="count"><?php echo $countClients; ?></div>
                <span class="count_bottom"><i class="green"><?php echo round($percentClients, 2); ?>% </i> Of 100</span>
            </div>
            <div class="col-md-2 col-sm-4 tile_stats_count">
                <span class="count_top"><i class="fa fa-calendar-check"></i> Client Schedules</span>
                <div class="count"><?php echo $countClientSchedules; ?></div>
                <span class="count_bottom"><i class="red"><?php echo round($percentClientSchedules, 2); ?>% </i> Of
                    100</span>
            </div>
            <div class="col-md-2 col-sm-4 tile_stats_count">
                <span class="count_top"><i class="fa fa-calendar-plus-o"></i> Events</span>
                <div class="count"><?php echo $countEvents; ?></div>
                <span class="count_bottom"><i class="green"><?php echo round($percentEvents, 2); ?>% </i> Of 100</span>
            </div>
            <div class="col-md-2 col-sm-4 tile_stats_count">
                <span class="count_top"><i class="fa fa-gift"></i> Holidays</span>
                <div class="count"><?php echo $countHolidays; ?></div>
                <span class="count_bottom"><i class="green"><?php echo round($percentHolidays, 2); ?>% </i> Of
                    100</span>
            </div>
            <div class="col-md-2 col-sm-4 tile_stats_count">
                <span class="count_top"><i class="fa fa-users-slash"></i> Removed Clients</span>
                <div class="count"><?php echo $countRemovedClients; ?></div>
                <span class="count_bottom"><i class="red"><?php echo round($percentRemovedClients, 2); ?>% </i> Of
                    100</span>
            </div>
            <div class="col-md-2 col-sm-4 tile_stats_count">
                <span class="count_top"><i class="fa fa-star"></i> Reviews</span>
                <div class="count"><?php echo $countReviews; ?></div>
                <span class="count_bottom"><i class="green"><?php echo round($percentReviews, 2); ?>% </i> Of 100</span>
            </div>
        </div>
        <!-- Overview Button -->
        <button class="btn btn-info overview-btn">Overview</button>

        <!-- Overview Report (Initially Hidden) -->
        <div id="overviewReport" class="overview-card">
            <h4>📊 Overview Report</h4>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Total Patients</th>
                        <td><?php echo $countPatient; ?></td>
                    </tr>
                    <tr>
                        <th>Services Offered</th>
                        <td><?php echo $countServices; ?></td>
                    </tr>
                    <tr>
                        <th>Scheduled Appointments</th>
                        <td><?php echo $countSchedules; ?></td>
                    </tr>
                    <tr>
                        <th>Admin Users</th>
                        <td><?php echo $countAdmin; ?></td>
                    </tr>
                    <tr>
                        <th>Blocked Users</th>
                        <td><?php echo $countBlocked; ?></td>
                    </tr>
                    <tr>
                        <th>Clients</th>
                        <td><?php echo $countClients; ?></td>
                    </tr>
                    <tr>
                        <th>Client Schedules</th>
                        <td><?php echo $countClientSchedules; ?></td>
                    </tr>
                    <tr>
                        <th>Events</th>
                        <td><?php echo $countEvents; ?></td>
                    </tr>
                    <tr>
                        <th>Holidays</th>
                        <td><?php echo $countHolidays; ?></td>
                    </tr>
                    <tr>
                        <th>Removed Clients</th>
                        <td><?php echo $countRemovedClients; ?></td>
                    </tr>
                    <tr>
                        <th>Reviews</th>
                        <td><?php echo $countReviews; ?></td>
                    </tr>
                </tbody>
            </table>
            <p><b>Summary:</b> The system currently has <b><?php echo $countPatient; ?></b> total patients, with
                <b><?php echo $countServices; ?></b> active services.
                There are <b><?php echo $countSchedules; ?></b> scheduled appointments.
                <b><?php echo $countAdmin; ?></b> administrators are managing the system.
                <b><?php echo $countBlocked; ?></b> users are blocked, and <b><?php echo $countReviews; ?></b> reviews
                have been received.
            </p>
        </div>

    </div>
    <hr>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <?php include 'booking_logs_analytics.php'; ?>
        </div>
    </div>

    <hr>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="chart-container" style="max-width: 100%; margin: 0 auto;">
                <canvas id="actionChart"></canvas>
            </div>
        </div>
    </div>


    <hr>
    <div class="row">
        <?php include 'status.php'; ?>

        <?php include 'status_client.php'; ?>
    </div>


</div>













<script>
    const actionCounts = <?php echo json_encode($action_counts); ?>;
    const actionLabels = Object.keys(actionCounts);
    const actionData = Object.values(actionCounts);

    const userActivity = <?php echo json_encode($user_activity); ?>;
    const userLabels = Object.keys(userActivity);
    const userData = Object.values(userActivity);

    const actionCtx = document.getElementById('actionChart').getContext('2d');

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

    document.addEventListener("DOMContentLoaded", function () {
        let overviewBtn = document.querySelector(".overview-btn");
        let overviewCard = document.querySelector("#overviewReport");

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