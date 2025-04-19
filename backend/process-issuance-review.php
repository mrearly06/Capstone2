<?php
// Include database connection
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the action (approve or reject)
    if (isset($_POST['approve'])) {
        // Sanitize the input to prevent SQL injection
        $issuanceReviewNo = $_POST['issuanceReviewNo'];

        // Prepare the query to get the data for the selected issuanceReviewNo
        $query = "
            SELECT 
                issuanceReviewNo, date, time, quantity, itemDescription, refNo, unitPrice, amount, 
                issuedBy, issuedByDate, receivedBy, receivedByDate, postedBy, postedByDate, status, department
            FROM issuance_review
            WHERE issuanceReviewNo = ?
        ";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $issuanceReviewNo);  // Binding the issuanceReviewNo parameter
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Loop through all rows returned in the result set
            while ($row = $result->fetch_assoc()) {
                // Insert the data into the issuance table for each row
                $insertQuery = "
                    INSERT INTO issuance (issuanceNo, date, time, quantity, itemDescription, refNo, unitPrice, amount, 
                        issuedBy, issuedByDate, receivedBy, receivedByDate, postedBy, postedByDate, status, department)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ";

                $insertStmt = $conn->prepare($insertQuery);
                $insertStmt->bind_param('ssssssssssssssss', 
                    $row['issuanceReviewNo'], $row['date'], $row['time'], $row['quantity'], $row['itemDescription'], 
                    $row['refNo'], $row['unitPrice'], $row['amount'], $row['issuedBy'], $row['issuedByDate'], 
                    $row['receivedBy'], $row['receivedByDate'], $row['postedBy'], $row['postedByDate'], 
                    $row['status'], $row['department']
                );
                
                if ($insertStmt->execute()) {
                    // If insertion is successful, proceed to update the status of the issuance table
                    $updateQuery = "UPDATE issuance SET status = 'Approved' WHERE issuanceNo = ?";
                    $updateStmt = $conn->prepare($updateQuery);
                    $updateStmt->bind_param('s', $row['issuanceReviewNo']);
                    
                    if ($updateStmt->execute()) {
                        // If the update is successful, update the status in the issuance_review table
                        $updateReviewQuery = "UPDATE issuance_review SET status = 'Approved' WHERE issuanceReviewNo = ?";
                        $updateReviewStmt = $conn->prepare($updateReviewQuery);
                        $updateReviewStmt->bind_param('s', $row['issuanceReviewNo']);
                        
                        if ($updateReviewStmt->execute()) {
                            // If both updates are successful, proceed to the next iteration or finish
                            continue;  // Proceed to the next row if there are more
                        } else {
                            echo "Error updating status in issuance_review table: " . $updateReviewStmt->error;
                            break;  // Exit loop on error
                        }
                    } else {
                        echo "Error updating status in issuance table: " . $updateStmt->error;
                        break;  // Exit loop on error
                    }
                } else {
                    echo "Error inserting data into the issuance table: " . $insertStmt->error;
                    break;  // Exit loop on error
                }
            }

            // After looping through all rows, redirect to the appropriate page
            header('Location: ../incoming-issuance-request.php');
            exit();

        } else {
            // Handle case if no data is found for the review number
            echo "Error: No review found with that Issuance Review No.";
        }

        $stmt->close();
    }

    // Handle reject logic if needed
    if (isset($_POST['reject'])) {
        // Reject logic (e.g., update the status to 'Rejected' in the issuance table)
        $issuanceReviewNo = $_POST['issuanceReviewNo'];
        
        // Update the status in the issuance table
        $rejectQuery = "UPDATE issuance SET status = 'Rejected' WHERE issuanceNo = ?";
        $rejectStmt = $conn->prepare($rejectQuery);
        $rejectStmt->bind_param('s', $issuanceReviewNo);
        
        if ($rejectStmt->execute()) {
            // Successfully updated, now update the status in the issuance_review table
            $rejectReviewQuery = "UPDATE issuance_review SET status = 'Rejected' WHERE issuanceReviewNo = ?";
            $rejectReviewStmt = $conn->prepare($rejectReviewQuery);
            $rejectReviewStmt->bind_param('s', $issuanceReviewNo);
            
            if ($rejectReviewStmt->execute()) {
                // Redirect after successful rejection
                header('Location: ../incoming-issuance-request.php');
                exit();
            } else {
                echo "Error updating status in issuance_review table: " . $rejectReviewStmt->error;
            }
        } else {
            echo "Error updating status in issuance table: " . $rejectStmt->error;  // Output any errors from the query
        }
    }
}

// Close connection
$conn->close();
?>
