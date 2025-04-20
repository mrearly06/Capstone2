<?php
// Include your database connection script
include 'backend/connection.php';

// Default Query for Inventory Requests
$queryInventory = "
    SELECT 
        ir.inventoryReqID, 
        ir.reqdate, 
        ir.reqtime, 
        ir.requestStatus, 
        ir.requestedBy,
        ird.itemReviewNo, 
        ird.itemReviewCode, 
        ird.itemReviewName, 
        ird.description, 
        ird.quantity, 
        ird.dateAcquired, 
        ird.unitValue, 
        ird.totalValue, 
        ird.image, 
        ird.category,
        ird.loggedAt,
        ird.loggedBy,
        u.firstName, 
        u.middleName, 
        u.lastName
    FROM inventory_request ir
    LEFT JOIN item_review ird ON ir.inventoryReqID = ird.inventoryReqID
    LEFT JOIN user u ON ir.requestedBy = u.userID
";

// Query for Inventory Issuance Requests
$queryIssuance = "
    SELECT
        iir.issuanceReviewID,
        iir.issuanceReviewNo,
        iir.date,
        iir.time,
        iir.refNo,
        iir.issuedBy,
        iir.issuedByDate,
        iir.receivedBy,
        iir.receivedByDate,
        iir.postedBy,
        iir.postedByDate,
        iir.status,
        iir.department
    FROM issuance_review iir
";

$queryAssetRequest = "
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



$resultInventory = $conn->query($queryInventory);
$resultIssuance = $conn->query($queryIssuance);
$resultAssetRequest = $conn->query($queryAssetRequest);

