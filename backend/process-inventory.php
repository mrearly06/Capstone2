<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Include your database connection
include 'connection.php';

// Retrieve form data sent via AJAX
$slipNumber = isset($_POST['slipNumber']) ? $_POST['slipNumber'] : "";
$loggedBy = isset($_POST['loggedBy']) ? $_POST['loggedBy'] : "";
$loggedById = isset($_POST['loggedById']) ? $_POST['loggedById'] : "";
$loggedDate = isset($_POST['loggedDate']) ? $_POST['loggedDate'] : date("Y-m-d H:i:s");

// Prepare the INSERT statement for item table
$sql = "INSERT INTO item 
    (itemInventorySlipNo, itemName, description, quantity, dateAcquired, unitValue, totalValue, image, category, loggedAt, loggedBy)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Database error: " . mysqli_error($conn)]);
    exit;
}

$insertSuccess = true;
$errorMessage = "";

// Upload folder (ensure it exists)
$uploadDir = '../uploads/asset_img/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Function to generate a unique itemInstanceCode
function generateItemInstanceCode($conn, $year) {
    $query = "SELECT itemInstanceCode FROM item_instance WHERE itemInstanceCode LIKE '$year-%' ORDER BY itemInstanceID DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if ($result && $row = mysqli_fetch_assoc($result)) {
        $lastCode = $row['itemInstanceCode'];
        $lastNumber = (int)substr($lastCode, -2); // Extract last two digits
        $newNumber = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);
    } else {
        $newNumber = '01'; // Start from 01 if no previous record exists
    }
    
    return $year . '-' . $newNumber;
}

// Loop through each row of the inventory table
foreach ($_POST['itemName'] as $index => $itemName) {
    $itemDescription = isset($_POST['itemDescription'][$index]) ? $_POST['itemDescription'][$index] : "";
    $quantity = isset($_POST['quantity'][$index]) ? (int)$_POST['quantity'][$index] : 0;
    $dateAcquired = isset($_POST['dateAcquired'][$index]) ? $_POST['dateAcquired'][$index] : NULL;
    $unitValue = isset($_POST['unitValue'][$index]) ? (float)$_POST['unitValue'][$index] : 0;
    $totalValue = isset($_POST['totalValue'][$index]) ? (float)$_POST['totalValue'][$index] : 0;
    $category = isset($_POST['category'][$index]) ? $_POST['category'][$index] : "";

    // Handle image upload
    $imageFileName = '';
    if (isset($_FILES['itemImage']['name'][$index]) && $_FILES['itemImage']['error'][$index] == 0) {
        $imageFileName = basename($_FILES['itemImage']['name'][$index]);
        $targetFile = $uploadDir . $imageFileName;
        
        // Validate file extension
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $validExtensions)) {
            if (!move_uploaded_file($_FILES['itemImage']['tmp_name'][$index], $targetFile)) {
                $insertSuccess = false;
                $errorMessage = "Error uploading file.";
                break;
            }
        } else {
            $insertSuccess = false;
            $errorMessage = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
            break;
        }
    }

    // Insert into item table
    $stmt->bind_param(
        "sssisdissss",
        $slipNumber, // itemInventorySlipNo
        $itemName, // itemName
        $itemDescription, // description
        $quantity, // quantity
        $dateAcquired, // dateAcquired
        $unitValue, // unitValue
        $totalValue, // totalValue
        $imageFileName, // image filename
        $category, // category
        $loggedDate, // loggedAt
        $loggedById // loggedBy
    );

    if (!$stmt->execute()) {
        $insertSuccess = false;
        $errorMessage = $stmt->error;
        break;
    }

    // Get the last inserted item ID
    $itemID = $conn->insert_id;

    // Insert into item_instance table
    $currentYear = date("Y");

    for ($i = 0; $i < $quantity; $i++) {
        $itemInstanceCode = generateItemInstanceCode($conn, $currentYear);

        $instanceSql = "INSERT INTO item_instance (itemInstanceCode, itemNo) VALUES (?, ?)";
        $instanceStmt = $conn->prepare($instanceSql);

        if (!$instanceStmt) {
            $insertSuccess = false;
            $errorMessage = "Database error: " . mysqli_error($conn);
            break;
        }

        $instanceStmt->bind_param("si", $itemInstanceCode, $itemID);
        
        if (!$instanceStmt->execute()) {
            $insertSuccess = false;
            $errorMessage = $instanceStmt->error;
            break;
        }

        // Get the last inserted itemInstanceID
        $itemInstanceID = $conn->insert_id;

        // Insert into asset_status table with default values
        $statusSql = "INSERT INTO asset_status (itemInstanceID, inStock, issued, inUse, notInUse, underRepair, underMaintenance, lost, disposed) 
                      VALUES (?, TRUE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE)";
        $statusStmt = $conn->prepare($statusSql);

        if (!$statusStmt) {
            $insertSuccess = false;
            $errorMessage = "Database error: " . mysqli_error($conn);
            break;
        }

        $statusStmt->bind_param("i", $itemInstanceID);
        
        if (!$statusStmt->execute()) {
            $insertSuccess = false;
            $errorMessage = $statusStmt->error;
            break;
        }

        // Close instance and status statements
        $instanceStmt->close();
        $statusStmt->close();
    }
}

// Close DB connection
$stmt->close();
mysqli_close($conn);

// Return JSON response
if ($insertSuccess) {
    echo json_encode(["success" => true, "message" => "Inventory items saved successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Error saving items: " . $errorMessage]);
}

?>
