<?php
include 'includes/dbconn.php';
session_start();

if (!isset($_SESSION['username']) || $_SESSION['loginType'] !== 'admin') {
    die("Access Denied");
}

// Fetch all reviews
$sql = "SELECT name, profession, review, rating, created_at FROM reviews ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>User Reviews Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: #fff;
            font-family: Arial, sans-serif;
        }

        .report-container {
            max-width: 900px;
            margin: auto;
            padding: 30px;
            border: 2px solid #333;
            border-radius: 10px;
            background: #fff;
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }

        .header-container .logo {
            flex: 1;
            text-align: center;
        }

        .header-container .logo img {
            max-height: 80px;
        }

        .letterhead {
            text-align: center;
            flex: 2;
        }

        .letterhead h2,
        .letterhead h3 {
            margin: 0;
            font-weight: bold;
        }

        .letterhead h2 {
            font-size: 26px;
            text-transform: uppercase;
        }

        .letterhead h3 {
            font-size: 18px;
            color: #555;
        }

        .report-title {
            text-align: center;
            margin-bottom: 20px;
        }

        .report-title h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .table thead {
            background: #333;
            color: #fff;
        }

        .table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        .signature {
            margin-top: 50px;
            text-align: center;
            font-size: 16px;
        }

        .signature img {
            max-height: 70px;
            display: block;
            margin: 10px auto;
            /* Centers the signature image */
        }

        @media print {
            body {
                background: none;
            }

            .report-container {
                border: none;
                box-shadow: none;
            }

            .signature img {
                max-height: 60px;
            }
        }
    </style>
    <script>
        window.onload = function () {
            window.print();
        };
    </script>
</head>

<body>
    <div class="container mt-5">
        <div class="report-container">
            <div class="header-container">
                <div class="logo">
                    <img src="images/LOGO.png" alt="Company Logo">
                </div>
                <div class="letterhead">
                    <h2>BRAIN MASTER DIAGNOSTIC CENTER (BMDC)</h2>
                    <h3>APPOINTMENT SCHEDULING SYSTEM</h3>
                    <h3>USER REVIEWS REPORT</h3>
                </div>
                <div class="logo">
                    <img src="images/LOGO.png" alt="Company Logo">
                </div>
            </div>
            <div class="report-title">
                <h1>List of User Reviews</h1>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Profession</th>
                            <th>Review</th>
                            <th>Rating</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['profession']); ?></td>
                                <td><?php echo htmlspecialchars($row['review']); ?></td>
                                <td><?php echo htmlspecialchars($row['rating']); ?></td>
                                <td><?php echo htmlspecialchars(date("F d, Y", strtotime($row['created_at']))); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="signature">
                <p>Approved By:</p>
                <p><strong>Jhayson Fabrigar</strong></p>
                <p>Officer In Charge</p>
                <img src="images/jhay.png" alt="Signature">
            </div>
        </div>
    </div>
</body>

</html>
<?php
$conn->close();
?>