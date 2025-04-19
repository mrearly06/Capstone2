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
            VALUES (?, ?, ?, 'Pending', NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $date, $requestedBy, $officeDepartment);

    if ($stmt->execute()) {
        $assetRequestId = $stmt->insert_id; // Get the generated assetRequestId for linking
    } else {
        throw new Exception("Database insertion failed in asset_request.");
    }
    $stmt->close();

    // Prepare statement for asset_request_detail
    $sqlDetail = "INSERT INTO asset_request_detail (controlNo, category, quantity, description, amount, assetRequestId)
                  VALUES (?, ?, ?, ?, ?, ?)";
    $stmtDetail = $conn->prepare($sqlDetail);
    $stmtDetail->bind_param("ssdsdi", $controlNo, $category, $quantity, $description, $amount, $assetRequestId);

    // Prepare statement for asset_instances
    $sqlInstance = "INSERT INTO asset_instances (instanceId, assetRequestDetailId) VALUES (?, ?)";
    $stmtInstance = $conn->prepare($sqlInstance);
    $stmtInstance->bind_param("si", $instanceId, $assetRequestDetailId);

    // Function to generate new instanceId
    function getNewInstanceId($conn) {
        $result = $conn->query("SELECT instanceId FROM asset_instances ORDER BY instanceId DESC LIMIT 1");

        if ($result && $row = $result->fetch_assoc()) {
            // Extract the numeric part and increment it
            $lastId = intval(str_replace("INS-", "", $row['instanceId']));
            return "INS-" . ($lastId + 1);
        }
        return "INS-1"; // Default first ID
    }

    foreach ($items as $item) {
        $category = $item['category'] ?? ''; 
        $quantity = (int)($item['quantity'] ?? 0);
        $description = $item['description'] ?? '';
        $amount = (float)($item['amount'] ?? 0);

        // Insert into asset_request_detail
        if (!$stmtDetail->execute()) {
            throw new Exception("Failed to insert item into asset_request_detail.");
        }
        $assetRequestDetailId = $stmtDetail->insert_id; // Get the inserted detail ID

        // Insert into asset_instances for each quantity (even if it's 1)
        for ($i = 0; $i < $quantity; $i++) {
            $instanceId = getNewInstanceId($conn); // Generate new instanceId
            if (!$stmtInstance->execute()) {
                throw new Exception("Failed to insert item into asset_instances.");
            }
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
