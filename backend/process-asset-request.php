<?php
// backend/process-asset-request.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include 'connection.php';

    // Get assetRequestId and validate
    $assetRequestId = isset($_POST['assetRequestId']) ? intval($_POST['assetRequestId']) : null;

    if ($assetRequestId) {
        // Initialize variables
        $status = "Pending";
        $redirectPage = "../incoming-asset-request.php";

        // Determine action based on the submitted button
        if (isset($_POST['approve'])) {
            // Update status to 'For Review At Supply Office'
            $status = "For Review At Supply Office";
            $redirectPage = "../incoming-asset-request2.php";
        } elseif (isset($_POST['approve-supply-office'])) {
            // Update status to 'Approved by Supply Office'
            $status = "Approved";
            $redirectPage = "../incoming-asset-request-supply-office.php";
        } elseif (isset($_POST['forward'])) {
            // Update status to 'Forwarded to Finance'
            $status = "Forwarded to Finance";
            $redirectPage = "../incoming-asset-request.php";
        } elseif (isset($_POST['reject'])) {
            // Update status to 'Rejected'
            $status = "Rejected";
            $redirectPage = "../rejected-requests.php";
        }

        // Update the database
        $query = "UPDATE asset_request SET status = ? WHERE assetRequestId = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('si', $status, $assetRequestId);
            if ($stmt->execute()) {
                // Success: Redirect with success message
                session_start();
                $_SESSION['message'] = "Asset request #{$assetRequestId} has been updated to '{$status}'.";
                $_SESSION['message_type'] = 'success';
            } else {
                // Failure: Redirect with error message
                session_start();
                $_SESSION['message'] = "Failed to update asset request #{$assetRequestId}. Please try again.";
                $_SESSION['message_type'] = 'error';
                $redirectPage = "../error-page.php";
            }
            $stmt->close();
        } else {
            // Query preparation failed
            session_start();
            $_SESSION['message'] = "Failed to prepare the database query.";
            $_SESSION['message_type'] = 'error';
            $redirectPage = "../error-page.php";
        }
    } else {
        // Invalid request ID
        session_start();
        $_SESSION['message'] = "Invalid asset request ID.";
        $_SESSION['message_type'] = 'error';
        $redirectPage = "../error-page.php";
    }

    // Close the database connection
    $conn->close();

    // Redirect to the appropriate page
    header("Location: $redirectPage");
    exit;
}
?>
