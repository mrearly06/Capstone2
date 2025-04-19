<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Request List Group in Cards</title>

    <!------ Custom Style ------------------------------>
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
        .container {
            overflow-y: auto; /* Allows scrolling if content overflows */
            max-height: 500px; /* Example maximum height */
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<?php include "backend/session-sidebar.php"?>

<?php require "header.php" ?>

<!-- Start of Main content -->
<div class="main-content">
    <div class="card content1 mt-5">
        <!-- Breadcrumbs 
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Asset Request</a></li>
                <li class="breadcrumb-item active" aria-current="page">Asset Requests</li>
            </ol>
        </nav>

        -->
        <!-- End Breadcrumbs -->
                <?php
           
                if (isset($_SESSION['message'])) {
                    $messageType = $_SESSION['message_type'] ?? 'info'; // Default type
                    echo "<div class='alert alert-{$messageType}' role='alert'>
                            {$_SESSION['message']}
                        </div>";
                    unset($_SESSION['message'], $_SESSION['message_type']); // Clear message
                }
                ?>

        <?php

            // Database connection
            include 'backend/connection.php';

            // Check if session variable userID is set
            if (!isset($_SESSION['userID'])) {
                // If session is not set, handle it (e.g., redirect to login page)
                echo "Please log in to view your asset requests.";
                exit; // Stop further script execution
            }

            // Assuming you already have a way to get the current user's ID from session
            $currentUserId = $_SESSION['userID'];

            $query = "
                SELECT 
                    ar.assetRequestId, 
                    ar.date, 
                    ar.time, 
                    ar.status, 
                    ar.officeDepartment, 
                    ar.requestedBy, 
                    ard.assetRequestDetailId, 
                    ard.controlNo, 
                    ard.category, 
                    ard.quantity, 
                    ard.description, 
                    ard.amount
                FROM 
                    asset_request ar
                LEFT JOIN 
                    asset_request_detail ard ON ar.assetRequestId = ard.assetRequestId
                LEFT JOIN 
                    asset_request_approver ara ON ar.assetRequestId = ara.assetRequestApproverID
                WHERE 
                    ar.status = 'Forwarded to Finance'
                ORDER BY 
                    ar.assetRequestId DESC";
                        
        
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

            // Group data by assetRequestId
            $groupedData = [];
            while ($row = $result->fetch_assoc()) {
                $groupedData[$row['assetRequestId']][] = $row;
            }
        ?>

        <ul class="list-group list-group-flush">
            <?php if (count($groupedData) > 0): ?>
                <?php foreach ($groupedData as $assetRequestId => $requests): ?>
                    <!-- Display main asset request info -->
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex flex-column flex-md-row">
                            <div>
                                <strong>Asset Request ID:</strong> <?php echo htmlspecialchars($assetRequestId); ?>
                                <button class="btn btn-link p-2 ms-2" data-bs-toggle="collapse" data-bs-target="#requestDetails<?php echo $assetRequestId; ?>" aria-expanded="false" aria-controls="requestDetails<?php echo $assetRequestId; ?>">
                                    View Details
                                </button>
                            </div>
                        </div>
                        <div class="btn-group">
                            <!-- Updated form buttons for forwarding/rejecting requests -->
                            <form method="post" action="backend/process-asset-request.php" class="d-inline">
                                <input type="hidden" name="assetRequestId" value="<?php echo htmlspecialchars($assetRequestId); ?>">
                                <button type="submit" name="approve" class="btn btn-primary">Approve</button> <!-- Changed 'approve' to 'forward' and label -->
                                <button type="submit" name="reject" class="btn btn-danger">Reject</button>
                            </form>
                        </div>
                    </li>

                    <!-- Display detailed information below each assetRequestId -->
                    <div id="requestDetails<?php echo $assetRequestId; ?>" class="collapse" style="max-height: 300px; overflow-y: auto;">
                        <?php 
                        $assetIndex = 1; // Start from Asset 1
                        foreach ($requests as $request): 
                        ?>
                            <li class="list-group-item">
                                <div class="text-center"><strong>Asset <?php echo $assetIndex++; ?>:</strong></div>
                                <div><strong>Date:</strong> <?php echo htmlspecialchars($request['date']); ?></div>
                                <div><strong>Time:</strong> <?php echo htmlspecialchars($request['time']); ?></div>
                                <div><strong>Status:</strong> <?php echo htmlspecialchars($request['status']); ?></div>
                                <div><strong>Office Department:</strong> <?php echo htmlspecialchars($request['officeDepartment']); ?></div>
                                <div><strong>Requested By:</strong> <?php echo htmlspecialchars($request['requestedBy']); ?></div>

                                <!-- Asset Request Details -->
                                <?php
                                // Fetch asset request details based on assetRequestId
                                $assetRequestDetailsQuery = "
                                    SELECT 
                                        assetRequestDetailId,
                                        controlNo,
                                        category,
                                        quantity,
                                        description,
                                        amount
                                    FROM 
                                        asset_request_detail
                                    WHERE 
                                        assetRequestId = ?
                                ";
                                $stmtDetails = $conn->prepare($assetRequestDetailsQuery);
                                $stmtDetails->bind_param('i', $request['assetRequestId']);
                                $stmtDetails->execute();
                                $assetDetailsResult = $stmtDetails->get_result();

                                // Display asset details for each asset request
                                while ($asset = $assetDetailsResult->fetch_assoc()): 
                                ?>
                                    <div><strong>Control No:</strong> <?php echo htmlspecialchars($asset['controlNo']); ?></div>
                                    <div><strong>Category:</strong> <?php echo htmlspecialchars($asset['category']); ?></div>
                                    <div><strong>Quantity:</strong> <?php echo htmlspecialchars($asset['quantity']); ?></div>
                                    <div><strong>Description:</strong> <?php echo htmlspecialchars($asset['description']); ?></div>
                                    <div><strong>Amount:</strong> <?php echo htmlspecialchars($asset['amount']); ?></div>
                                <?php endwhile; ?>
                            </li>
                        <?php endforeach; ?>
                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                <li class="list-group-item text-center">No pending asset requests</li>
            <?php endif; ?>
        </ul>

        <?php
        // Close the statement and connection
        $stmt->close();
        $conn->close();
        ?>

    </div>
</div>
<!-- End Main content -->

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
