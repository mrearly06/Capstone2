<?php
// Include your database connection script
include 'backend/connection.php';

// Default Query for Asset Requests
$queryAsset = "
    SELECT 
        ar.assetRequestId, 
        ar.date, 
        ar.time, 
        ar.status, 
        ar.officeDepartment, 
        ar.requestedBy,
        ard.assetRequestDetailId, 
        ard.controlNo, 
        ard.category, 
        ard.quantity, 
        ard.description, 
        ard.amount
    FROM asset_request ar
    LEFT JOIN asset_request_detail ard ON ar.assetRequestId = ard.assetRequestId
";

// Query for Issuance Requests
$queryIssuance = "
    SELECT
        ir.issuanceReviewID,
        ir.issuanceReviewNo,
        ir.date,
        ir.time,
        ir.quantity,
        ir.itemDescription,
        ir.refNo,
        ir.unitPrice,
        ir.amount,
        ir.issuedBy,
        ir.issuedByDate,
        ir.receivedBy,
        ir.receivedByDate,
        ir.postedBy,
        ir.postedByDate,
        ir.status,
        ir.department
    FROM issuance_review ir
";

$resultAsset = $conn->query($queryAsset);
$resultIssuance = $conn->query($queryIssuance);

// Check if the query was successful
if (!$resultAsset || !$resultIssuance) {
    echo "<p>Error: " . $conn->error . "</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Requests</title>

    <!-- Custom Styles -->
    <link rel="stylesheet" type="text/css" href="assets/css/sidebar-content.css">
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">

    <style>
    .btn-group {
        position: relative;
        right: 0;
        top: 0;
    }

    .hidden {
        display: none;
    }
    
    /* Ensure inactive buttons have a white background with a gray border */
.btn-outline-secondary {
    background-color: white;
    border-color: #ccc; /* Gray border color */
    color: #6c757d; /* Gray text color */
}

.btn-outline-secondary:hover {
    background-color: #f8f9fa; /* Light background on hover */
}
/* Ensure the table is below other elements */


    </style>
</head>
<body>

<!-- Sidebar -->
<?php include "backend/session-sidebar.php"; ?>
<?php require "header.php"; ?>

<!-- Main content -->
<div class="main-content">
    <div class="content1">
        <!-- Breadcrumbs
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Requests</a></li>
                <li class="breadcrumb-item active" aria-current="page">Asset Requests</li>
            </ol>
        </nav>
 -->
        <!-- Content -->
        <div class="container mt-1">
            <div class="row">
                <div class="col-md-12 col-lg-12 mx-auto">
                    <!-- Card Container -->
                    <div class="card mt-5">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Asset Requests</h5>
                            <!-- Button Group -->
                            <div class="btn-group" role="group" aria-label="Request Type">
                                <button type="button" class="btn btn-primary" id="assetRequestBtn">Asset Request</button>
                                <button type="button" class="btn btn-outline-secondary" id="issuanceRequestBtn">Issuance Request</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Asset Requests Table -->
                            <div id="assetRequestTable">
                                <div class="table-responsive">
                                    <table class="table table-hover tble-item" id="assetRequestDataTable">
                                        <thead>
                                            <tr>
                                                <th class="text-nowrap w-auto">Request ID</th>
                                                <th class="text-nowrap w-auto">Date</th>
                                                <th class="text-nowrap w-auto">Time</th>
                                                <th class="text-nowrap w-auto">Status</th>
                                                <th class="text-nowrap w-auto">Office/Department</th>
                                                <th class="text-nowrap w-auto">Requested By</th>
                                                <th class="text-nowrap w-auto">Detail ID</th>
                                                <th class="text-nowrap w-auto">Control No</th>
                                                <th class="text-nowrap w-auto">Category</th>
                                                <th class="text-nowrap w-auto">Quantity</th>
                                                <th class="text-nowrap w-auto">Description</th>
                                                <th class="text-nowrap w-auto">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            // Fetch and display data from the asset_request and asset_request_detail tables
                                            while ($row = $resultAsset->fetch_assoc()) {
                                                echo '<tr>';
                                                echo '<td>' . htmlspecialchars($row['assetRequestId']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['date']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['time']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['officeDepartment']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['requestedBy']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['assetRequestDetailId']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['controlNo']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['category']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['quantity']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['description']) . '</td>';
                                                echo '<td>' . htmlspecialchars(number_format($row['amount'], 2)) . '</td>';
                                                echo '</tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Issuance Requests Table (Initially Hidden) -->
                            <div id="issuanceRequestTable" class="hidden">
                                <div class="table-responsive">
                                    <table class="table table-hover issuance-review" id="issuanceRequestDataTable">
                                        <thead>
                                            <tr>
                                                <th>Review ID</th>
                                                <th>Review No</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Quantity</th>
                                                <th>Item Description</th>
                                                <th>Reference No</th>
                                                <th>Unit Price</th>
                                                <th>Amount</th>
                                                <th>Issued By</th>
                                                <th>Issued By Date</th>
                                                <th>Received By</th>
                                                <th>Received By Date</th>
                                                <th>Posted By</th>
                                                <th>Posted By Date</th>
                                                <th>Status</th>
                                                <th>Department</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            // Fetch and display data from the issuance_review table
                                            while ($row = $resultIssuance->fetch_assoc()) {
                                                echo '<tr>';
                                                echo '<td>' . htmlspecialchars($row['issuanceReviewID']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['issuanceReviewNo']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['date']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['time']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['quantity']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['itemDescription']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['refNo']) . '</td>';
                                                echo '<td>' . htmlspecialchars(number_format($row['unitPrice'], 2)) . '</td>';
                                                echo '<td>' . htmlspecialchars(number_format($row['amount'], 2)) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['issuedBy']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['issuedByDate']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['receivedBy']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['receivedByDate']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['postedBy']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['postedByDate']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['department']) . '</td>';
                                                echo '</tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- End Card -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTables with Bootstrap 5 integration
        $('.tble-item').DataTable({
            responsive: true,
            language: {
                paginate: {
                    previous: '&laquo;',
                    next: '&raquo;'
                }
            }
        });

        // Set the z-index of the table
        $('.tble-item').css('z-index', '-1');
    });
</script>

<script>
$(document).ready(function() {
    // DataTables Initialization
    $('#assetRequestDataTable').DataTable();
    $('#issuanceRequestDataTable').DataTable();

    // Toggle tables and change button styles based on button click
    $('#assetRequestBtn').click(function() {
        // Show asset request table, hide issuance request table
        $('#assetRequestTable').removeClass('hidden');
        $('#issuanceRequestTable').addClass('hidden');
        
        // Change button styles: active button gets .btn-primary, others get .btn-outline-secondary
        $(this).addClass('btn-primary').removeClass('btn-outline-secondary');
        $('#issuanceRequestBtn').addClass('btn-outline-secondary').removeClass('btn-primary');
    });

    $('#issuanceRequestBtn').click(function() {
        // Show issuance request table, hide asset request table
        $('#issuanceRequestTable').removeClass('hidden');
        $('#assetRequestTable').addClass('hidden');
        
        // Change button styles: active button gets .btn-primary, others get .btn-outline-secondary
        $(this).addClass('btn-primary').removeClass('btn-outline-secondary');
        $('#assetRequestBtn').addClass('btn-outline-secondary').removeClass('btn-primary');
    });
});
</script>

</body>
</html>
