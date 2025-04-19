<?php
// Enable output buffering
ob_start();

// Include required files
require_once '../vendor/autoload.php';
include 'connection.php';

// Check if form is submitted
if (isset($_POST['export-docu'])) {
    // Create a new PHPWord object
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $section = $phpWord->addSection();

    // Add title (centered, with font size)
    $titleStyle = array(
        'name' => 'Arial',
        'size' => 16, // Set the font size
        'bold' => true,
        'align' => 'center', // Center align the title
    );
    $section->addText('Monthly Asset Report', $titleStyle);

    // Add a margin below the title
    $section->addTextBreak(1); // Adds a line break after the title

    // Add charts (if images exist)
    if (file_exists('../charts/assets_chart.png')) {
        $section->addImage('../charts/assets_chart.png', ['width' => 400, 'height' => 300]);
    }

    // Add space after the first chart
    $section->addTextBreak(1); // Adds a line break after the first chart

    if (file_exists('../charts/cost_chart.png')) {
        $section->addImage('../charts/cost_chart.png', ['width' => 400, 'height' => 300]);
    }

    // Add space below the second chart
    $section->addTextBreak(1); // Adds a line break after the second chart

    // Add a page break to start the table on the next page
    $section->addPageBreak();

    // Add a title for the table
    $tableTitleStyle = array(
        'name' => 'Arial',
        'size' => 14, // Set font size for the table title
        'bold' => true,
        'align' => 'center', // Center align the table title
    );
    $section->addText('Monthly Asset, Cost Per User Summary', $tableTitleStyle);

    // Add a margin below the title
    $section->addTextBreak(1); // Adds a line break after the title

    // Add the table
    $table = $section->addTable();
    $table->addRow();
    $table->addCell(2000)->addText('Month');
    $table->addCell(2000)->addText('User');
    $table->addCell(2000)->addText('Total Assets');
    $table->addCell(2000)->addText('Total Cost ($)');

    $query = "SELECT DATE_FORMAT(i.date, '%Y-%m') AS month, 
                     CONCAT(u.lastName, ' ', u.firstName, ', ', u.middleName) AS receivedBy, 
                     SUM(i.amount) AS totalCost, 
                     COUNT(i.issuanceID) AS totalAssets 
              FROM issuance i 
              JOIN user u ON i.receivedBy = u.userID 
              GROUP BY month, i.receivedBy 
              ORDER BY month DESC";

    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $table->addRow();
        $table->addCell(2000)->addText($row['month']);
        $table->addCell(2000)->addText($row['receivedBy']);
        $table->addCell(2000)->addText($row['totalAssets']);
        $table->addCell(2000)->addText(number_format($row['totalCost'], 2));
    }

    // Save and output Word document
    header('Content-Type: application/msword');
    header('Content-Disposition: attachment; filename="monthly_report.docx"');
    $phpWord->save('php://output', 'Word2007');

    // Cleanup temporary files
    unlink('../charts/assets_chart.png');
    unlink('../charts/cost_chart.png');
    exit;
}
?>
