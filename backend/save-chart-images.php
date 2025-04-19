<?php

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['assetsChart']) && isset($data['costChart'])) {
    $assetsChart = $data['assetsChart'];
    $costChart = $data['costChart'];

    // Decode base64 and save the images
    $assetsPath = '../charts/assets_chart.png';
    $costPath = '../charts/cost_chart.png';

    file_put_contents($assetsPath, base64_decode(explode(',', $assetsChart)[1]));
    file_put_contents($costPath, base64_decode(explode(',', $costChart)[1]));

    echo json_encode(['message' => 'Charts saved successfully']);
} else {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid chart data']);
}
?>
