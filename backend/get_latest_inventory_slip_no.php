<?php
include 'connection.php'; // Adjust path if needed

$query = "SELECT MAX(itemInventorySlipNo) AS latestSlipNo FROM item";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $latestSlipNo = $row['latestSlipNo'] ? intval($row['latestSlipNo']) + 1 : 1; 
} else {
    $latestSlipNo = 1;
}

$formattedSlipNo = str_pad($latestSlipNo, 2, '0', STR_PAD_LEFT);

echo json_encode(['success' => true, 'latestSlipNo' => $formattedSlipNo]);
?>
