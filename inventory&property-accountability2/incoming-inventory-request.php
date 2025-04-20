<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request List Group in Cards</title>
   
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
            background-color: #2d3145;
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        /* Custom CSS to remove bottom margin from list groups */
        .list-group-item {
            margin-bottom: 0 !important; /* Remove bottom margin from list items */
        }
        .container-request {
            margin: 0; /* Remove container margin */
        }

        .fade-out {
            opacity: 1;
            transition: opacity 0.5s ease-out;
        }

        .fade-out.hidden {
            opacity: 0;
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

        <?php
         

            if (isset($_SESSION['alert'])) {
                if ($_SESSION['alert'] === 'success') {
                    echo '<div id="alert" class="alert alert-success fade-out" role="alert">
                            Request Approved and added to the item list!
                        </div>';
                } elseif ($_SESSION['alert'] === 'rejected') {
                    echo '<p id="alert" style="color: red;" class="fade-out">Request rejected!</p>';
                }
                
                // Unset the session variable after displaying the alert
                unset($_SESSION['alert']);
            }
            ?>




        <div class="container mt-4">
    <div class="row d-flex flex-column">
        <!-- First Card -->
        <div class="col-md-12 mb-4">
            <div class="card">
            <?php
                // Database connection
                include 'backend/connection.php';
                
                // Prepare the SQL query to fetch pending requests with user details and review number
                $query = "
                    SELECT 
                        ir.inventoryReqID, 
                        ir.reqDate, 
                        ir.reqTime, 
                        ir.requestStatus, 
                        ir.requestedBy, 
                        u.firstName, 
                        u.middleName, 
                        u.lastName, 
                        irv.ItemReviewNo
                    FROM 
                        inventory_request ir
                    JOIN 
                        user u ON ir.requestedBy = u.userID
                    LEFT JOIN 
                        item_review irv ON ir.inventoryReqID = irv.inventoryReqID
                    WHERE 
                        ir.requestStatus = 'Pending'
                ";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
            ?>

            <ul class="list-group list-group-flush">
                <?php
                if ($result->num_rows > 0) {
                    $index = 1; // Index for generating unique IDs
                    while ($row = $result->fetch_assoc()) {
                        $inventoryReqID = htmlspecialchars($row['inventoryReqID']);
                        $reqDate = htmlspecialchars($row['reqDate']);
                        $reqTime = htmlspecialchars($row['reqTime']);
                        $firstName = htmlspecialchars($row['firstName']);
                        $middleName = htmlspecialchars($row['middleName']);
                        $lastName = htmlspecialchars($row['lastName']);
                        $ItemReviewNo = htmlspecialchars($row['ItemReviewNo']);
                        
                        // Generate unique ID for each collapse element
                        $collapseID = "requestDetails" . $index;
                        ?>
                        
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column flex-md-row">
                                <div>
                                    <strong>Request ID:</strong> <?php echo $inventoryReqID; ?>
                                    <button class="btn btn-link p-2 ms-2" data-bs-toggle="collapse" data-bs-target="#<?php echo $collapseID; ?>" aria-expanded="false" aria-controls="<?php echo $collapseID; ?>">
                                        View Details
                                    </button>
                                </div>
                            </div>
                            <div class="btn-group">
                                <form method="post" action="backend/process-request.php" class="d-inline">
                                    <input type="hidden" name="inventoryReqID" value="<?php echo $inventoryReqID; ?>">
                                    <button type="submit" name="approve" class="btn btn-success">Approve</button>
                                    <button type="submit" name="reject" class="btn btn-danger">Reject</button>
                                </form>
                            </div>
                        </li>
                        <div id="<?php echo $collapseID; ?>" class="collapse">
                            <li class="list-group-item">
                                <div>
                                    <strong>Date:</strong> <?php echo $reqDate; ?>
                                </div>
                                <div>
                                    <strong>Time:</strong> <?php echo $reqTime; ?>
                                </div>
                                <div>
                                    <strong>Status:</strong> Pending
                                </div>
                                <div>
                                    <strong>Requested By:</strong> <?php echo $firstName . ' ' . $middleName . ' ' . $lastName; ?>
                                </div>
                                <div>
                                    <strong>Inventory Review No:</strong> <?php echo $ItemReviewNo ? $ItemReviewNo : 'N/A'; ?>
                                </div>
                            </li>
                        </div>
                        
                        <?php
                        $index++; // Increment index for the next request
                    }
                } else {
                    echo '<li class="list-group-item text-center">No pending requests</li>';
                }
                ?>
            </ul>

            <?php
            // Close the statement and connection
            $stmt->close();
            $conn->close();
            ?>

            </div>
        </div>
    </div>
</div>

</div>
 <!-- Main content -->

 <script>
document.addEventListener("DOMContentLoaded", function() {
    const alert = document.getElementById('alert');
    
    if (alert) {
        setTimeout(() => {
            alert.classList.add('hidden');
            setTimeout(() => alert.remove(), 500); // Adjust timing to match CSS transition
        }, 5000); // 5000 milliseconds = 5 seconds
    }
});
</script>


</body>
</html>
