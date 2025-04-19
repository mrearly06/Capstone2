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
            // Fetch the row from the result
            $row = $result->fetch_assoc();

            // Insert the data into the issuance table
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
            $insertStmt->execute();
            
            // Optionally, update the status of the review to 'Approved' or 'Completed'
            $updateQuery = "UPDATE issuance_review SET status = 'Approved' WHERE issuanceReviewNo = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param('s', $issuanceReviewNo);
            $updateStmt->execute();

            // Redirect or provide feedback
            header('Location: incoming-issuance-request.php'); // Redirect to a relevant page after approval
            exit();
        } else {
            // Handle case if no data is found for the review number
            echo "Error: No review found with that Issuance Review No.";
        }

        $stmt->close();
    }

    // Handle reject logic if needed
    if (isset($_POST['reject'])) {
        // Reject logic (e.g., update the status to 'Rejected' in the issuance_review table)
        $issuanceReviewNo = $_POST['issuanceReviewNo'];
        $rejectQuery = "UPDATE issuance_review SET status = 'Rejected' WHERE issuanceReviewNo = ?";
        $rejectStmt = $conn->prepare($rejectQuery);
        $rejectStmt->bind_param('s', $issuanceReviewNo);
        $rejectStmt->execute();

        // Redirect or provide feedback
        header('Location: incoming-issuance-request.php'); // Redirect to a relevant page after rejection
        exit();
    }
}

// Close connection
$conn->close();
?>
