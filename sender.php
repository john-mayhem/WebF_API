<?php
// Include the configuration variables
include 'config.php';

// Define the path to the encrypted leaderboard files
$mmrOutputFilePath = __DIR__ . '/output/encoded_leaderboard_mmr.txt';
$winrateOutputFilePath = __DIR__ . '/output/encoded_leaderboard_wr.txt';

// GitHub API URL
$apiUrlBase = "https://api.github.com/repos/$owner/$repo/contents/$folderPath";

// Headers for the GitHub API request
$headers = [
    "Authorization: Bearer $token",
    "Content-Type: application/json",
    "User-Agent: PHP-Script"  // GitHub requires a user-agent header
];

function uploadToGitHub($filePath, $apiFileName, $headers, $branch) {
    $fileContent = file_get_contents($filePath);
    if ($fileContent) {
        $encodedContent = base64_encode($fileContent);
        $commitMessage = "Leaderboard data update";
        
        $apiFileName = ltrim($apiFileName, '/');
        $apiUrl = $GLOBALS['apiUrlBase'] . '/' . $apiFileName;

        // Initialize cURL session to get the SHA of the existing file
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // only for testing, not recommended for production

        $existingFile = json_decode(curl_exec($ch), true);
        $sha = $existingFile['sha'] ?? '';  // Get the SHA if it exists
        curl_close($ch);

        $data = json_encode([
            "message" => $commitMessage,
            "content" => $encodedContent,
            "branch" => $branch,
            "sha" => $sha
        ]);

        // Initiate cURL session for the PUT request to update the file
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // only for testing, not recommended for production

        $response = curl_exec($ch);
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($httpStatusCode == 200){
            echo "Upload successful for: " . basename($filePath) . "\n";
        } else {
            echo "Upload failed for: " . basename($filePath) . ". Status Code: $httpStatusCode\n";
        }
    } else {
        echo "File content not found for " . basename($filePath) . ". Skipping upload.\n";
    }
}

// Upload the MMR and Win Rate leaderboards to GitHub
uploadToGitHub($mmrOutputFilePath, "lb_1.txt", $headers, $branch);
uploadToGitHub($winrateOutputFilePath, "lb_2.txt", $headers, $branch);
?>
