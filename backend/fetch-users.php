<?php

include "connection.php";

// Check if query parameter is set
if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // Prepare the SQL query to fetch users based on user ID or name
    if (is_numeric($query)) {
        // Search by user ID
        $sql = "SELECT userID, firstName, middleName, lastName FROM user WHERE userID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $query);
    } else {
        // Search by name (allow partial matching)
        $sql = "SELECT userID, firstName, middleName, lastName FROM user 
                WHERE CONCAT(firstName, ' ', middleName, ' ', lastName) LIKE ?";
        $query = '%' . $query . '%';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $query);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch results and return as JSON
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

   // Set the header to JSON
header('Content-Type: application/json');

// Return the JSON response
echo json_encode($users);

    $stmt->close();
}

$conn->close();
?>
