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

        <?php require "modals/add-items.php" ?>

        <div class="container mt-1">
    <div class="row">
        <div class="col-md-12 col-lg-12 mx-auto">
            <!-- Card Container -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">User List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover tble-user">
                            <thead class="thead-padding">
                                <tr>
                                    <th scope="col" class="text-nowrap w-auto">User ID</th>
                                    <th scope="col" class="text-nowrap w-auto">User Image</th>
                                    <th scope="col" class="text-nowrap w-auto">First Name</th>
                                    <th scope="col" class="text-nowrap w-auto">Middle Name</th>
                                    <th scope="col" class="text-nowrap w-auto">Last Name</th>
                                    <th scope="col" class="text-nowrap w-auto">Address</th>
                                    <th scope="col" class="text-nowrap w-auto">Birthdate</th>
                                    <th scope="col" class="text-nowrap w-auto">Phone No</th>
                                    <th scope="col" class="text-nowrap w-auto">Department</th>
                                    <th scope="col" class="text-nowrap w-auto">Position</th>
                                    <th scope="col" class="text-nowrap w-auto">Created At</th>
                                    <th scope="col" class="text-nowrap w-auto">Account ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example table rows -->
                                <tr>
                                    <th scope="row">1</th>
                                    <td><img src="img/user1.jpg" alt="John Doe" style="width: 50px; height: auto; border-radius: 50%;"></td>
                                    <td>John</td>
                                    <td>A.</td>
                                    <td>Doe</td>
                                    <td>123 Main St</td>
                                    <td>01.01.1990</td>
                                    <td>123-456-7890</td>
                                    <td>IT Department</td>
                                    <td>Developer</td>
                                    <td>08.22.2024</td>
                                    <td>ACC001</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jane</td>
                                    <td>B.</td>
                                    <td>Smith</td>
                                    <td>456 Oak St</td>
                                    <td>02.14.1992</td>
                                    <td>987-654-3210</td>
                                    <td>HR Department</td>
                                    <td>Manager</td>
                                    <td><img src="img/user2.jpg" alt="Jane Smith" style="width: 50px; height: auto; border-radius: 50%;"></td>
                                    <td>08.22.2024</td>
                                    <td>ACC002</td>
                                </tr>
                                <!-- Add more rows as needed -->
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
</div>

            <!-- Audit Logs Section -->
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
                                        <!-- Example audit logs -->
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
                            <!-- Footer content if needed -->
                        </div>
                    </div>
                </div>
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
