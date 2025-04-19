<?php
include 'connection.php'; // Make sure this file contains your DB connection details

if (isset($_POST['itemCode'])) {
    $itemCode = $_POST['itemCode'];

    // Check in 'item' table
    $query = "SELECT COUNT(*) FROM item WHERE itemCode = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $itemCode);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    // If found in 'item', return true
    if ($count > 0) {
        echo json_encode(['exists' => true]);
        exit;
    }

    // Check in 'item_review' table
    $query = "SELECT COUNT(*) FROM item_review WHERE itemReviewCode = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $itemCode);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    // If found in 'item_review', return true
    if ($count > 0) {
        echo json_encode(['exists' => true]);
        
    } else {
        echo json_encode(['exists' => false]);
    }
}
?>
