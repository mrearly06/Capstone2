<?php
// Enable output buffering to prevent premature output
ob_start();

// Include FPDF library
require('../vendor/fpdf/fpdf.php');

// Include the database connection
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

// Execute the query
$result = mysqli_query($conn, $query);

// Handle database errors
if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

// Check if rows are returned
if (mysqli_num_rows($result) === 0) {
    die("No data available for the report.");
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

// Create PDF object
$pdf = new FPDF();
$pdf->AddPage();

// Set the font to normal (remove 'B' for bold)
$pdf->SetFont('Arial', '', 10); // The second parameter is removed to make it normal

// Set margins
$pdf->SetLeftMargin(10);
$pdf->SetRightMargin(10);
$pdf->SetTopMargin(10);

// Add title
$pdf->SetFont('Arial', 'B', 12); // Set the font to bold for the table title
$pdf->Cell(200, 10, 'Monthly Property Accountability and Inventory Report', 0, 1, 'C');

// Add charts
$pdf->Image('../charts/assets_chart.png', 10, 30, 90, 60); // Adjust position and size
$pdf->Image('../charts/cost_chart.png', 110, 30, 90, 60);

// Add a margin below the charts (adjust value as needed)
$pdf->Ln(75); // This will add space below the images

// Add the table title
$pdf->SetFont('Arial', 'B', 12); // Set the font to bold for the table title
$pdf->Cell(200, 10, 'Monthly Asset, Cost Per User Summary', 0, 1, 'C'); // Table title centered
$pdf->Ln(1); // Line break after the title

// Set the font back to normal for the table
$pdf->SetFont('Arial', '', 10);

// Add table headers with adjusted column widths
$pdf->Cell(40, 10, 'Month', 1);
$pdf->Cell(50, 10, 'User', 1);
$pdf->Cell(40, 10, 'Total Assets', 1);
$pdf->Cell(50, 10, 'Total Cost ($)', 1);
$pdf->Ln(); // Line break

// Add table rows with adjusted column widths
foreach ($months as $index => $month) {
    $pdf->Cell(40, 10, $month, 1);
    $pdf->Cell(50, 10, $receivedBy[$index], 1);
    $pdf->Cell(40, 10, $totalAssets[$index], 1);
    $pdf->Cell(50, 10, number_format($totalCosts[$index], 2), 1);
    $pdf->Ln(); // Line break
}

// Clear the output buffer and output the PDF
ob_end_clean();
$pdf->Output('D', 'monthly_report_with_charts.pdf');
exit;
?>
