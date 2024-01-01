<?php
// Include the configuration variables
include 'config.php';

// Define the path to the input and output files
$inputFilePath = __DIR__ . '/output/output.json';
$formattedOutputFilePath = __DIR__ . '/output/formatted_output.txt';

// Function to format player data and save it to a formatted file
function formatPlayerData($inputFile, $outputFile) {
    // Read the JSON data from the file
    $jsonData = json_decode(file_get_contents($inputFile), true);

    // Check if the JSON data is an array and not empty
    if (is_array($jsonData) && !empty($jsonData)) {
        $formattedContent = "";

        // Loop through each entry in the JSON data
        foreach ($jsonData as $steamID => $details) {
            $mmr = isset($details['mmr']) ? $details['mmr'] : 'N/A';
            $plays = isset($details['plays']) ? $details['plays'] : 'N/A';
            $wins = isset($details['wins']) ? $details['wins'] : 'N/A';

            // Format the entry and append it to the formatted content
            $formattedContent .= "$steamID, $mmr, $plays, $wins\n";
        }

        // Save the formatted content to the output file
        file_put_contents($outputFile, $formattedContent);
        echo "Player data formatted and saved to $outputFile.\n";
    } else {
        echo "No valid JSON data to format.\n";
    }
}

// Call the function to execute the script
formatPlayerData($inputFilePath, $formattedOutputFilePath);
?>
