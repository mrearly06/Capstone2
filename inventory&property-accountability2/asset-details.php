<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" type="text/css" href="style/inventory.css">
  
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
        background-color: rgb(240,240,240);
        max-height: 200vh;
       
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
        /* Wrapper for both cards */
        .card-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        /* Right-side card */
        .additional-info-card {
            width: 40%;
            opacity: 0;
            transition: opacity 0.3s ease;
            margin-left: 20px; /* Gap between the two cards */
        }

        /* Active state for right-side card */
        .additional-info-card.active {
            opacity: 1;
        }

        /* Adjusted width for the item details card */
        .card.shrinked {
            width: 55%; /* Adjusted size */
        }
    </style>
</head>
<body>
 
<!-- Sidebar -->
<?php include "sidebar.php" ?>

   
        <?php require "header.php" ?>
 <!-- Main content -->
 <div class="main-content">
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Inventory</a></li>
                <li class="breadcrumb-item active" aria-current="page">Item Inventory</li>
            </ol>
        </nav>
        <!-- End Breadcrumbs -->

        <!-- Wrapper for Item Details and Additional Info Card -->
        <div class="card-wrapper">
            <!-- Item Details -->
            <div class="card" id="itemDetailsCard">
                <div class="card-header">
                    <h5>Item Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="img/projector.jpg" alt="Item Image" class="img-fluid">
                        </div>
                        <div class="col-md-8">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Item ID:</strong> 001</li>
                                <li class="list-group-item"><strong>Item Name:</strong> Projector</li>
                                <li class="list-group-item"><strong>Quantity:</strong> 5</li>
                                <li class="list-group-item"><strong>Description:</strong> 1080p HD Projector</li>
                                <li class="list-group-item"><strong>Date Acquired:</strong> 2023-08-10</li>
                                <li class="list-group-item"><strong>Unit Value:</strong> $500</li>
                                <li class="list-group-item"><strong>Total Value:</strong> $2500</li>
                                <li class="list-group-item"><strong>Category:</strong> Audio-Visual Equipment</li>
                                <li class="list-group-item"><strong>Property/Asset Issued To:</strong> 
                                    <a href="#" id="propertyLink">Department of Computer Science</a>
                                </li>
                                <li class="list-group-item"><strong>Date Added to Inventory:</strong> 2023-08-12</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Item Details -->

            <!-- Additional Info Card -->
            <div class="card additional-info-card" id="additionalInfoCard">
                <div class="card-header">
                    <h5>Department Details</h5>
                </div>
                <div class="card-body">
                    <p>Details about the Department of Computer Science...</p>
                    <!-- Add more details as needed -->
                </div>
            </div>
            <!-- End Additional Info Card -->
        </div>
        <!-- End Wrapper -->

    </div>
    <!-- End Main content -->

    <script>
        // JavaScript to handle the click event
        document.getElementById('propertyLink').addEventListener('click', function(e) {
            e.preventDefault(); // Prevent the default link behavior

            // Show the additional info card
            document.getElementById('additionalInfoCard').classList.add('active');
            // Shrink the item details card
            document.getElementById('itemDetailsCard').classList.add('shrinked');
        });
    </script>
  
</body>
</html>
