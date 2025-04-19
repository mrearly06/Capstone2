<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Issuance</title>
    <!-- Add your CSS links here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">

      <!------ Custom Style   ------------------------------>
      <link rel="stylesheet" type="text/css" href="assets/css/sidebar-content.css">
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

<?php include "backend/session-sidebar.php"?>
<?php require "header.php"?>

<div class="main-content">
    <div class="content1"> 
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Inventory</a></li>
                <li class="breadcrumb-item active" aria-current="page">Item Inventory</li>
            </ol>
        </nav>

        <div class="container mt-4">
            <div class="d-flex justify-content-between mb-2">
                <div class="btn-group" role="group" aria-label="Approval Status">
                    <button type="button" class="btn btn-outline-secondary">Pending</button>
                    <button type="button" class="btn btn-outline-secondary">Approved</button>
                    <button type="button" class="btn btn-outline-secondary">Rejected</button>
                </div>
                <a href="issuance-form.php" class="btn btn-primary" id="requestButton">
                    <i class="fas fa-plus"></i> Add Issuance
                </a>
            </div>

            <div class="card p-3">
                <div class="card-header">
                    <h5>Property Issuance</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive overflow-auto">
                        <table id="propertyIssuanceTable" class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Issuance No.</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Item Description</th>
                                    <th scope="col">Reference No.</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Issued By</th>
                                    <th scope="col">Issued By Date</th>
                                    <th scope="col">Received By</th>
                                    <th scope="col">Received By Date</th>
                                    <th scope="col">Posted By</th>
                                    <th scope="col">Posted By Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Department</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch data from the database
                                include 'backend/connection.php'; // Include database connection file
                                $query = "SELECT * FROM issuance"; // Query to fetch all data from the 'issuance' table
                                $result = $conn->query($query);

                                if ($result->num_rows > 0) {
                                    // Loop through each row and display the data
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['issuanceNo'] . "</td>";
                                        echo "<td>" . $row['date'] . "</td>";
                                        echo "<td>" . $row['time'] . "</td>";
                                        echo "<td>" . $row['quantity'] . "</td>";
                                        echo "<td>" . $row['itemDescription'] . "</td>";
                                        echo "<td>" . $row['refNo'] . "</td>";
                                        echo "<td>" . $row['unitPrice'] . "</td>";
                                        echo "<td>" . $row['amount'] . "</td>";
                                        echo "<td>" . $row['issuedBy'] . "</td>";
                                        echo "<td>" . $row['issuedByDate'] . "</td>";
                                        echo "<td>" . $row['receivedBy'] . "</td>";
                                        echo "<td>" . $row['receivedByDate'] . "</td>";
                                        echo "<td>" . $row['postedBy'] . "</td>";
                                        echo "<td>" . $row['postedByDate'] . "</td>";
                                        echo "<td>" . $row['status'] . "</td>";
                                        echo "<td>" . $row['department'] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='16'>No data available</td></tr>";
                                }
                                $conn->close(); // Close the database connection
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <!-- Footer content if needed -->
                </div>
            </div>
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

<!-- Bootstrap JS (with Popper) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#propertyIssuanceTable').DataTable({
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
