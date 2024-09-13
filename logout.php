<?php
// Start the session
session_start();

// Destroy the session data
session_unset();
session_destroy();

// Redirect to the login page or homepage
header("Location: index.php");
exit();
?>