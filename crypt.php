<?php
// Include the configuration variables
include 'config.php';

// Define the path to the input and output files
$winrateLeaderboardFilePath = __DIR__ . '/output/leaderboard_winrate.txt';
$mmrLeaderboardFilePath = __DIR__ . '/output/leaderboard_mmr.txt';
$winrateOutputFilePath = __DIR__ . '/output/encoded_leaderboard_wr.txt';
$mmrOutputFilePath = __DIR__ . '/output/encoded_leaderboard_mmr.txt';

// Function to encode and save leaderboard data
function encodeAndSaveData($inputFile, $outputFile) {
    // Read the leaderboard data from the file
    $leaderboardData = file_get_contents($inputFile);

    // Check if data exists
    if ($leaderboardData) {
        // Encode the leaderboard data using base64
        $encodedData = base64_encode($leaderboardData);

        // Save the encoded data to a file
        file_put_contents($outputFile, $encodedData);
        echo "Leaderboard encoded successfully and saved to $outputFile.\n";
    } else {
        echo "No players found matching the criteria for the leaderboard. Skipping encoding and saving.\n";
    }
}

// Encode and save the winrate leaderboard
encodeAndSaveData($winrateLeaderboardFilePath, $winrateOutputFilePath);

// Encode and save the MMR leaderboard
encodeAndSaveData($mmrLeaderboardFilePath, $mmrOutputFilePath);
?>