// Check if the query was successful
if (!$resultInventory || !$resultIssuance || !$resultAssetRequest) {
    echo "<p>Error: " . $conn->error . "</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Requests</title>


    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">

    <style>
      .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px; /* Default sidebar width */
            background: linear-gradient(to bottom, #1e2233, #121520); /* Darker gradient */
            color: #fff;
            transition: all 0.3s ease;
            overflow-y: auto;
            z-index: 99;
        }
        .sidebar .nav-item .collapse {
            background-color: #181b2a; /* Darker submenu background */
        }

        .sidebar .nav-link {
            color: #fff;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
            color: #fff;
        }
        .sidebar .nav-item.active .nav-link {
            background-color: #007bff;
        }
        .main-content {
            margin-left: 250px;
            transition: margin-left 0.3s;
            background-color: rgb(240,240,240); /* Less white background */
            height: 100vh;
        }
        .sidebar-collapse .main-content {
            margin-left: 0;
        }
        .card {
            background-color: #fff; /* Card background color */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }
        .card-header {
            background-color: #f1f3f5; /* Slightly gray header */
        }
        .title-logo {
    background-color: #2d3145;
    padding: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
}
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

    </style>
</head>
<body>

<!-- Sidebar -->
<?php include "backend/session-sidebar.php"; ?>
<?php require "header.php"; ?>

<!-- Main content -->
<div class="main-content">
    <div class="content1">
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Requests</a></li>
                <li class="breadcrumb-item active" aria-current="page">Inventory Requests</li>
            </ol>
        </nav>

        <!-- Content -->
        <div class="container mt-1">
            <div class="row">
                <div class="col-md-12 col-lg-12 mx-auto">
                    <!-- Card Container -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Inventory Requests</h5>
                            <!-- Button Group -->
                            <div class="btn-group" role="group" aria-label="Request Type">
                                <button type="button" class="btn btn-primary" id="inventoryRequestBtn">Inventory Request</button>
                                <button type="button" class="btn btn-outline-secondary" id="assetRequestBtn">Asset Request</button>
                                <button type="button" class="btn btn-outline-secondary" id="issuanceRequestBtn">Issuance Request</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Inventory Requests Table -->
                            <div id="inventoryRequestTable">
                                <div class="table-responsive">
                                <table class="table table-hover tble-item" id="inventoryRequestDataTable">
                                    <thead>
                                        <tr>
                                            <th class="text-nowrap w-auto">Request ID</th>
                                            <th class="text-nowrap w-auto">Date</th>
                                            <th class="text-nowrap w-auto">Time</th>
                                            <th class="text-nowrap w-auto">Status</th>
                                            <th class="text-nowrap w-auto">Requested By</th>
                                            <th class="text-nowrap w-auto">Item Review No</th>
                                            <th class="text-nowrap w-auto">Item Review Code</th>
                                            <th class="text-nowrap w-auto">Item Review Name</th>
                                            <th class="text-nowrap w-auto">Description</th>
                                            <th class="text-nowrap w-auto">Quantity</th>
                                            <th class="text-nowrap w-auto">Date Acquired</th>
                                            <th class="text-nowrap w-auto">Unit Value</th>
                                            <th class="text-nowrap w-auto">Total Value</th>
                                            <th class="text-nowrap w-auto">Image</th>
                                            <th class="text-nowrap w-auto">Category</th>
                                            <th class="text-nowrap w-auto">Logged At</th>
                                            <th class="text-nowrap w-auto">Logged By</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        <?php 
                                        // Fetch and display data from the inventory_request and inventory_request_detail tables
                                        while ($row = $resultInventory->fetch_assoc()) {
                                              // Determine the badge class based on the status value
                                                $badgeClass = '';
                                                if ($row['requestStatus'] === 'Pending') {
                                                    $badgeClass = 'bg-warning'; // Bootstrap warning badge
                                                } elseif ($row['requestStatus'] === 'Approved') {
                                                    $badgeClass = 'bg-success'; // Bootstrap success badge
                                                } elseif ($row['requestStatus'] === 'Rejected') {
                                                    $badgeClass = 'bg-danger'; // Bootstrap danger badge
                                                }
                                            echo '<tr>';
                                            echo '<td>' . htmlspecialchars($row['inventoryReqID']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['reqdate']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['reqtime']) . '</td>';
                                            echo '<td><span class="badge ' . $badgeClass . '">' . htmlspecialchars($row['requestStatus']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['firstName']) . ' ' 
                                            . htmlspecialchars($row['middleName']) . ' ' 
                                            . htmlspecialchars($row['lastName']) . ' (ID:' 
                                            . htmlspecialchars($row['requestedBy']) . ')' 
                                            . '</td>';                               
                                            echo '<td>' . htmlspecialchars($row['itemReviewNo']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['itemReviewCode']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['itemReviewName']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['description']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['quantity']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['dateAcquired']) . '</td>';
                                            echo '<td>' . htmlspecialchars(number_format($row['unitValue'], 2)) . '</td>';
                                            echo '<td>' . htmlspecialchars(number_format($row['totalValue'], 2)) . '</td>';
                                            echo '<td><img src="' . htmlspecialchars( 'uploads/'. $row['image']) . '" alt="Item Image" style="width: 60px; height: auto;"></td>';
                                            echo '<td>' . htmlspecialchars($row['category']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['loggedAt']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['loggedBy']) . '</td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                    </table>
                                </div>
                            </div>

                            <!-- Issuance Requests Table (Initially Hidden) -->
                            <div id="issuanceRequestTable" class="hidden">
                                <div class="table-responsive">
                                <table class="table table-hover tble-item" id="issuanceRequestDataTable">
                                    <thead>
                                        <tr>
                                            <th class="text-nowrap w-auto">Issuance ID</th>
                                            <th class="text-nowrap w-auto">Issuance No</th>
                                            <th class="text-nowrap w-auto">Date</th>
                                            <th class="text-nowrap w-auto">Time</th>
                                            <th class="text-nowrap w-auto">Quantity</th>
                                            <th class="text-nowrap w-auto">Description</th>
                                            <th class="text-nowrap w-auto">Reference No</th>
                                            <th class="text-nowrap w-auto">Unit Price</th>
                                            <th class="text-nowrap w-auto">Amount</th>
                                            <th class="text-nowrap w-auto">Issued By</th>
                                            <th class="text-nowrap w-auto">Issued By Date</th>
                                            <th class="text-nowrap w-auto">Received By</th>
                                            <th class="text-nowrap w-auto">Received By Date</th>
                                            <th class="text-nowrap w-auto">Posted By</th>
                                            <th class="text-nowrap w-auto">Posted By Date</th>
                                            <th class="text-nowrap w-auto">Status</th>
                                            <th class="text-nowrap w-auto">Department</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        <?php 
                                        // Fetch and display data from the inventory_issuance_review table
                                      // Change $resultInventoryIssuance to $resultIssuance
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
                    <!-- Asset Requests Table (Initially Hidden) -->
                            <div id="assetRequestTable" class="hidden">
                                <div class="table-responsive">
                                    <table class="table table-hover tble-item" id="assetRequestDataTable">
                                        <thead>
                                            <tr>
                                                <th class="text-nowrap w-auto">Asset Request ID</th>
                                                <th class="text-nowrap w-auto">Date</th>
                                                <th class="text-nowrap w-auto">Time</th>
                                                <th class="text-nowrap w-auto">Status</th>
                                                <th class="text-nowrap w-auto">Office/Department</th>
                                                <th class="text-nowrap w-auto">Requested By</th>
                                                <th class="text-nowrap w-auto">Asset Request Detail ID</th>
                                                <th class="text-nowrap w-auto">Control No</th>
                                                <th class="text-nowrap w-auto">Category</th>
                                                <th class="text-nowrap w-auto">Quantity</th>
                                                <th class="text-nowrap w-auto">Description</th>
                                                <th class="text-nowrap w-auto">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            while ($row = $resultAssetRequest->fetch_assoc()) {
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
                                                echo '<td>' . htmlspecialchars($row['amount']) . '</td>';
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
    });
</script>
<script>
// Ensure jQuery is loaded first
$(document).ready(function() {
    // Initialize DataTables for all tables
    $('#inventoryRequestDataTable').DataTable();
    $('#issuanceRequestDataTable').DataTable();
    $('#assetRequestDataTable').DataTable();

    // Toggle between Inventory and Issuance Requests
    $('#inventoryRequestBtn').on('click', function() {
        // Show inventory request table and hide issuance and asset request tables
        $('#inventoryRequestTable').removeClass('hidden');
        $('#issuanceRequestTable').addClass('hidden');
        $('#assetRequestTable').addClass('hidden');

        // Set the active button styles
        $('#inventoryRequestBtn').addClass('btn-primary').removeClass('btn-outline-secondary');
        $('#issuanceRequestBtn').addClass('btn-outline-secondary').removeClass('btn-primary');
        $('#assetRequestBtn').addClass('btn-outline-secondary').removeClass('btn-primary');
    });

    $('#issuanceRequestBtn').on('click', function() {
        // Show issuance request table and hide inventory and asset request tables
        $('#issuanceRequestTable').removeClass('hidden');
        $('#inventoryRequestTable').addClass('hidden');
        $('#assetRequestTable').addClass('hidden');

        // Set the active button styles
        $('#issuanceRequestBtn').addClass('btn-primary').removeClass('btn-outline-secondary');
        $('#inventoryRequestBtn').addClass('btn-outline-secondary').removeClass('btn-primary');
        $('#assetRequestBtn').addClass('btn-outline-secondary').removeClass('btn-primary');
    });

    $('#assetRequestBtn').on('click', function() {
        // Show asset request table and hide inventory and issuance request tables
        $('#assetRequestTable').removeClass('hidden');
        $('#inventoryRequestTable').addClass('hidden');
        $('#issuanceRequestTable').addClass('hidden');

        // Set the active button styles
        $('#assetRequestBtn').addClass('btn-primary').removeClass('btn-outline-secondary');
        $('#inventoryRequestBtn').addClass('btn-outline-secondary').removeClass('btn-primary');
        $('#issuanceRequestBtn').addClass('btn-outline-secondary').removeClass('btn-primary');
    });

    // By default, show Inventory Request and hide Issuance and Asset Request
    $('#inventoryRequestTable').removeClass('hidden');
    $('#issuanceRequestTable').addClass('hidden');
    $('#assetRequestTable').addClass('hidden');
});
</script>


</body>
</html>
