
<?php
// Include your database connection script
include 'backend/connection.php';

// Query to fetch the most recent items based on the loggedAt column
$query = "
    SELECT itemNo, itemName 
    FROM item 
    ORDER BY loggedAt DESC 
    LIMIT 4"; // Fetch the 4 most recent items
$result = $conn->query($query);

// Check if the query was successful
if (!$result) {
    echo "<p>Error: " . $conn->error . "</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

     <!------ Custom Style   ------------------------------>
     <link rel="stylesheet" type="text/css" href="assets/css/index-style.css">
   
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


        .card-items{
            display:flex;
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
         <!-- New Items/Equipment Container -->
<div class="container bg-light pt-3" id="items-equipment-container">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="card-title mb-0">Items/Equipment</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Category Container -->
           
            <div class="container category-container mt-1" id="category-container" style="border: none;">
                <div class="row mb">
                <h5>Recent Assets </h5>
                <div class="container">
                    <div class="row">
                        <?php
                        // Fetch and display the most recent items
                        while ($row = $result->fetch_assoc()) {
                            $itemDetailsUrl = 'item-details.php?itemNo=' . urlencode($row['itemNo']);
                            echo '<div class="col-md-3 mb-3">'; // Add mb-3 for spacing between items
                            echo '<a href="' . $itemDetailsUrl . '" style="text-decoration: none; color: inherit;">';
                            echo '<div class="card">';
                            echo '<div class="card-body text-center">';
                            echo '<h5 class="card-title">' . htmlspecialchars($row['itemName']) . '</h5>';
                            echo '<p class="card-text">' . htmlspecialchars($row['itemNo']) . '</p>';
                            echo '</div>';
                            echo '</div>';
                            echo '</a>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-12 mx-auto">
                        <!-- Card Container for Item Categories -->
                        <div class="card mb-4" style="border: none;">
                            <div class="card-body" style="border: none;">
                                <h5 class="text-title mb-0">Item Categories</h5>
                                <!-- Content for Item Categories -->
                                <div class="container category-content mt-4">
                                    <div class="row gap-3">

                                        <!-- Office Supplies -->
                                        <div class="col-md-1">
                                            <div class="card text-center p-5" style="height: 100px; display: flex; align-items: center; justify-content: center;">
                                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                                    <i class="fas fa-pencil-alt" style="font-size: 18px; color: #007bff;"></i> <!-- Icon for Office Supplies -->
                                                    <h5 class="card-title" style="font-size: 12px;">Office Supplies</h5>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Furniture -->
                                        <div class="col-md-1">
                                            <div class="card text-center p-5" style="height: 100px; display: flex; align-items: center; justify-content: center;">
                                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                                    <i class="fas fa-chair" style="font-size: 18px; color: #007bff;"></i> <!-- Icon for Furniture -->
                                                    <h5 class="card-title" style="font-size: 12px;">Furniture</h5>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Computers and IT Equipment -->
                                        <div class="col-md-1">
                                            <div class="card text-center p-5" style="height: 100px; display: flex; align-items: center; justify-content: center;">
                                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                                    <i class="fas fa-desktop" style="font-size: 18px; color: #007bff;"></i> <!-- Icon for Computers and IT Equipment -->
                                                    <h5 class="card-title" style="font-size: 12px;">Computers and IT Equipment</h5>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Laboratory Equipment -->
                                        <div class="col-md-1">
                                            <div class="card text-center p-5" style="height: 100px; display: flex; align-items: center; justify-content: center;">
                                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                                    <i class="fas fa-flask" style="font-size: 18px; color: #007bff;"></i> <!-- Icon for Laboratory Equipment -->
                                                    <h5 class="card-title" style="font-size: 12px;">Laboratory Equipment</h5>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Audio-Visual Equipment -->
                                        <div class="col-md-1">
                                            <div class="card text-center p-5" style="height: 100px; display: flex; align-items: center; justify-content: center;">
                                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                                    <i class="fas fa-video" style="font-size: 18px; color: #007bff;"></i> <!-- Icon for Audio-Visual Equipment -->
                                                    <h5 class="card-title" style="font-size: 12px;">Audio-Visual Equipment</h5>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Classroom Materials -->
                                        <div class="col-md-1">
                                            <div class="card text-center p-5" style="height: 100px; display: flex; align-items: center; justify-content: center;">
                                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                                    <i class="fas fa-chalkboard-teacher" style="font-size: 18px; color: #007bff;"></i> <!-- Icon for Classroom Materials -->
                                                    <h5 class="card-title" style="font-size: 12px;">Classroom Materials</h5>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Sports and Physical Education Equipment -->
                                        <div class="col-md-1">
                                            <div class="card text-center p-5" style="height: 100px; display: flex; align-items: center; justify-content: center;">
                                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                                    <i class="fas fa-basketball-ball"style="font-size: 18px; color: #007bff;"></i> <!-- Icon for Sports Equipment -->
                                                    <h5 class="card-title" style="font-size: 12px;">Sports & Physical Education Equipment</h5>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Maintenance and Janitorial Supplies -->
                                        <div class="col-md-1">
                                            <div class="card text-center p-5" style="height: 100px; display: flex; align-items: center; justify-content: center;">
                                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                                    <i class="fas fa-broom" style="font-size: 18px; color: #007bff;"></i> <!-- Icon for Janitorial Supplies -->
                                                    <h5 class="card-title" style="font-size: 12px;">Maintenance & Janitorial Supplies</h5>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Library Resources -->
                                        <div class="col-md-1">
                                            <div class="card text-center p-5" style="height: 100px; display: flex; align-items: center; justify-content: center;">
                                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                                    <i class="fas fa-book" style="font-size: 18px; color: #007bff;"></i> <!-- Icon for Library Resources -->
                                                    <h5 class="card-title" style="font-size: 12px;">Library Resources</h5>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- All Items/Equipment -->
                                        <div class="col-md-1">
                                            <div class="card text-center p-5" style="height: 100px; display: flex; align-items: center; justify-content: center;">
                                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                                    <i class="fas fa-box-open" style="font-size: 18px; color: #007bff;"></i> <!-- Icon for All Items/Equipment -->
                                                    <h5 class="card-title" style="font-size: 12px;">All Items/ Equipments</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- row -->
                                        <?php
                                        // Include your database connection script
                                        include 'backend/connection.php';

                                        // Query to fetch all items with itemName and itemNo
                                        $query = "SELECT itemName, itemNo FROM item"; // Adjust query as needed
                                        $result = $conn->query($query);

                                        // Check if the query was successful
                                        if (!$result) {
                                            echo "<p>Error: " . $conn->error . "</p>";
                                            exit;
                                        }
                                        ?>

                                        <div class="user-cards-container d-flex justify-content-start gap-3 mt-3 flex-wrap">
                                            <?php
                                            // Loop through each fetched item and display in card layout
                                            while ($row = $result->fetch_assoc()) {
                                                $itemDetailsUrl = 'item-details.php?itemNo=' . urlencode($row['itemNo']);

                                                echo '<a href="'. $itemDetailsUrl .'" style="text-decoration: none; color: inherit;">';
                                                echo '<div class="card" style="width: 12rem; position: relative; min-height: 6.5rem;">';
                                                echo '<span style="position: absolute; top: 0.5rem; left: 0.5rem; background-color: rgba(0, 0, 0, 0.7); color: white; padding: 0.2rem 0.5rem; border-radius: 0.25rem;">#' . htmlspecialchars($row['itemNo']) . '</span>';
                                                echo '<div class="card-body text-center d-flex justify-content-center align-items-center">';
                                                echo '<h6 class="card-title">' . htmlspecialchars($row['itemName']) . '</h6>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</a>';
                                            }
                                            ?>
                                        </div>

                                        <?php
                                        // Close the database connection
                                        $conn->close();
                                        ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Category Container -->
        </div>
    </div>
</div>
<!-- End New Items/Equipment Container -->
 
<!-- End of Main -->
</div>

   

 

</body>
</html>
