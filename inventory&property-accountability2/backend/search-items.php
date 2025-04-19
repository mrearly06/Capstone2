<?php
// Database connection (replace with your actual DB credentials)
include "connection.php";

// Check if the search query is passed
if (isset($_POST['query'])) {
    $search = $_POST['query'];

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT itemNo, itemCode, itemName FROM item WHERE itemCode LIKE ? OR itemName LIKE ? LIMIT 10");
    $likeSearch = "%$search%";
    $stmt->bind_param('ss', $likeSearch, $likeSearch);

    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any rows are returned
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Send the itemCode, itemName, and itemNo in JSON format
            echo '<a href="#" class="list-group-item list-group-item-action" data-itemno="' . htmlspecialchars($row['itemNo']) . '">';
            echo htmlspecialchars($row['itemCode']) . ' - ' . htmlspecialchars($row['itemName']);
            echo '</a>';
        }
    } else {
        echo '<p class="list-group-item list-group-item-action">No results found</p>';
    }

    $stmt->close();
}

$conn->close();
?>
