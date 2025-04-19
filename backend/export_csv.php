

<?php
// Assuming you have a database connection file
include 'connection.php';

// Fetch asset details and total costs, grouped by month and receivedBy
$query = "
    SELECT 
        DATE_FORMAT(i.date, '%Y-%m') AS month,
        CONCAT(u.lastName, ' ', u.firstName, ', ', u.middleName) AS receivedBy,
        SUM(i.amount) AS totalCost,
        COUNT(i.issuanceID) AS totalAssets
    FROM issuance i
    JOIN user u ON i.receivedBy = u.userID
    GROUP BY month, i.receivedBy
    ORDER BY month DESC
";

$result = mysqli_query($conn, $query);

// Check for data
if (!$result || mysqli_num_rows($result) === 0) {
    die("No data available for export.");
}

// Prepare arrays to store data
$months = [];
$receivedBy = [];
$totalAssets = [];
$totalCosts = [];

// Fetch data
while ($row = mysqli_fetch_assoc($result)) {
    $months[] = $row['month'];
    $receivedBy[] = $row['receivedBy'];
    $totalAssets[] = $row['totalAssets'];
    $totalCosts[] = $row['totalCost'];
}

// Set the headers to force file download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="monthly_report.csv"');

// Open output stream for writing CSV
$output = fopen('php://output', 'w');

// Add the column headers to the CSV
fputcsv($output, ['Month', 'User', 'Total Assets', 'Total Cost ($)']);

// Loop through the rows and output them to the CSV
foreach ($months as $index => $month) {
    fputcsv($output, [
        $month,
        $receivedBy[$index],
        $totalAssets[$index],
        number_format($totalCosts[$index], 2)
    ]);
}

// Close the output stream
fclose($output);
exit;
?>
