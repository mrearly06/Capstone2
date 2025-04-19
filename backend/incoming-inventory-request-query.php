<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connection.php';

if (isset($_POST['requestID'])) {
    $requestID = $_POST['requestID'];

    // Fetch item review data (excluding itemizedAt)
    $sql = "
    SELECT irw.item_reviewID, irw.itemName, irw.quantity, irw.description, irw.dateAcquired,
           irw.unitValue, irw.totalValue, irw.category, irw.status, irw.itemImage, irw.itemizedBy
    FROM item_review irw
    INNER JOIN inventory_request ir ON ir.item_reviewID = irw.item_reviewID
    WHERE ir.inventory_reqID = ?";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Error in preparing statement: " . $conn->error;
        exit;
    }

    $stmt->bind_param("i", $requestID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();

        // Get current timestamp for itemizedAt
        $itemizedAt = date("Y-m-d H:i:s");

        // Insert into item table (including itemizedAt as the current timestamp)
        $insert_sql = "
        INSERT INTO item (itemID, itemName, quantity, description, dateAcquired, unitValue, totalValue, category, status, itemImage, itemizedAt, itemizedBy)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $insert_stmt = $conn->prepare($insert_sql);
        if (!$insert_stmt) {
            echo "Error in preparing insert statement: " . $conn->error;
            exit;
        }

        $insert_stmt->bind_param("ssssssssssss", $item['itemID'], $item['itemName'], $item['quantity'], $item['description'], 
                                 $item['dateAcquired'], $item['unitValue'], $item['totalValue'], $item['category'], 
                                 $item['status'], $item['itemImage'], $itemizedAt, $item['itemizedBy']);
        
        if ($insert_stmt->execute()) {
            // Update requestStatus in inventory_request to "Approved"
            $update_sql = "UPDATE inventory_request SET requestStatus = 'Approved' WHERE inventory_reqID = ?";
            $update_stmt = $conn->prepare($update_sql);
            if (!$update_stmt) {
                echo "Error in preparing update statement: " . $conn->error;
                exit;
            }

            $update_stmt->bind_param("i", $requestID);
            if ($update_stmt->execute()) {
                echo "success";
            } else {
                echo "Error updating request status: " . $update_stmt->error;
            }
        } else {
            echo "Error inserting into item table: " . $insert_stmt->error;
        }
    } else {
        echo "Error fetching item review data: No rows found";
    }

    $stmt->close();
    $conn->close();
}
?>
