<?php
// Database connection
include 'connection.php';

// Retrieve and decode JSON data from AJAX request
$data = json_decode(file_get_contents('php://input'), true);

$response = ['success' => false, 'message' => ''];

try {
    // Retrieve and validate main form data
    $controlNo = $data['controlNo'] ?? '';
    $date = $data['date'] ?? '';
    $requestedBy = $data['requestedBy'] ?? '';
    $officeDepartment = $data['officeDepartment'] ?? '';
    $items = $data['items'] ?? [];

    // Check for required fields and provide specific feedback
    if (empty($date)) throw new Exception("Date is required.");
    if (empty($requestedBy)) throw new Exception("Requested by field is required.");
    if (empty($officeDepartment)) throw new Exception("Office/Department is required.");
    if (empty($items)) throw new Exception("At least one item is required.");

    // Start transaction
    $conn->begin_transaction();

    // Insert into asset_request and get assetRequestId
    $sql = "INSERT INTO asset_request (date, requestedBy, officeDepartment, status, time) 
            VALUES ( ?, ?, ?, 'Pending', NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $date, $requestedBy, $officeDepartment);

    if ($stmt->execute()) {
        $assetRequestId = $stmt->insert_id;  // Get the generated assetRequestId for linking
    } else {
        throw new Exception("Database insertion failed in asset_request.");
    }
    $stmt->close();

    // Insert each item into asset_request_detail
    $sqlDetail = "INSERT INTO asset_request_detail (controlNo, category, quantity, description, amount, assetRequestId)
                  VALUES (?, ?, ?, ?, ?, ?)";
    $stmtDetail = $conn->prepare($sqlDetail);

    $stmtDetail->bind_param("ssdsdi", $controlNo, $category, $quantity, $description, $amount, $assetRequestId);

    foreach ($items as $item) {
        $category = $item['category'] ?? '';  // This is the combined category string
        $quantity = (int)($item['quantity'] ?? 0);
        $description = $item['description'] ?? '';
        $amount = (float)($item['amount'] ?? 0);
    
        // Bind and execute once per item
        if (!$stmtDetail->execute()) {
            throw new Exception("Failed to insert item into asset_request_detail.");
        }
    }

    // Commit transaction
    $conn->commit();
    $response['success'] = true;
    $response['message'] = "Form submitted successfully.";
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    $response['message'] = $e->getMessage();
}

// Send JSON response back to AJAX
header('Content-Type: application/json');
echo json_encode($response);

// Close connections
$conn->close();
?>
