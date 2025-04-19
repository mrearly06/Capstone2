<?php
// Include your database connection script
include 'connection.php';
session_start(); // Start the session to access session variables

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure user is logged in
    if (!isset($_SESSION['userID'])) {
        echo "<script>alert('User not logged in.'); window.location.href='../item-list.php';</script>";
        exit;
    }

    // Use the session to get the user type
    $userType = $_SESSION['userType']; // Get userType from session
    $userID = $_SESSION['userID']; // Get userID from session

    // Retrieve form data
    $itemNo = $_POST['itemNo'] ?? '';
    $itemCodes = $_POST['itemCode'] ?? []; // Dynamic array of item codes
    $itemName = $_POST['itemName'] ?? '';
    $description = $_POST['itemDescription'] ?? '';
    $quantity = $_POST['itemQuantity'] ?? 0;
    $dateAcquired = $_POST['itemDate'] ?? '';
    $unitValue = $_POST['itemValue'] ?? 0;
    $totalValue = $_POST['totalValue'] ?? 0;
    $category = $_POST['category'] ?? '';
    $status = $_POST['itemStatus'] ?? '';

    // Log the raw date value
    error_log("Raw Date Acquired: " . $dateAcquired);

    if (!empty($dateAcquired)) {
        // Convert the date to a valid format (YYYY-MM-DD) if necessary
        $formattedDate = date('Y-m-d', strtotime($dateAcquired));
        error_log("Formatted Date Acquired: " . $formattedDate);
        $dateAcquired = $formattedDate;
    } else {
        error_log("Date Acquired is empty or invalid.");
        $dateAcquired = null;
    }

    // Handle image upload
    $imageName = '';
    if (isset($_FILES['itemImage']) && $_FILES['itemImage']['error'] === UPLOAD_ERR_OK) {
        $imageTmpName = $_FILES['itemImage']['tmp_name'];
        $imageName = basename($_FILES['itemImage']['name']);
        $uploadDir = '../uploads/';
        $uploadFile = $uploadDir . $imageName;

        if (!move_uploaded_file($imageTmpName, $uploadFile)) {
            echo "<script>alert('Error uploading file.'); window.location.href='../item-list.php';</script>";
            exit;
        }
    }

    // Check for duplicate item codes in both tables
    $duplicateFound = false;

    foreach ($itemCodes as $itemCode) {
        // Check in the 'item' table
        $query = "SELECT COUNT(*) FROM item WHERE itemCode = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $itemCode);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        // If found in 'item', set duplicateFound to true
        if ($count > 0) {
            $duplicateFound = true;
            break;
        }

        // Check in the 'item_review' table
        $query = "SELECT COUNT(*) FROM item_review WHERE itemReviewCode = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $itemCode);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        // If found in 'item_review', set duplicateFound to true
        if ($count > 0) {
            $duplicateFound = true;
            break;
        }
    }

    // If duplicates found, alert and exit
    if ($duplicateFound) {
        echo "<script>alert('Warning: Duplicate item code found in either inventory or review.'); window.location.href='../item-list.php';</script>";
        exit;
    }

    if ($userType === 'admin') {
        // Admin inserts into the 'item' table for each itemCode
        foreach ($itemCodes as $itemCode) {
            $query = "
                INSERT INTO item (itemNo, itemCode, itemName, description, quantity, dateAcquired, unitValue, totalValue, image, category, loggedAt, loggedBy)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)
            ";
            $stmt = $conn->prepare($query);

            // Bind parameters
            $stmt->bind_param(
                'ssssiiddssi',
                $itemNo,
                $itemCode,
                $itemName,
                $description,
                $quantity,
                $dateAcquired,
                $unitValue,
                $totalValue,
                $imageName,
                $category,
                $userID // `loggedBy` is the userID
            );

            // Execute the query and provide feedback
            if ($stmt->execute()) {
                echo "<script>alert('Item successfully added to the inventory.'); window.location.href='../item-list.php';</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='../item-list.php';</script>";
            }
        }
    } elseif ($userType === 'user') {
        // Start a transaction
        $conn->begin_transaction();

        try {
            // Insert into the 'inventory_request' table
            $reqDate = date('Y-m-d'); // Current date
            $reqTime = date('H:i:s'); // Current time
            $requestStatus = 'Pending'; // Default status
            $queryReq = "
                INSERT INTO inventory_request (reqDate, reqTime, requestStatus, requestedBy)
                VALUES (?, NOW(), ?, ?)
            ";
            $stmtReq = $conn->prepare($queryReq);
            $stmtReq->bind_param('sss', $reqDate, $requestStatus, $userID);
            $stmtReq->execute();

            // Get the last inserted inventoryReqID
            $inventoryReqID = $stmtReq->insert_id;
            $stmtReq->close();

            // Insert into the 'item_review' table for each itemCode
            foreach ($itemCodes as $itemCode) {
                $queryRev = "
                    INSERT INTO item_review (itemReviewNo, itemReviewCode, itemReviewName, description, quantity, dateAcquired, unitValue, totalValue, image, category, loggedAt, loggedBy, inventoryReqID)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?)
                ";
                $stmtRev = $conn->prepare($queryRev);
                $stmtRev->bind_param(
                    'ssssiiddssii',
                    $itemNo,
                    $itemCode,
                    $itemName,
                    $description,
                    $quantity,
                    $dateAcquired,
                    $unitValue,
                    $totalValue,
                    $imageName,
                    $category,
                    $userID, // `loggedBy` is the userID
                    $inventoryReqID // Include inventoryReqID
                );
                $stmtRev->execute();
            }
            
            $stmtRev->close();

            // Commit the transaction
            $conn->commit();

            echo "<script>alert('Item successfully submitted for review.'); window.location.href='../item-list.php';</script>";
        } catch (Exception $e) {
            // Rollback the transaction on error
            $conn->rollback();
            echo "<script>alert('Error occurred: " . $e->getMessage() . "'); window.location.href='../item-list.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid user type.'); window.location.href='../item-list.php';</script>";
        exit;
    }

    // Close statement and connection
    $conn->close();
}
?>
