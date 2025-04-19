<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Issuance</title>
    <!-- Add your CSS links here -->
     <!------ Custom Style   ------------------------------>
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
        <!-- Button Group and Dropdown Button -->
        <div class="d-flex justify-content-between mb-2">
            <div class="btn-group" role="group" aria-label="Approval Status">
                <button type="button" class="btn btn-outline-secondary">Pending</button>
                <button type="button" class="btn btn-outline-secondary">Approved</button>
                <button type="button" class="btn btn-outline-secondary">Rejected</button>
            </div>

            <!-- Dropdown Button 
            <div class="btn-group">
                <button class="btn btn-primary dropdown-toggle" type="button" id="requestDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Make a Request
                </button>
                <ul class="dropdown-menu" aria-labelledby="requestDropdown">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#requestModal">Request as Department Head</a></li>
                    Add more items here if needed 
                </ul>
            </div>
            -->
        </div>

        <!-- Property Issuance Table -->
        
        <div class="card">
    <div class="card-header">
        <h5>Property Issuance</h5>
    </div>
    <?php
        // Assuming you have already established a database connection, and the session is started
        // Example: $conn = new mysqli($servername, $username, $password, $dbname);

        // Assuming the logged-in user's username is stored in the session
   include 'backend/connection.php';
        $userID = $_SESSION['userID'];

        // Prepare the SQL query to fetch inventory requests made by the logged-in user
        $query = "SELECT inventoryReqID, reqDate, reqTime, requestStatus FROM inventory_request WHERE requestedBy = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $userID);
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Loop through each fetched row and display it in the table
                        if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<th scope="row">' . htmlspecialchars($row['inventoryReqID']) . '</th>';
                            echo '<td>' . htmlspecialchars($row['reqDate']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['reqTime']) . '</td>';
                            
                            // Determine the badge color based on the request status
                            $badgeColor = '';
                            switch ($row['requestStatus']) {
                                case 'Approved':
                                    $badgeColor = 'bg-success';
                                    break;
                                case 'Pending':
                                    $badgeColor = 'bg-warning text-dark';
                                    break;
                                case 'Rejected':
                                    $badgeColor = 'bg-danger';
                                    break;
                                case 'Under Repair':
                                    $badgeColor = 'bg-info';
                                    break;
                                default:
                                    $badgeColor = 'bg-secondary';
                                    break;
                            }

                            echo '<td><span class="badge ' . $badgeColor . ' rounded-pill">' . htmlspecialchars($row['requestStatus']) . '</span></td>';
                            echo '</tr>';
                        }
                    } else {
                        // Display "No requests yet" if no data is found
                        echo '<tr>';
                        echo '<td colspan="4" class="text-center">No request yet</td>';
                        echo '</tr>';
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
