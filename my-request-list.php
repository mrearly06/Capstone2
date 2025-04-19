<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Issuance</title>
    <!-- Add your CSS links here -->
    <!------ Custom Style ------------------------------>
    <link rel="stylesheet" type="text/css" href="assets/css/sidebar-content.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- Include DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <!-- Include DataTables Responsive CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
    <style>
        .card {
            margin-bottom: 20px;
        }
        .table-responsive {
            max-height: 400px;
        }
        .btn-group .btn {
            margin-right: 5px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<?php include "backend/session-sidebar.php"?>

<?php require "header.php" ?>
  <!-- Main content -->
  <div class="main-content">
      
    <div class="card content1"> 
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Inventory</a></li>
                <li class="breadcrumb-item active" aria-current="page">Item Inventory</li>
            </ol>
        </nav>
        <!-- End Breadcrumbs -->

        <div class="container mt-4">
            <!-- Button Group for Inventory Requests, Asset Requests, and Issuance Requests -->
            <div class="d-flex justify-content-between mb-2">
                <div class="btn-group" role="group" aria-label="Request Types">
                    <button type="button" class="btn btn-primary" id="inventoryRequestsBtn">Inventory Requests</button>
                    <button type="button" class="btn btn-outline-secondary" id="assetRequestsBtn">Asset Requests</button>
                    <button type="button" class="btn btn-outline-secondary" id="issuanceRequestsBtn">Issuance Requests</button>
                </div>
            </div>

            <!-- Inventory Requests Table (Already Provided) -->
            <div id="inventoryRequestsTable" class="table-responsive overflow-auto">
                <table id="inventoryReqTable" class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Inventory Req ID</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch inventory requests
                        include 'backend/connection.php';
                        $userID = $_SESSION['userID'];

                        $query = "SELECT inventoryReqID, reqDate, reqTime, requestStatus FROM inventory_request WHERE requestedBy = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("s", $userID);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<th scope="row">' . htmlspecialchars($row['inventoryReqID']) . '</th>';
                                echo '<td>' . htmlspecialchars($row['reqDate']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['reqTime']) . '</td>';
                                $badgeColor = '';
                                switch ($row['requestStatus']) {
                                    case 'Approved': $badgeColor = 'bg-success'; break;
                                    case 'Pending': $badgeColor = 'bg-warning text-dark'; break;
                                    case 'Rejected': $badgeColor = 'bg-danger'; break;
                                    case 'Under Repair': $badgeColor = 'bg-info'; break;
                                    default: $badgeColor = 'bg-secondary'; break;
                                }
                                echo '<td><span class="badge ' . $badgeColor . ' rounded-pill">' . htmlspecialchars($row['requestStatus']) . '</span></td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="4" class="text-center">No request yet</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Asset Requests Table -->
            <div id="assetRequestsTable" class="table-responsive overflow-auto" style="display: none;">
                <table id="assetReqTable" class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Asset Req ID</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time</th>
                            <th scope="col">Status</th>
                            <th scope="col">Office/Department</th>
                            <th scope="col">Requested By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch asset requests
                        $query = "SELECT assetRequestId, date, time, status, officeDepartment, requestedBy FROM asset_request WHERE requestedBy = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("s", $userID);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<th scope="row">' . htmlspecialchars($row['assetRequestId']) . '</th>';
                                echo '<td>' . htmlspecialchars($row['date']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['time']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['officeDepartment']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['requestedBy']) . '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="6" class="text-center">No asset requests yet</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Issuance Requests Table -->
            <div id="issuanceRequestsTable" class="table-responsive overflow-auto" style="display: none;">
                <!-- Implement the Issuance Requests table similar to the inventory requests table -->
                <p>No issuance requests yet.</p>
            </div>
        </div>
    </div>
</div>  <!-- End of Main -->

<!-- Bootstrap JS (with Popper) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JavaScript -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>

<script>
        $(document).ready(function() {
            // Initialize DataTables with Bootstrap 5 integration
            $('.tble-user').DataTable({
                responsive: true,
                language: {
                    paginate: {
                        previous: '&laquo;',
                        next: '&raquo;'
                    }
                },
                columnDefs: [
                    { orderable: false, targets: [0] } // Disable sorting on the first column
                ]
            });
        });
    </script>
    
<script>
    $(document).ready(function() {
        // Handle button group for toggling tables
        $('#inventoryRequestsBtn').click(function() {
            $(this).addClass('btn-primary').removeClass('btn-outline-secondary');
            $('#assetRequestsBtn').addClass('btn-outline-secondary').removeClass('btn-primary');
            $('#issuanceRequestsBtn').addClass('btn-outline-secondary').removeClass('btn-primary');
            $('#inventoryRequestsTable').show();
            $('#assetRequestsTable').hide();
            $('#issuanceRequestsTable').hide();
        });

        $('#assetRequestsBtn').click(function() {
            $(this).addClass('btn-primary').removeClass('btn-outline-secondary');
            $('#inventoryRequestsBtn').addClass('btn-outline-secondary').removeClass('btn-primary');
            $('#issuanceRequestsBtn').addClass('btn-outline-secondary').removeClass('btn-primary');
            $('#assetRequestsTable').show();
            $('#inventoryRequestsTable').hide();
            $('#issuanceRequestsTable').hide();
        });

        $('#issuanceRequestsBtn').click(function() {
            $(this).addClass('btn-primary').removeClass('btn-outline-secondary');
            $('#inventoryRequestsBtn').addClass('btn-outline-secondary').removeClass('btn-primary');
            $('#assetRequestsBtn').addClass('btn-outline-secondary').removeClass('btn-primary');
            $('#issuanceRequestsTable').show();
            $('#inventoryRequestsTable').hide();
            $('#assetRequestsTable').hide();
        });

        // Initialize DataTable for Inventory Requests
        $('#inventoryReqTable').DataTable();

        // Initialize DataTable for Asset Requests
        $('#assetReqTable').DataTable();
    });
</script>
</body>
</html>
