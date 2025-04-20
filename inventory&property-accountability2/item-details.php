<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Details</title>

    <link rel="stylesheet" type="text/css" href="style/inventory.css">
  
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
    </style>
</head>
<body>
 
<!-- Sidebar -->
<?php include "backend/session-sidebar.php" ?>

    <!-- Main content -->
    <div class="main-content">
        <?php require "header.php" ?>

        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Inventory</a></li>
                <li class="breadcrumb-item active" aria-current="page">Item Details</li>
            </ol>
        </nav>
        <!-- End Breadcrumbs -->

        <!-- Item Details -->
        <div class="card">
            <div class="card-header">
                <h5>Item Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php
                    // Assuming you have already connected to the database
                    include 'backend/connection.php';

                    // Get the item number from the query parameter
                    $itemNo = $_GET['itemNo'];

                    // Prepare and execute the SQL statement with a JOIN to fetch user details
                    $query = "SELECT 
                                items.itemNo, items.itemName, items.description, items.quantity, 
                                items.dateAcquired, items.unitValue, items.totalValue, items.image, 
                                items.category, items.loggedAt, items.loggedBy, 
                                users.firstName, users.middleName, users.lastName 
                            FROM item items
                            LEFT JOIN user users ON items.loggedBy = users.userID 
                            WHERE items.itemNo = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("s", $itemNo);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Check if an item was found
                    if ($result->num_rows > 0) {
                        $item = $result->fetch_assoc();
                        $imageSrc = 'uploads/' . $item['image']; // Assuming the image is stored in the 'uploads/' folder
                    ?>
                        <div class="col-md-4">
                            <!-- Fetch the image from the database -->
                            <img src="<?php echo htmlspecialchars($imageSrc); ?>" alt="Item Image" class="img-fluid">
                        </div>
                        <div class="col-md-8">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Item ID:</strong> <?php echo htmlspecialchars($item['itemNo']); ?></li>
                                <li class="list-group-item"><strong>Item Name:</strong> <?php echo htmlspecialchars($item['itemName']); ?></li>
                                <li class="list-group-item"><strong>Quantity:</strong> <?php echo htmlspecialchars($item['quantity']); ?></li>
                                <li class="list-group-item"><strong>Description:</strong> <?php echo htmlspecialchars($item['description']); ?></li>
                                <li class="list-group-item"><strong>Date Acquired:</strong> <?php echo htmlspecialchars($item['dateAcquired']); ?></li>
                                <li class="list-group-item"><strong>Unit Value:</strong> $<?php echo htmlspecialchars($item['unitValue']); ?></li>
                                <li class="list-group-item"><strong>Total Value:</strong> $<?php echo htmlspecialchars($item['totalValue']); ?></li>
                                <li class="list-group-item"><strong>Category:</strong> <?php echo htmlspecialchars($item['category']); ?></li>
                                <li class="list-group-item"><strong>Date Added to Inventory:</strong> <?php echo htmlspecialchars($item['loggedAt']); ?></li>
                                <li class="list-group-item"><strong>Logged By:</strong> 
                                    <?php echo htmlspecialchars($item['firstName'] . ' ' . $item['middleName'] . ' ' . $item['lastName']); ?>
                                    (<?php echo htmlspecialchars($item['loggedBy']); ?>)
                                </li>
                            </ul>
                        </div>
                    <?php
                    } else {
                        echo '<div class="col-md-8"><p class="text-danger">Item not found.</p></div>';
                    }

                    // Close the statement and connection
                    $stmt->close();
                    $conn->close();
                    ?>
                </div>
            </div>

        </div>
        <!-- End Item Details -->

    </div>
    <!-- End Main content -->

</body>
</html>
