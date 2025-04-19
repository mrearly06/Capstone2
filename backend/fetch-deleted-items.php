<?php
include 'connection.php'; // Your database connection file

header('Content-Type: application/json');

$query = "SELECT itemInstanceCode FROM items"; // Adjust query as needed
$result = $conn->query($query);

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row['itemInstanceCode'];
}

echo json_encode($items);
?>
