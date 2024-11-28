<?php
include 'includes/dbconn.php';

// Fetch logs from the database
$sql = "SELECT * FROM booking_logs ORDER BY timestamp DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Logs</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1>Booking Logs</h1>

<table border="1">
    <tr>
        <th>Timestamp</th>
        <th>Log Message</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['timestamp']) . "</td>
                    <td>" . htmlspecialchars($row['message']) . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='2'>No logs found.</td></tr>";
    }
    ?>

</table>

</body>
</html>

<?php
$conn->close();
?>
