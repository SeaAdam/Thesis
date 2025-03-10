<?php
include 'login.php';

if (!isset($_SESSION['username']) || $_SESSION['loginType'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$adminUsername = $_SESSION['username'];

include 'notification_functions.php';
$notificationsAdmin = fetchNotificationsAdmin();
$unread_count = countUnreadNotificationsAdmin();

include 'includes/dbconn.php';

// Fetch available years from the database
$yearQuery = "SELECT DISTINCT YEAR(date_appointment) AS year FROM client_booking ORDER BY year DESC";
$yearResult = $conn->query($yearQuery);
$years = [];
while ($row = $yearResult->fetch_assoc()) {
    $years[] = $row['year'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Seasonal Reports</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.71/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.71/vfs_fonts.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="build/css/custom.min.css" rel="stylesheet">
    <style>
        #chartContainer {
            display: none;
            flex-direction: row;
            align-items: center;
            gap: 20px;
        }

        .summary-table {
            width: 300px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 10px;
            background: #f8f9fa;
        }

        canvas {
            max-width: 400px;
            max-height: 300px;
        }
    </style>
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">

            <!-- Sidebar -->
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="adminDashboard.php" class="site_title"><i class="fa fa-plus-square"></i> <span>Brain
                                Master DC</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="images/admin-icon.jpg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2><?php echo htmlspecialchars($adminUsername); ?></h2>
                        </div>
                    </div>

                    <br />
                    <?php include('sidebar.php'); ?>
                </div>
            </div>

            <!-- Top Navigation -->
            <?php include 'top_nav_admin.php'; ?>

            <div class="right_col" role="main">
                <div class="container mt-4">
                    <h3 class="mb-3">📊 Seasonal Booking Report</h3>

                    <!-- Year Selection -->
                    <label for="yearSelect">Select Year:</label>
                    <select id="yearSelect" class="form-select w-25">
                        <?php foreach ($years as $year): ?>
                            <option value="<?= $year; ?>"><?= $year; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <button id="toggleCharts" class="btn btn-primary mt-2">View Report</button>

                    <div id="chartContainer" class="mt-4">
                        <!-- Chart -->
                        <canvas id="seasonalChart"></canvas>

                        <!-- Summary Table -->
                        <div class="summary-table">
                            <h5>📋 Summary</h5>
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>Q1 (Jan - Mar):</th>
                                        <td id="q1Count">-</td>
                                    </tr>
                                    <tr>
                                        <th>Q2 (Apr - Jun):</th>
                                        <td id="q2Count">-</td>
                                    </tr>
                                    <tr>
                                        <th>Q3 (Jul - Sep):</th>
                                        <td id="q3Count">-</td>
                                    </tr>
                                    <tr>
                                        <th>Q4 (Oct - Dec):</th>
                                        <td id="q4Count">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Export Buttons -->
                    <button id="exportCSV" class="btn btn-success mt-2">Export CSV</button>
                    <button id="exportPDF" class="btn btn-danger mt-2">Export PDF</button>
                </div>
            </div>
        </div>
    </div>

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const chartContainer = document.getElementById("chartContainer");
            const toggleButton = document.getElementById("toggleCharts");
            let seasonalChart;

            toggleButton.addEventListener("click", function () {
                chartContainer.style.display = "flex";

                const selectedYear = document.getElementById("yearSelect").value;

                fetch(`fetch_seasonal_reports.php?year=${selectedYear}`)
                    .then(response => response.json())
                    .then(data => {
                        if (seasonalChart) {
                            seasonalChart.destroy();
                        }

                        const ctx = document.getElementById("seasonalChart").getContext("2d");
                        seasonalChart = new Chart(ctx, {
                            type: "bar",
                            data: {
                                labels: ["Q1 (Jan-Mar)", "Q2 (Apr-Jun)", "Q3 (Jul-Sep)", "Q4 (Oct-Dec)"],
                                datasets: [{
                                    label: "Bookings",
                                    data: [data.Q1, data.Q2, data.Q3, data.Q4],
                                    backgroundColor: ["rgba(255, 99, 132, 0.5)", "rgba(54, 162, 235, 0.5)",
                                        "rgba(255, 206, 86, 0.5)", "rgba(75, 192, 192, 0.5)"],
                                    borderWidth: 1
                                }]
                            }
                        });

                        // Update Summary Table
                        document.getElementById("q1Count").textContent = data.Q1;
                        document.getElementById("q2Count").textContent = data.Q2;
                        document.getElementById("q3Count").textContent = data.Q3;
                        document.getElementById("q4Count").textContent = data.Q4;
                    })
                    .catch(error => console.error("Error fetching data:", error));
            });

            // Export to CSV
            document.getElementById("exportCSV").addEventListener("click", function () {
                const csvContent = `Quarter,Bookings\nQ1,${q1Count.textContent}\nQ2,${q2Count.textContent}\nQ3,${q3Count.textContent}\nQ4,${q4Count.textContent}`;
                const blob = new Blob([csvContent], { type: "text/csv" });
                const link = document.createElement("a");
                link.href = URL.createObjectURL(blob);
                link.download = "seasonal_report.csv";
                link.click();
            });

            document.getElementById("exportPDF").addEventListener("click", function () {
                const canvas = document.getElementById("seasonalChart");
                const chartImage = canvas.toDataURL("image/png"); // Convert chart to Base64 image

                const docDefinition = {
                    content: [
                        { text: "📊 Seasonal Booking Report", style: "header", alignment: "center" },
                        { image: chartImage, width: 500 }, // Add chart image
                        { text: "📋 Summary", style: "subheader", margin: [0, 10, 0, 5] },
                        {
                            table: {
                                widths: ["50%", "50%"],
                                body: [
                                    ["Q1 (Jan - Mar):", document.getElementById("q1Count").textContent],
                                    ["Q2 (Apr - Jun):", document.getElementById("q2Count").textContent],
                                    ["Q3 (Jul - Sep):", document.getElementById("q3Count").textContent],
                                    ["Q4 (Oct - Dec):", document.getElementById("q4Count").textContent],
                                ]
                            },
                            layout: "lightHorizontalLines" // Adds light lines for better readability
                        }
                    ],
                    styles: {
                        header: { fontSize: 18, bold: true },
                        subheader: { fontSize: 14, bold: true }
                    }
                };

                pdfMake.createPdf(docDefinition).download("seasonal_report.pdf");
            });

        });
    </script>
</body>

</html>