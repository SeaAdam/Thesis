<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Too Many Attempts</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 600px;
            margin-top: 50px;
            text-align: center;
        }

        .alert {
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="alert alert-danger">
            Too many failed attempts. You will be redirected to the home page.
        </div>
        <a href="index.php" class="btn btn-primary">Go Back to Home</a>
    </div>
</body>

</html>
