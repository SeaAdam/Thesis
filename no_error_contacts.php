<?php
include 'includes/dbconn.php';

// Query to fetch all rows
$sql = "SELECT ServiceProvider, MobileNo FROM contactus_table"; // Update table name and columns as needed
$result = $conn->query($sql);

// Fetch data into an array
$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

?>
