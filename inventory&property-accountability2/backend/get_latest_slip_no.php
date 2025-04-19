<?php
include "connection.php"; // Ensure this file sets up a valid DB connection

header('Content-Type: application/json'); // Return a JSON response

$sql = "SELECT MAX(issuanceReviewNo) AS latestReviewNo FROM issuance_review";
$result = $conn->query($sql);

if ($result) {
    if ($row = $result->fetch_assoc()) {
        // Extract the max slip number or start with 1
        $latestReviewNo = $row['latestReviewNo'] ? intval($row['latestReviewNo']) : 0;
        $nextReviewNo = $latestReviewNo + 1;

        // Return as JSON
        echo json_encode(['success' => true, 'latestReviewNo' => $nextReviewNo]);
    } else {
        // No rows, default to 1
        echo json_encode(['success' => true, 'latestReviewNo' => 1]);
    }
} else {
    // Handle SQL errors
    echo json_encode(['success' => false, 'message' => "Database query error: " . $conn->error]);
}

$conn->close();
?>
