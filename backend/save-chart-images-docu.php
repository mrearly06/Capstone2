<?php
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $assetsChart = $data['assetsChart'];
    $costChart = $data['costChart'];

    // Save the images to the server
    file_put_contents('assets_chart.png', base64_decode(str_replace('data:image/png;base64,', '', $assetsChart)));
    file_put_contents('cost_chart.png', base64_decode(str_replace('data:image/png;base64,', '', $costChart)));

    echo json_encode(['status' => 'success']);
    exit;
}
?>
