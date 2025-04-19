<?php
include 'connection.php';

// Fetch total values grouped by department
$query = "
    SELECT 
        d.departmentName AS department, 
        SUM(i.amount) AS totalValue 
    FROM issuance i
    JOIN department d ON i.department = d.departmentID
    GROUP BY d.departmentName
    ORDER BY d.departmentName ASC
";

$result = mysqli_query($conn, $query);

$departments = [];
$totalValues = [];

while ($row = mysqli_fetch_assoc($result)) {
    $departments[] = $row['department'];
    $totalValues[] = $row['totalValue'];
}

// Encode data to JSON
$departments_json = json_encode($departments);
$totalValues_json = json_encode($totalValues);
?>
