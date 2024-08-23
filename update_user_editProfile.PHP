<?php
include 'includes/dbconn.php';

if (isset($_POST['ID'])) {
    $id = $_POST['ID'];
    $firstName = $_POST['FirstName'];
    $mi = $_POST['MI'];
    $lastName = $_POST['LastName'];
    $gender = $_POST['Gender'];
    $dob = $_POST['DOB'];
    $age = $_POST['Age'];
    $contact = $_POST['Contact'];
    $address = $_POST['PresentAddress'];
    $username = $_POST['Username'];
    $password = $_POST['Password']; // You should hash passwords before storing them
    $confirmPassword = $_POST['ConfirmPassword'];

    // Simple password match check
    if ($password !== $confirmPassword) {
        echo json_encode(['error' => 'Passwords do not match']);
        exit();
    }

    $sql = "UPDATE registration_table SET
            FirstName = '$firstName',
            MI = '$mi',
            LastName = '$lastName',
            Gender = '$gender',
            DOB = '$dob',
            Age = '$age',
            Contact = '$contact',
            PresentAddress = '$address',
            Username = '$username',
            Password = '$password'
            WHERE ID = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => 'Record updated successfully']);
    } else {
        echo json_encode(['error' => 'Error updating record: ' . $conn->error]);
    }
} else {
    echo json_encode(['error' => 'ID not set']);
}
?>
