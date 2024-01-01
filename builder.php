<?php
// Include the configuration variables
include 'config.php';

// Define the path to the input and output files
$inputFilePath = __DIR__ . '/output/formatted_output.txt';
$mmrLeaderboardFilePath = __DIR__ . '/output/leaderboard_mmr.txt';  // Changed to .txt
$winrateLeaderboardFilePath = __DIR__ . '/output/leaderboard_winrate.txt';  // Changed to .txt

// Read the player data from the input file
$playerDataLines = file($inputFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$playerData = [];

foreach ($playerDataLines as $line) {
    list($steamID, $mmr, $plays, $wins) = explode(', ', $line);
    $playerData[] = [
        'SteamID' => $steamID,
        'MMR' => (int)$mmr,
        'Plays' => (int)$plays,
        'Wins' => (int)$wins
    ];
}

function buildLeaderboard($playerData, $criteria, $sortFunction, $limit = 100) {
    // Filter and sort players based on the criteria
    $validPlayers = array_filter($playerData, $criteria);
    usort($validPlayers, $sortFunction);
    return array_slice($validPlayers, 0, $limit);
}

// Define criteria and sort function for MMR and Win Rate leaderboards
$criteriaMMR = function ($player) {
    return $player['SteamID'] !== "0" && $player['MMR'] >= 5240 && $player['Plays'] > 0 && $player['Wins'] > 0;
};
$sortMMR = function ($a, $b) {
    return $b['MMR'] <=> $a['MMR'];
};

$criteriaWinRate = function ($player) {
    return $player['SteamID'] !== "0" && $player['MMR'] > 0 && $player['Plays'] > 50 && $player['Wins'] > 0;
};
$sortWinRate = function ($a, $b) {
    $winRateA = $a['Wins'] / $a['Plays'];
    $winRateB = $b['Wins'] / $b['Plays'];
    return $winRateB <=> $winRateA;
};

// Build leaderboards
$mmrLeaderboard = buildLeaderboard($playerData, $criteriaMMR, $sortMMR);
$winrateLeaderboard = buildLeaderboard($playerData, $criteriaWinRate, $sortWinRate);

// Function to save leaderboard to file
function saveLeaderboardToFile($leaderboard, $filePath) {
    $content = "";
    foreach ($leaderboard as $player) {
        $content .= implode(', ', [$player['SteamID'], $player['MMR'], $player['Plays'], $player['Wins']]) . "\n";
    }
    file_put_contents($filePath, $content);
    echo "Leaderboard saved to $filePath.\n";
}

// Save the MMR and Win Rate leaderboards to file
saveLeaderboardToFile($mmrLeaderboard, $mmrLeaderboardFilePath);
saveLeaderboardToFile($winrateLeaderboard, $winrateLeaderboardFilePath);
?>
