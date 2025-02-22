<?php
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seasonal Report Client</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.71/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.71/vfs_fonts.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
<body>
    <div class="container mt-4">
        <h3 class="mb-3">📊 Seasonal Booking Report</h3>

        <!-- Year Selection -->
        <label for="yearSelect">Select Year:</label>
        <select id="yearSelect" class="form-select w-25">
            <?php foreach ($years as $year) : ?>
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
                        <tr><th>Q1 (Jan - Mar):</th> <td id="q1Count">-</td></tr>
                        <tr><th>Q2 (Apr - Jun):</th> <td id="q2Count">-</td></tr>
                        <tr><th>Q3 (Jul - Sep):</th> <td id="q3Count">-</td></tr>
                        <tr><th>Q4 (Oct - Dec):</th> <td id="q4Count">-</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Export Buttons -->
        <button id="exportCSV" class="btn btn-success mt-2">Export CSV</button>
        <button id="exportPDF" class="btn btn-danger mt-2">Export PDF</button>
    </div>

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

            // Export to PDF
            document.getElementById("exportPDF").addEventListener("click", function () {
                const docDefinition = {
                    content: [
                        { text: "Seasonal Booking Report", style: "header" },
                        { text: `Q1: ${q1Count.textContent} Bookings\nQ2: ${q2Count.textContent} Bookings\nQ3: ${q3Count.textContent} Bookings\nQ4: ${q4Count.textContent} Bookings` }
                    ]
                };
                pdfMake.createPdf(docDefinition).download("seasonal_report.pdf");
            });
        });
    </script>
</body>
</html>
