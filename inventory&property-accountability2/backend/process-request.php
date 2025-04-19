<?php
session_start(); // Start the session at the top of your PHP file
include 'connection.php'; // Make sure to adjust the path if necessary

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inventoryReqID = $_POST['inventoryReqID'];
    
    if (isset($_POST['approve'])) {
        // Start a transaction
        $conn->begin_transaction();
        try {
            // Update the request status
            $updateQuery = "UPDATE inventory_request SET requestStatus = 'Approved' WHERE inventoryReqID = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("s", $inventoryReqID);
            if (!$stmt->execute()) {
                throw new Exception("Error updating inventory request: " . $stmt->error);
            }
            $stmt->close();
            
            // Fetch necessary details from the item_review
            $detailsQuery = "SELECT * FROM item_review WHERE inventoryReqID = ?";
            $stmt = $conn->prepare($detailsQuery);
            $stmt->bind_param("s", $inventoryReqID);
            if (!$stmt->execute()) {
                throw new Exception("Error fetching item review: " . $stmt->error);
            }
            $result = $stmt->get_result();
            $itemReview = $result->fetch_assoc();

            // Debugging: Print itemReview array
            echo '<pre>';
            print_r($itemReview); // This will output the itemReview array to the screen
            echo '</pre>';
            
            // Check if item review data exists
            if ($itemReview) {
                echo "Item Review Data Exists"; // Debugging check
                
                // Get the maximum existing itemNo to calculate the next one
                $itemNoQuery = "SELECT MAX(itemNo) AS maxItemNo FROM item";
                $result = $conn->query($itemNoQuery);
                $nextItemNo = 1; // Default value if no items exist
                if ($result) {
                    $row = $result->fetch_assoc();
                    $nextItemNo = ($row['maxItemNo'] !== null) ? $row['maxItemNo'] + 1 : 1; // Increment maxItemNo
                }

                // Ensure the itemReviewNo exists in item_review
                $itemReviewNo = $itemReview['itemReviewNo'];
                $checkReviewQuery = "SELECT COUNT(*) AS count FROM item_review WHERE itemReviewNo = ?";
                $stmt = $conn->prepare($checkReviewQuery);
                $stmt->bind_param("s", $itemReviewNo);
                $stmt->execute();
                $countResult = $stmt->get_result();
                $countRow = $countResult->fetch_assoc();

                if ($countRow['count'] > 0) {
                    // Insert into item table
                    $insertQuery = "INSERT INTO item (
                                        itemNo,itemCode, itemName, description, quantity, 
                                        dateAcquired, unitValue, totalValue, image, category, 
                                        loggedAt, loggedBy, itemReviewNo
                                    ) VALUES (
                                        ?, ?, ?, ?, ?, 
                                        ?, ?, ?, ?, ?, 
                                        ?, ?, ?
                                    )";
                    $stmt = $conn->prepare($insertQuery);
                    $stmt->bind_param(
                        "isssssssssssi", 
                        $nextItemNo, // Use the calculated next item number
                        $itemReview['itemReviewCode'],
                        $itemReview['itemReviewName'], 
                        $itemReview['description'], 
                        $itemReview['quantity'], 
                        $itemReview['dateAcquired'], 
                        $itemReview['unitValue'], 
                        $itemReview['totalValue'], 
                        $itemReview['image'], 
                        $itemReview['category'], 
                        $itemReview['loggedAt'], 
                        $itemReview['loggedBy'],
                        $itemReviewNo // Foreign key reference
                    );

                    if (!$stmt->execute()) {
                        throw new Exception("Error inserting item: " . $stmt->error);
                    }
                    $stmt->close();
                } else {
                    echo "The itemReviewNo does not exist in the item_review table.";
                }
            } else {
                echo "No item review data found for the given inventoryReqID.";
            }
            
            // Commit transaction
            $conn->commit();
             // Redirect to incoming inventory request page
         
            
                // On successful insert, set the session variable
                $_SESSION['alert'] = 'success'; // or 'rejected' based on the case
                header("Location: ../incoming-inventory-request.php");
          
                   
            
        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }
        
    } elseif (isset($_POST['reject'])) {
        // Update the request status
        $updateQuery = "UPDATE inventory_request SET requestStatus = 'Rejected' WHERE inventoryReqID = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("s", $inventoryReqID);
        $stmt->execute();
        $stmt->close();
    }
    
    $conn->close();
    
    exit();
}
?>
