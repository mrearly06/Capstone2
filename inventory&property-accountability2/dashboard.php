
<?php
// Assuming you have a database connection file
include 'backend/connection.php';

$query = "SELECT category, COUNT(*) as count FROM item GROUP BY category";
$result = mysqli_query($conn, $query);

$categories = [];
$counts = [];

while($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row['category'];
    $counts[] = $row['count'];
}

// Encode the arrays into JSON
$categories_json = json_encode($categories);
$counts_json = json_encode($counts);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
   
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background-color: #343a40;
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
            background-color: rgb(240, 240, 240);
            height: 100vh;
            overflow-x: hidden; /* Prevent horizontal scroll */  
        }
        .sidebar-collapse .main-content {
            margin-left: 0;
        }
        .card {
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .title-logo {
            background-color: #3e4348; 
            padding: 1rem;
            filter: saturate(1.2);
        }
        .icon-square {
            width: 50px;  
            height: 50px; 
            border-radius: 5px;
        }
        .card-pie {
            height: 100px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <?php require "backend/session-sidebar.php" ?>
    <!-- Main content -->
    <div class="main-content">
        <?php require "header-admin.php" ?>

        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard Page</li>
            </ol>
        </nav>
        <!-- End Breadcrumbs -->

        <!-- Cards Row -->
        <div class="row">
            <div class="col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-square text-center bg-primary text-white d-flex justify-content-center align-items-center">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="ms-3">
                            <p class="card-category mb-1">Users</p>
                            <h4 class="card-title">1,294</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-square text-center bg-info text-white d-flex justify-content-center align-items-center">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="ms-3">
                            <p class="card-category mb-1">Assets/Items</p>
                            <h4 class="card-title">345</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-square text-center bg-success text-white d-flex justify-content-center align-items-center">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="ms-3">
                            <p class="card-category mb-1">Requests</p>
                            <h4 class="card-title">123</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-square text-center bg-secondary text-white d-flex justify-content-center align-items-center">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="ms-3">
                            <p class="card-category mb-1">Costs</p>
                            <h4 class="card-title">$ 1,345</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Cards Row -->
        <div class="row">
                <!-- Property/Items Category Doughnut Chart -->
                <div class="col-md-6 mt-3">
                    <div class="card card-pie" style="height: 500px;"> <!-- Set a fixed height here -->
                        <div class="card-body">
                            <h5 class="card-title text-center mb-4">Property/Items Category Distribution</h5>
                            <canvas id="propertyItemsDoughnutChart" style="max-height: 400px;"></canvas> <!-- Limit chart height -->
                            <!-- Labels Container -->
                            <div id="chartLabels" class="d-flex flex-wrap justify-content-center mt-3"></div>
                        </div>
                    </div>
                </div>
        
    

            <!-- Monthly Maintenance Cost Card -->
            <div class="col-md-6 mt-3">
                <div class="card card-primary card-round">
                    <div class="card-header">
                        <div class="card-head-row d-flex justify-content-between">
                            <div class="card-title"><h4>Monthly Maintenance Cost</h4></div>
                            <div class="card-tools">
                                <div class="dropdown">
                                    <button
                                        class="btn btn-sm btn-label-light dropdown-toggle"
                                        type="button"
                                        id="dropdownMenuButton"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >
                                        Export
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#">Download CSV</a>
                                        <a class="dropdown-item" href="#">Download PDF</a>
                                        <a class="dropdown-item" href="#">Email Report</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-category">August 2024</div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="mb-4 mt-2">
                            <h3>$12,340.75</h3>
                        </div>
                        <div class="pull-in">
                            <canvas id="monthlyMaintenanceChart"></canvas>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer">
                        <div class="h1 fw-bold float-end text-danger"><h4>-2%</h4></div>
                        <h4 class="mb-2">Maintenance Costs</h4>
                        <p class="text-muted">Compared to last month</p>
                        <div class="pull-in sparkline-fix">
                            <div id="maintenanceCostTrend"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Logs Section -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>User Logs</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>John Doe</td>
                                    <td>Logged in</td>
                                    <td>August 21, 2024</td>
                                    <td>09:45 AM</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jane Smith</td>
                                    <td>Uploaded a file</td>
                                    <td>August 21, 2024</td>
                                    <td>10:15 AM</td>
                                </tr>
                                <!-- Add more log entries here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End User Logs Section -->
    </div>

    <script>
        // PHP JSON data embedded in JavaScript
        var categories = <?php echo $categories_json; ?>;
        var counts = <?php echo $counts_json; ?>;

        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('propertyItemsDoughnutChart').getContext('2d');

            var propertyItemsDoughnutChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: categories, // Dynamic categories from the database
                    datasets: [{
                        label: 'Property/Items',
                        data: counts, // Dynamic counts from the database
                        backgroundColor: [
                            '#007bff', '#17a2b8', '#28a745', '#ffc107', '#fd7e14', 
                            '#6f42c1', '#dc3545', '#20c997', '#6610f2', '#adb5bd'
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom'
                        }
                    }
                }
            });
        });

</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



</body>
</html>
