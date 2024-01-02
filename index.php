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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <p class="status">Working</p>
        <p class="last-update">Last update: <?php echo $lastUpdateTime; ?></p>
    </div>

    <!-- Include your JavaScript file -->
    <script src="script.js"></script>

    <script>
        // Check if the JavaScript is executing the scripts
        // If not, trigger the script.js
        var scriptExecutionStatus = false; // Set to false initially

        // Function to check if script.js is executing
        function checkScriptExecution() {
            // You can use an AJAX request to a PHP script that checks if script.js is running
            // For simplicity, we'll use a variable for demonstration purposes
            // You should replace this with an actual check using AJAX

            // Simulated check
            scriptExecutionStatus = true; // Set to true to simulate script.js running

            if (!scriptExecutionStatus) {
                // If script.js is not running, trigger it
                var script = document.createElement('script');
                script.src = 'script.js';
                document.body.appendChild(script);
            }
        }

        // Call the function initially
        checkScriptExecution();

        // Schedule the function to run every hour (in milliseconds)
        setInterval(checkScriptExecution, 3600000); // 3600000 milliseconds = 1 hour
    </script>
</body>
</html>
