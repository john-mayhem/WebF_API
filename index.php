<?php
// Retrieve the last update time from a file or database
$lastUpdateTime = file_get_contents('last_update.txt');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Status Page</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #333; /* Dark background */
            color: white; /* Light text */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            transition: background-color 0.3s, color 0.3s;
        }
        .container {
            text-align: center;
            border-radius: 5px;
        }
        .status {
            font-size: 24px;
            color: #4CAF50; /* Green color */
            margin-bottom: 10px;
        }
        .last-update {
            font-size: 18px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <p class="status">Working</p>
        <p class="last-update">Last update: <?php echo $lastUpdateTime; ?></p>
    </div>

    <!-- Include your JavaScript file -->
    <script src="script.js"></script>
</body>
</html>
