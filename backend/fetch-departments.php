<?php
// Database connection parameters
include "connection.php";

// Get the query parameter from the URL
$query = isset($_GET['query']) ? $conn->real_escape_string($_GET['query']) : '';

// Prepare the SQL statement to fetch departments
$sql = "SELECT departmentID, departmentName FROM department WHERE 
        departmentName LIKE '%$query%' OR departmentID LIKE '%$query%' LIMIT 10";

// Execute the query
$result = $conn->query($sql);

// Initialize an array to hold the departments
$departments = [];

// Fetch results
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $departments[] = $row;
    }
}

// Return results as JSON
header('Content-Type: application/json');
echo json_encode($departments);

// Close the connection
$conn->close();
?>
