<?php

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['image'])) {
    $image = $data['image'];

    // Clean the base64 string
    $image = str_replace('data:image/png;base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $decoded = base64_decode($image);

    // Save path (adjust if needed)
    $folderPath = '../images/custom_flowers/';
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0755, true); // Create folder if it doesn't exist
    }

    $fileName = 'custom_flower_' . time() . '.png';
    $filePath = $folderPath . $fileName;

    file_put_contents($filePath, $decoded);
    echo $fileName;
} else {
    http_response_code(400);
    echo "No image received.";
}