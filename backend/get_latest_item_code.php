<?php
include 'connection.php'; // Ensure you have a proper database connection

$year = date("Y"); // Get the current year

// Fetch the latest item code for the current year
$query = "SELECT itemInstanceCode FROM item_instance WHERE itemInstanceCode LIKE '$year-%' ORDER BY itemInstanceCode DESC LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $latestCode = $row['itemInstanceCode'];

    // Extract the last number and increment it
    preg_match('/-(\d+)$/', $latestCode, $matches);
    $nextNumber = isset($matches[1]) ? (int)$matches[1] + 1 : 1;
} else {
    $nextNumber = 1; // Start from 01 if no existing records for the year
}

// Format the new item code as YYYY-XX (padded with leading zeros)
$newCode = $year . '-' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

echo json_encode(["newCode" => $newCode]);

mysqli_close($conn); // Close the database connection
?>
