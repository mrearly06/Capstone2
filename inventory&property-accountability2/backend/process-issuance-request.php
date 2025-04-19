<?php

include 'connection.php'; // Ensure you have a connection to your database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['approve'])) {
        $issuanceRequestID = $_POST['issuanceRequestID'];
        
        // Fetch the request details to store in property_issuance
        $query = "SELECT reqIssuanceDateStart, reqIssuanceDateEnd, reqIssuancePurpose, reqIssuedTo, reqBy, reqItemNo, reqLoggedDate, reqLoggedTime FROM issuance_request WHERE issuanceRequestID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $issuanceRequestID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Prepare the data for insertion into property_issuance
            $issuanceDateStart = $row['reqIssuanceDateStart'];
            $issuanceDateEnd = $row['reqIssuanceDateEnd'];
            $issuancePurpose = $row['reqIssuancePurpose'];
            $issuedTo = $row['reqIssuedTo'];
            $issuedBy = $row['reqBy'];
            $itemNo = $row['reqItemNo'];
            $loggedDate = $row['reqLoggedDate'];
            $loggedTime = $row['reqLoggedTime'];

            // Insert into property_issuance
            $insertQuery = "INSERT INTO property_issuance (issuanceDateStart, issuanceDateEnd, issuancePurpose, status, loggedDate, loggedTime, issuedTo, issuedBy, itemNo, issuanceRequestID) VALUES (?, ?, ?, 'Approved', ?, ?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("sssssisss", $issuanceDateStart, $issuanceDateEnd, $issuancePurpose, $loggedDate, $loggedTime, $issuedTo, $issuedBy, $itemNo, $issuanceRequestID);
            $insertStmt->execute();
            $insertStmt->close();

            // Update the request status to 'Approved'
            $updateQuery = "UPDATE issuance_request SET reqStatus = 'Approved' WHERE issuanceRequestID = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("i", $issuanceRequestID);
            $updateStmt->execute();
            $updateStmt->close();

            // Set success message
            $_SESSION['alert'] = 'success';
        }

        // Close the initial statement
        $stmt->close();
    }

    // You can add similar logic for 'reject' if necessary

    // Redirect back to the issuance requests page
    header("Location:../incoming-request-issuance.php"); // Update to your actual page
    exit();
}
