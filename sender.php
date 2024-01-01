<?php
// Include the configuration variables
include 'config.php';

// Define the path to the encrypted leaderboard files
$mmrOutputFilePath = __DIR__ . '/output/encoded_leaderboard_mmr.txt';
$winrateOutputFilePath = __DIR__ . '/output/encoded_leaderboard_wr.txt';

// GitHub API URL
$apiUrlBase = "https://api.github.com/repos/$owner/$repo/contents/$folderPath/";

// Headers for the GitHub API request
$headers = [
    "Authorization: Bearer $token",
    "Content-Type: application/json",
    "User-Agent: PHP-Script"  // GitHub requires a user-agent header
];

function uploadToGitHub($filePath, $apiUrl, $headers, $branch) {
    echo "Starting upload for: " . basename($filePath) . "\n";
    $fileContent = file_get_contents($filePath);
    if ($fileContent) {
        echo "File content loaded successfully.\n";
        $encodedContent = base64_encode($fileContent);
        $commitMessage = "Update leaderboard file";

        // Get the SHA of the existing file if it exists
        $existingFileCommand = "curl -H '" . implode("' -H '", $headers) . "' $apiUrl";
        $existingFile = json_decode(shell_exec($existingFileCommand), true);
        $sha = $existingFile['sha'] ?? '';  // Get the SHA if it exists

        $data = json_encode([
            "message" => $commitMessage,
            "content" => $encodedContent,
            "branch" => $branch,
            "sha" => $sha
        ]);

        $curlCommand = "curl -i -X PUT -d " . escapeshellarg($data) . " -H '" . implode("' -H '", $headers) . "' $apiUrl";
        $response = shell_exec($curlCommand);
        echo "Response received: " . $response . "\n";
    } else {
        echo "File content not found for " . basename($filePath) . ". Skipping upload.\n";
    }
}

// Upload the MMR and Win Rate leaderboards to GitHub
uploadToGitHub($mmrOutputFilePath, $apiUrlBase . "lb_1.txt", $headers, $branch);
uploadToGitHub($winrateOutputFilePath, $apiUrlBase . "lb_2.txt", $headers, $branch);
?>
