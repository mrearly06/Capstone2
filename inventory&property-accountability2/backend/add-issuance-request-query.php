<?php
session_start(); // Start the session at the beginning of your script
include "connection.php"; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $reqIssuanceDateStart = $_POST['issuanceDateStart'];
    $reqIssuanceDateEnd = $_POST['issuanceDateEnd'];

    // Convert array to a string for purposes, check if it's an array
    $reqIssuancePurpose = isset($_POST['issuancePurpose']) 
        ? (is_array($_POST['issuancePurpose']) ? implode(', ', $_POST['issuancePurpose']) : $_POST['issuancePurpose']) 
        : ''; 
    
    $reqOtherPurposeDetails = $_POST['otherPurposeDetails'] ?? ''; // Other purpose details, if provided
    $reqIssuedTo = $_POST['userID']; // Hidden input field value (userID)

    // Get the itemNo array
    $itemNumbers = $_POST['itemNo'] ?? []; // Use empty array if not set

    $reqBy = $_POST['requestedBy']; // Retrieve this from session or any authentication method

    // Add the date and time for the log
    $reqLoggedDate = date("Y-m-d");
    $reqLoggedTime = date("H:i:s");

    // Prepare the SQL statement
    $sql = "INSERT INTO issuance_request (
                reqStatus, 
                reqIssuanceDateStart, 
                reqIssuanceDateEnd, 
                reqIssuancePurpose,
                reqOtherPurposeDetails,   
                reqLoggedDate, 
                reqLoggedTime, 
                reqIssuedTo, 
                reqItemNo, 
                reqBy
            ) VALUES (
                'Pending', ?, ?, ?, ?, ?, ?, ?, ?, ?
            )";

    // Prepare statement once, we'll execute it multiple times
    $stmt = $conn->prepare($sql);
    $success = false; // Flag to check if any record was inserted

    // Loop through each itemNo
    foreach ($itemNumbers as $reqItemNo) {
        // Check if reqItemNo exists in the item table
        $checkItemQuery = "SELECT itemNo FROM item WHERE itemNo = ?";
        $checkStmt = $conn->prepare($checkItemQuery);
        $checkStmt->bind_param("s", $reqItemNo);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            // Item exists, proceed with the insertion
            $stmt->bind_param(
                "sssssssss", 
                $reqIssuanceDateStart, 
                $reqIssuanceDateEnd, 
                $reqIssuancePurpose,
                $reqOtherPurposeDetails,
                $reqLoggedDate, 
                $reqLoggedTime, 
                $reqIssuedTo, 
                $reqItemNo, 
                $reqBy
            );

            if ($stmt->execute()) {
                $success = true; // Record was inserted successfully
            } else {
                // Error: display an error message
                echo "Error inserting itemNo '$reqItemNo': " . $stmt->error . "<br>";
            }
        } else {
            // Error: Item does not exist
            echo "Error: The item with itemNo '$reqItemNo' does not exist.<br>";
        }

        $checkStmt->close();
    }

    // Close statement and connection after all insertions
    $stmt->close();
    $conn->close();

    // If any record was successfully inserted, set a session message
    if ($success) {
        $_SESSION['success_message'] = "Issuance request(s) successfully added!";
    }

    // Redirect to success page after all insertions are attempted
    header("Location: ../add-issuance.php"); // Replace with your success page
    exit();
}
?>
