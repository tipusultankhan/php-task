<?php
// Enable error reporting for debugging (remove this in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load and validate config.json
$configFile = 'config.json';

if (!file_exists($configFile) || !is_readable($configFile)) {
    echo json_encode(["error" => "Config file missing or unreadable."]);
    exit;
}

$configData = file_get_contents($configFile);
$config = json_decode($configData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["error" => "Invalid JSON format in config.json"]);
    exit;

}

// Initialize response
$response = [];

// Check for request parameters and respond accordingly
if (isset($_GET['version'])) {
    $response['version'] = $config['version'] ?? "Unknown";
} elseif (isset($_GET['GET_APP_NAME'])) {
    $response['title'] = $config['title'] ?? "Unknown";
} elseif (isset($_GET['GET_SUPPORT'])) {
    $response['support'] = [
        "phone" => $config['phone'] ,
        "email" => $config['email'] ,
        "address" => $config['address'] ,
    ];
} else {
    
    $response = [
        "phone" => $config['phone'] ,
        "email" => $config['email'] ,
        "address" => $config['address'] ,
    ];
}

// Set header to JSON and return response
header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);
?>
