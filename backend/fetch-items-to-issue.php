<?php
require 'connection.php'; // Ensure you have a connection file

$query = "SELECT 
            ii.itemInstanceID, 
            ii.itemInstanceCode, 
            i.itemNo, 
            i.itemName, 
            i.description, 
            i.unitValue, 
            i.totalValue,
            i.dateAcquired, 
            i.image
          FROM item_instance ii
          JOIN item i ON ii.itemNo = i.itemNo
          ORDER BY i.itemNo";

$result = mysqli_query($conn, $query);

$items = [];

while ($row = mysqli_fetch_assoc($result)) {
    $row['quantity'] = 1; // Set quantity to 1
    $row['totalValue'] = $row['unitValue'] * $row['quantity']; // Recalculate totalValue
    $items[] = $row;
}

echo json_encode($items);
?>

