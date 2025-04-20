<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

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
        nav{}

    </style>
</head>
<body>


<?php
// Include your database connection script
include 'backend/connection.php';

// Query the database to fetch item data with user details
$query = "
    SELECT i.itemNo, i.itemName, i.description, i.quantity, i.dateAcquired, i.unitValue, i.totalValue, i.image, i.category, i.loggedAt, i.loggedBy, u.firstName, u.middleName, u.lastName, u.userID
    FROM item i
    LEFT JOIN user u ON i.loggedBy = u.userID
";
$result = $conn->query($query);

// Check if the query was successful
if (!$result) {
    echo "<p>Error: " . $conn->error . "</p>";
    exit;
}
?>


<!-- Sidebar -->
<?php include "backend/session-sidebar.php"?>

<?php require "header.php" ?>
    <!-- Main content -->
    <div class="main-content"> 
    
    <div class="content1"> 
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-4">
               
            </ol>
        </nav>
    
        <!-- End Breadcrumbs -->

        <?php require "modals/add-items.php" ?>

        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12 col-lg-12 mx-auto">
                    <!-- Card Container -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Item Inventory</h5>
                            <?php if (isset($_SESSION['userType']) && $_SESSION['userType'] === 'admin'): ?>
                                <button type="button" class="btn btn-primary mt-1" onclick="window.location.href='add-inventory-form.php'">
                            Add Inventory
                            </button>

                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                        <div class="table-responsive">
                                <table class="table table-hover tble-item">
                                    <thead class="thead-padding">
                                        <tr>
                                            <th scope="col" class="text-nowrap w-auto">Image</th>
                                            <th scope="col" class="text-nowrap w-auto">Item #</th>
                                            <th scope="col" class="text-nowrap w-auto">Item Name</th>
                                            <th scope="col" class="text-nowrap w-auto">Category</th>
                                            <th scope="col" class="text-nowrap w-auto">Quantity</th>
                                            <th scope="col" class="text-nowrap w-auto">Item Description</th>
                                            <th scope="col" class="text-nowrap w-auto">Date Acquired</th>
                                            <th scope="col" class="text-nowrap w-auto">Unit Value</th>
                                            <th scope="col" class="text-nowrap w-auto">Total Value</th>
                                            <th scope="col" class="text-nowrap w-auto">Logged At</th>
                                            <th scope="col" class="text-nowrap w-auto">Logged By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        // Fetch and display data from the item table
                                        while ($row = $result->fetch_assoc()) {
                                            $imageSrc = 'uploads/asset_img/' . $row['image']; // Adjust path as needed
                                            $middleInitial = isset($row['middleName']) ? substr($row['middleName'], 0, 1) . '.' : ''; // Get the first letter of middleName
                                            $loggedBy = htmlspecialchars($row['firstName'] . ' ' . $middleInitial . ' ' . $row['lastName'] . ' (ID: ' . $row['userID'] . ')');
                                            $itemDetailsUrl = 'item-details.php?itemNo=' . urlencode($row['itemNo']); // Construct the item-details link

                                            echo '<tr>';
                                            echo '<td><img src="' . htmlspecialchars($imageSrc) . '" alt="Item Image" style="width: 100px; height: auto;"></td>';
                                            echo '<th scope="row" onclick="window.location=\'' . htmlspecialchars($itemDetailsUrl) . '\';" style="cursor: pointer;">' . htmlspecialchars($row['itemNo']) . '</th>';
                                            echo '<td onclick="window.location=\'' . htmlspecialchars($itemDetailsUrl) . '\';" style="cursor: pointer;">' . htmlspecialchars($row['itemName']) . '</td>';
                                            echo '<td onclick="window.location=\'' . htmlspecialchars($itemDetailsUrl) . '\';" style="cursor: pointer;">' . htmlspecialchars($row['category']) . '</td>';
                                            echo '<td onclick="window.location=\'' . htmlspecialchars($itemDetailsUrl) . '\';" style="cursor: pointer;">' . htmlspecialchars($row['quantity']) . '</td>';
                                            echo '<td onclick="window.location=\'' . htmlspecialchars($itemDetailsUrl) . '\';" style="cursor: pointer;">' . htmlspecialchars($row['description']) . '</td>';
                                            echo '<td onclick="window.location=\'' . htmlspecialchars($itemDetailsUrl) . '\';" style="cursor: pointer;">' . htmlspecialchars($row['dateAcquired']) . '</td>';
                                            echo '<td onclick="window.location=\'' . htmlspecialchars($itemDetailsUrl) . '\';" style="cursor: pointer;">' . htmlspecialchars(number_format($row['unitValue'], 2)) . '</td>';
                                            echo '<td onclick="window.location=\'' . htmlspecialchars($itemDetailsUrl) . '\';" style="cursor: pointer;">' . htmlspecialchars(number_format($row['totalValue'], 2)) . '</td>';
                                            echo '<td onclick="window.location=\'' . htmlspecialchars($itemDetailsUrl) . '\';" style="cursor: pointer;">' . htmlspecialchars($row['loggedAt']) . '</td>';
                                            echo '<td>' . htmlspecialchars($loggedBy) . '</td>'; // Keep loggedBy not clickable
                                            echo '</tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            
                            </div>
                            </div>
                            <div class="card-footer text-muted">
                                <!-- Footer content if needed -->
                            </div>

                    </div>
                    <!-- End Card Container -->
                </div>
            </div>

            <!-- Audit Logs Section 
            <div class="row mt-4">
                <div class="col-md-12 col-lg-12 mx-auto">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Audit Logs</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Date & Time</th>
                                            <th scope="col">Action</th>
                                            <th scope="col">Item Name</th>
                                            <th scope="col">Performed By</th>
                                            <th scope="col">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    Example audit logs
                                        <tr>
                                            <td>08/12/2024 14:23</td>
                                            <td>Added</td>
                                            <td>Projector</td>
                                            <td>John Doe</td>
                                            <td>Added a new projector with SN:mrjqh11006237004fd5910</td>
                                        </tr>
                                        <tr>
                                            <td>08/10/2024 09:45</td>
                                            <td>Edited</td>
                                            <td>Projector</td>
                                            <td>Jane Smith</td>
                                            <td>Updated quantity from 1 to 2</td>
                                        </tr>
                                        <tr>
                                            <td>08/08/2024 11:12</td>
                                            <td>Deleted</td>
                                            <td>Laptop</td>
                                            <td>Bob Johnson</td>
                                            <td>Deleted a laptop with SN:mrjqh11006237004fd5910</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                          Footer content if needed 
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
    </div>


   

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>

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
                },
                columnDefs: [
                    { orderable: false, targets: [0] } // Disable sorting on the first column
                ]
            });
        });
    </script>

<script>
// Add event listener to make rows clickable
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('.clickable-row');
    rows.forEach(row => {
        row.addEventListener('click', function() {
            window.location.href = this.dataset.href; // Redirect to the item details page
        });
    });
});
</script>

</body>
</html>
