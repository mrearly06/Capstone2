<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Issuance</title>
    <!-- Add your CSS links here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
      <!-- Include DataTables CSS -->
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- Include DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <!-- Include DataTables Responsive CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
    <style>
          .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background-color: #343a40; /* Sidebar color */
            color: #fff;
            transition: all 0.3s;
            overflow-y: auto;
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
            background-color: #3e4348; 
            padding: 1rem;
            filter: saturate(1.2); /* Increase saturation by 20% */
        }
        .card {
            margin-bottom: 20px;
        }
        .table-responsive {
            max-height: 400px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<?php include "backend/session-sidebar.php"?>


  <!-- Main content -->
  <div class="main-content">
        <?php require "header.php" ?>

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
        <!-- Button Group and Dropdown Button -->
        <div class="d-flex justify-content-between mb-2">
            <div class="btn-group" role="group" aria-label="Approval Status">
                <button type="button" class="btn btn-outline-secondary">Pending</button>
                <button type="button" class="btn btn-outline-secondary">Approved</button>
                <button type="button" class="btn btn-outline-secondary">Rejected</button>
            </div>
        </div>

        <!-- Property Issuance Table -->
        <div class="card">
    <div class="card-header">
        <h5>Property Issuance</h5>
    </div>
                <?php
                    include 'backend/connection.php';

            // Prepare the SQL query to fetch inventory requests with user details
            $query = "
                SELECT 
                    ir.inventoryReqID, 
                    ir.reqDate, 
                    ir.reqTime, 
                    ir.requestStatus, 
                    u.firstName, 
                    u.middleName, 
                    u.lastName
                FROM 
                    inventory_request ir
                JOIN 
                    user u ON ir.requestedBy = u.userID
            ";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            ?>

            <div class="card-body">
                <div class="table-responsive overflow-auto">
                    <table id="propertyIssuanceTable" class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Inventory Req ID</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Status</th>
                                <th scope="col">Requested By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $inventoryReqID = htmlspecialchars($row['inventoryReqID']);
                                    $reqDate = htmlspecialchars($row['reqDate']);
                                    $reqTime = htmlspecialchars($row['reqTime']);
                                    $requestStatus = htmlspecialchars($row['requestStatus']);
                                    $fullName = htmlspecialchars($row['firstName'] . ' ' . $row['middleName'] . ' ' . $row['lastName']);
                                    
                                    // Determine badge class based on request status
                                    switch ($requestStatus) {
                                        case 'Approved':
                                            $badgeClass = 'bg-success';
                                            break;
                                        case 'Pending':
                                            $badgeClass = 'bg-warning text-dark';
                                            break;
                                        case 'Rejected':
                                            $badgeClass = 'bg-danger';
                                            break;
                                        case 'Under Repair':
                                            $badgeClass = 'bg-info';
                                            break;
                                        default:
                                            $badgeClass = 'bg-secondary'; // Default case
                                    }
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $inventoryReqID; ?></th>
                                        <td><?php echo $reqDate; ?></td>
                                        <td><?php echo $reqTime; ?></td>
                                        <td><span class="badge rounded-pill <?php echo $badgeClass; ?>"><?php echo $requestStatus; ?></span></td>
                                        <td><?php echo $fullName; ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="5" class="text-center">No requests found</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
            // Close the statement and connection
            $stmt->close();
            $conn->close();
            ?>

    <div class="card-footer text-muted">
        <!-- Footer content if needed -->
    </div>
</div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestModalLabel">Request as Department Head</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Modal content goes here -->
                    <form>
                        <div class="mb-3">
                            <label for="requestSubject" class="form-label">Request Subject</label>
                            <input type="text" class="form-control" id="requestSubject" required>
                        </div>
                        <div class="mb-3">
                            <label for="requestDetails" class="form-label">Details</label>
                            <textarea class="form-control" id="requestDetails" rows="3" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Submit Request</button>
                </div>
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
</body>
</html>
