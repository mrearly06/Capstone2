<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issuance Request List Group in Cards</title>

          <!------ Custom Style   ------------------------------>
          <link rel="stylesheet" type="text/css" href="assets/css/sidebar-content.css">
    <style>
    
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

<?php require "header.php" ?>
 <!-- Main content -->
 <div class="main-content">

 <div class="card content1"> 
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Issuance</a></li>
                <li class="breadcrumb-item active" aria-current="page">Issuance Requests</li>
            </ol>
        </nav>
        <!-- End Breadcrumbs -->

        <?php
            if (isset($_SESSION['alert'])) {
                if ($_SESSION['alert'] === 'success') {
                    echo '<div id="alert" class="alert alert-success fade-out" role="alert">
                            Request Approved!
                        </div>';
                } elseif ($_SESSION['alert'] === 'rejected') {
                    echo '<p id="alert" style="color: red;" class="fade-out">Request rejected!</p>';
                }
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
                        
                        // Prepare the SQL query to fetch issuance requests with user details
                        $query = "
                            SELECT 
                                ir.issuanceRequestID, 
                                ir.reqStatus, 
                                ir.reqIssuanceDateStart, 
                                ir.reqIssuanceDateEnd, 
                                ir.reqIssuancePurpose, 
                                ir.reqOtherPurposeDetails, 
                                ir.reqLoggedDate, 
                                ir.reqLoggedTime, 
                                ir.reqIssuedTo, 
                                ir.reqItemNo, 
                                ir.reqBy
                            FROM 
                                issuance_request ir
                            WHERE 
                                ir.reqStatus = 'Pending'
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
                                $issuanceRequestID = htmlspecialchars($row['issuanceRequestID']);
                                $reqStatus = htmlspecialchars($row['reqStatus']);
                                $reqIssuanceDateStart = htmlspecialchars($row['reqIssuanceDateStart']);
                                $reqIssuanceDateEnd = htmlspecialchars($row['reqIssuanceDateEnd']);
                                $reqIssuancePurpose = htmlspecialchars($row['reqIssuancePurpose']);
                                $reqOtherPurposeDetails = htmlspecialchars($row['reqOtherPurposeDetails']);
                                $reqLoggedDate = htmlspecialchars($row['reqLoggedDate']);
                                $reqLoggedTime = htmlspecialchars($row['reqLoggedTime']);
                                $reqIssuedTo = htmlspecialchars($row['reqIssuedTo']);
                                $reqItemNo = htmlspecialchars($row['reqItemNo']);
                                $reqBy = htmlspecialchars($row['reqBy']);
                                
                                // Generate unique ID for each collapse element
                                $collapseID = "requestDetails" . $index;
                                ?>
                                
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex flex-column flex-md-row">
                                        <div>
                                            <strong>Issuance Request ID:</strong> <?php echo $issuanceRequestID; ?>
                                            <button class="btn btn-link p-2 ms-2" data-bs-toggle="collapse" data-bs-target="#<?php echo $collapseID; ?>" aria-expanded="false" aria-controls="<?php echo $collapseID; ?>">
                                                View Details
                                            </button>
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <form method="post" action="backend/process-issuance-request.php" class="d-inline">
                                            <input type="hidden" name="issuanceRequestID" value="<?php echo $issuanceRequestID; ?>">
                                            <button type="submit" name="approve" class="btn btn-success">Approve</button>
                                            <button type="submit" name="reject" class="btn btn-danger">Reject</button>
                                        </form>
                                    </div>
                                </li>
                                <div id="<?php echo $collapseID; ?>" class="collapse">
                                    <li class="list-group-item">
                                        <div><strong>Status:</strong> <?php echo $reqStatus; ?></div>
                                        <div><strong>Issuance Date Start:</strong> <?php echo $reqIssuanceDateStart; ?></div>
                                        <div><strong>Issuance Date End:</strong> <?php echo $reqIssuanceDateEnd; ?></div>
                                        <div><strong>Purpose:</strong> <?php echo $reqIssuancePurpose; ?></div>
                                        <div><strong>Other Purpose Details:</strong> <?php echo $reqOtherPurposeDetails ? $reqOtherPurposeDetails : 'N/A'; ?></div>
                                        <div><strong>Logged Date:</strong> <?php echo $reqLoggedDate; ?></div>
                                        <div><strong>Logged Time:</strong> <?php echo $reqLoggedTime; ?></div>
                                        <div><strong>Issued To:</strong> <?php echo $reqIssuedTo; ?></div>
                                        <div><strong>Item No:</strong> <?php echo $reqItemNo; ?></div>
                                        <div><strong>Requested By:</strong> <?php echo $reqBy; ?></div>
                                    </li>
                                </div>
                                
                                <?php
                                $index++; // Increment index for the next request
                            }
                        } else {
                            echo '<li class="list-group-item text-center">No pending issuance requests</li>';
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
