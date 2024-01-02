<?php
// Include the configuration variables
include 'config.php';  // Ensure the path to your config.php is correct

// Define the output path
$outputFilePath = __DIR__ . '/output/output.json';

// Construct the package location URL
$packageLocation = $SERVER_LOCATION . $AUTH_KEY . "/players.json";
// echo "Debug: Package location URL - " . $packageLocation . "\n";  // Commented out for production

// Function to fetch player data and save it to a file
function fetchPlayerData($url, $outputFile) {
    // Initialize a cURL session
    $curl = curl_init();

    // Set cURL options
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    // Disable SSL certificate verification
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

    // echo "Debug: Fetching data from URL...\n";  // Commented out for production

    // Execute the cURL session and capture the response
    $response = curl_exec($curl);

    if ($response === false) {
        // If cURL failed to execute
        echo "Error: cURL error - " . curl_error($curl) . "\n";  // Changed to Error for production
    }

    // Close the cURL session
    curl_close($curl);

    // Attempt to decode the response
    $decodedResponse = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        // If the response wasn't valid JSON
        echo "Error: JSON decode error - " . json_last_error_msg() . "\n";  // Changed to Error for production
    }

    // Convert the decoded response to a formatted JSON string
    $formattedJson = json_encode($decodedResponse, JSON_PRETTY_PRINT);

    if ($formattedJson === false) {
        // If json_encode failed
        echo "Error: JSON encode error - " . json_last_error_msg() . "\n";  // Changed to Error for production
    } else {
        // Save the formatted JSON to a file
        if (!file_put_contents($outputFile, $formattedJson)) {
            echo "Error: Failed to save data to file.\n";  // Changed to Error for production
        }
    }
}

// Call the function to execute the script
fetchPlayerData($packageLocation, $outputFilePath);
?>
