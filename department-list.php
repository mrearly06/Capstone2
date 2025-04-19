<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departments</title>
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
<?php include "backend/session-sidebar.php" ?>
<?php require "header.php" ?>
<div class="main-content">
  
<!-- Main content -->

    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb p-3">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Departments</a></li>
            <li class="breadcrumb-item active" aria-current="page">Department List</li>
        </ol>
    </nav>
    <!-- End Breadcrumbs -->
    <div class="container mt-4">
    <?php
                    // department-list.php
                    if (isset($_GET['status'])) {
                        $status = $_GET['status'];
                        if ($status == 'success') {
                            echo '<div id="alertMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                                    Department added successfully!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                        } elseif ($status == 'error') {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    There was an error adding the department. Please try again.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                        }
                    }
                ?>
     <!-- Button Group and Dropdown Button -->
<div class="d-flex justify-content-between mb-2">
    <div class="btn-group" role="group" aria-label="Approval Status">
        <button type="button" class="btn btn-outline-secondary">All</button>
        <!-- Add more buttons if needed -->
    </div>

    <!-- Dropdown Button -->
    <div class="btn-group">
        <button type="button" class="btn btn-primary dropdown-toggle mt-1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-plus"></i>
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#departmentModal">Add New Department</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#departmentHeadModal">Add Department Head</a></li>
            <!-- Add more dropdown items if needed -->
        </ul>
    </div>
</div>


       <!-- Departments Table -->
<div class="card">
    <div class="card-header">
        <h5>Departments</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive overflow-auto">
            <table id="departmentsTable" class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Department ID</th>
                        <th scope="col">Department Name</th>
                        <th scope="col">Campus</th>
                        <th scope="col">Department Head</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "backend/connection.php";
                    
                    // SQL query to fetch department and department head's name
                    $sql = "
                        SELECT d.departmentID, d.departmentName, d.campus, 
                            CONCAT(u.firstName, ' ', u.lastName) AS departmentHead
                        FROM department d
                        LEFT JOIN department_head dh ON d.departmentID = dh.departmentID
                        LEFT JOIN user u ON dh.userID = u.userID
                    ";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data for each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<th scope='row'>" . $row['departmentID'] . "</th>";
                            echo "<td>" . $row['departmentName'] . "</td>";
                            echo "<td>" . $row['campus'] . "</td>";
                            echo "<td>" . (!empty($row['departmentHead']) ? $row['departmentHead'] : 'No department head') . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No departments found</td></tr>";
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

                <?php include "modals/add-departments.php" ?>
                <?php include "modals/add-department-head.php" ?>
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
        $('#departmentsTable').DataTable({
            responsive: true,
            language: {
                paginate: {
                    previous: '&laquo;',
                    next: '&raquo;'
                }
            },
            columnDefs: [
                { orderable: false, targets: [] } // You can specify which columns should not be sortable
            ]
        });
    });
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Remove 'status' parameter from the URL after displaying the alert
    const url = new URL(window.location);
    url.searchParams.delete('status');
    window.history.replaceState({}, document.title, url.toString());

    // Remove 'status' parameter when alert is closed
    const closeButtons = document.querySelectorAll('.alert .btn-close');

    closeButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const url = new URL(window.location);
            url.searchParams.delete('status');
            window.history.replaceState({}, document.title, url.toString());
        });
    });
});
</script>

</body>
</html>
