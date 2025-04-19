<?php
require_once 'connection.php';

header('Content-Type: application/json');

try {
    // Decode JSON input
    $inputData = json_decode(file_get_contents('php://input'), true);

    if (!$inputData) {
        throw new Exception("Invalid JSON payload.");
    }

    $formData = $inputData['formData'] ?? [];
    $tableData = $inputData['tableData'] ?? [];

    // Validate form data
    $requiredFields = ['issuanceReviewNo', 'department', 'date', 'time', 'issuedBy', 'receivedBy', 'postedBy'];
    foreach ($requiredFields as $field) {
        if (empty($formData[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    // Check for duplicate issuanceReviewNo
    $checkStmt = $conn->prepare("SELECT 1 FROM issuance_review WHERE issuanceReviewNo = ?");
    $checkStmt->bind_param('s', $formData['issuanceReviewNo']);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        throw new Exception("Duplicate issuanceReviewNo: " . $formData['issuanceReviewNo']);
    }

    // Prepare the statement for inserting rows into the issuance_review table
    $stmt = $conn->prepare("
        INSERT INTO issuance_review (
            issuanceReviewNo, department, date, time, issuedBy, issuedByDate,
            receivedBy, receivedByDate, postedBy, postedByDate, status,
            quantity, itemDescription, refNo, unitPrice, amount
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $status = 'In Process'; // Default status

    // Loop through each row in the tableData and insert into the same table
    foreach ($tableData as $item) {
        $stmt->bind_param(
            'sssssssssssissdd',
            $formData['issuanceReviewNo'],
            $formData['department'],
            $formData['date'],
            $formData['time'],
            $formData['issuedBy'],
            $formData['issuedByDate'],
            $formData['receivedBy'],
            $formData['receivedByDate'],
            $formData['postedBy'],
            $formData['postedByDate'],
            $status,
            $item['qty'],
            $item['description'],
            $item['ref_no'],
            $item['unit_price'],
            $item['amount']
        );

        if (!$stmt->execute()) {
            throw new Exception("Error inserting data: " . $stmt->error);
        }
    }

    echo json_encode(['success' => true, 'message' => 'Issuance slip processed successfully.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
