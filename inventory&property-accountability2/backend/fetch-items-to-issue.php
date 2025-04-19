<?php
require 'connection.php'; // Ensure you have a connection file

$query = "SELECT ii.itemInstanceCode, i.itemName, i.description, i.quantity, i.dateAcquired, i.image
FROM item_instance ii
JOIN item i ON ii.itemNo = i.itemNo;
";
$result = mysqli_query($conn, $query);

$items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $items[] = $row;
}

echo json_encode($items);
?>
