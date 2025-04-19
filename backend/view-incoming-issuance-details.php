<?php
include 'connection.php';
header('Content-Type: application/json');

$issuanceReviewNo = $_GET['id'];

$query = "SELECT 
    ir.issuanceReviewNo,
    ir.date,
    ir.time,
    ir.refNo,
    CONCAT(u1.firstName, ' ', u1.middleName, ' ', u1.lastName) AS issuedBy,
    ir.issuedByDate,
    CONCAT(u2.firstName, ' ', u2.middleName, ' ', u2.lastName) AS receivedBy,
    ir.receivedByDate,
    CONCAT(u3.firstName, ' ', u3.middleName, ' ', u3.lastName) AS postedBy,
    ir.postedByDate,
    ir.status,
    d.departmentName,
    ii.itemInstanceID,
    ii.itemInstanceCode,
    i.quantity,
    i.description,
    i.dateAcquired,
    i.unitValue,
    i.image
FROM issuance_review ir
LEFT JOIN user u1 ON ir.issuedBy = u1.userID
LEFT JOIN user u2 ON ir.receivedBy = u2.userID
LEFT JOIN user u3 ON ir.postedBy = u3.userID
LEFT JOIN department d ON ir.department = d.departmentID
LEFT JOIN item_instance ii ON ir.itemInstanceID = ii.itemInstanceID
LEFT JOIN item i ON ii.itemNo = i.itemNo
WHERE ir.issuanceReviewNo = '$issuanceReviewNo'";

$result = $conn->query($query);

$rows = [];
while ($r = $result->fetch_assoc()) {
    $rows[] = $r;
}

echo json_encode($rows);
?>
