<?php
include "connection.php";

$startingValue = 1000; // Default starting value
$quantity = isset($_GET['quantity']) ? intval($_GET['quantity']) : 1; // Get the quantity from the query string

// Fetch existing item codes
$queryItem = "SELECT itemCode FROM item ORDER BY itemCode ASC";
$resultItem = $conn->query($queryItem);
$existingItemCodes = [];
while ($row = $resultItem->fetch_assoc()) {
    $existingItemCodes[] = (int)$row['itemCode'];
}

// Fetch existing review codes
$queryReview = "SELECT itemReviewCode FROM item_review ORDER BY itemReviewCode ASC";
$resultReview = $conn->query($queryReview);
$existingItemReviewCodes = [];
while ($row = $resultReview->fetch_assoc()) {
    $existingItemReviewCodes[] = (int)$row['itemReviewCode'];
}

$mergedCodes = array_unique(array_merge($existingItemCodes, $existingItemReviewCodes));
$newCodes = []; // Array to store new codes

while (count($newCodes) < $quantity) {
    if (!in_array($startingValue, $mergedCodes)) {
        $newCodes[] = $startingValue; // Add new code if it's unique
    }
    $startingValue++; // Increment to find the next code
}

$conn->close();

// Return the new item codes as JSON
echo json_encode($newCodes);
?>
