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
    // Database connection
    include 'backend/connection.php';

    // Prepare the SQL query to fetch issuance reviews grouped by issuanceReviewNo
    $query = "
        SELECT 
            ir.issuanceReviewID, 
            ir.issuanceReviewNo, 
            ir.date, 
            ir.time, 
            ir.quantity, 
            ir.itemDescription, 
            ir.refNo, 
            ir.unitPrice, 
            ir.amount, 
            ir.issuedBy, 
            ir.issuedByDate, 
            ir.receivedBy, 
            ir.receivedByDate, 
            ir.postedBy, 
            ir.postedByDate, 
            ir.status, 
            ir.department
        FROM 
            issuance_review ir
        WHERE 
            ir.status = 'In Process'
        ORDER BY 
            ir.issuanceReviewNo, ir.date, ir.time
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    $groupedData = [];
    while ($row = $result->fetch_assoc()) {
        $groupedData[$row['issuanceReviewNo']][] = $row;
    }

?>

<ul class="list-group list-group-flush">
    <?php if (count($groupedData) > 0): ?>
        <?php $index = 1; ?>
        <?php foreach ($groupedData as $issuanceReviewNo => $reviews): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex flex-column flex-md-row">
                    <div>
                        <strong>Issuance Review No:</strong> <?php echo htmlspecialchars($issuanceReviewNo); ?>
                        <button class="btn btn-link p-2 ms-2" data-bs-toggle="collapse" data-bs-target="#reviewDetails<?php echo $index; ?>" aria-expanded="false" aria-controls="reviewDetails<?php echo $index; ?>">
                            View Details
                        </button>
                    </div>
                </div>
                <div class="btn-group">
                    <!-- Add relevant form buttons for approval/rejection here -->
                    <form method="post" action="backend/process-issuance-review.php" class="d-inline">
                        <input type="hidden" name="issuanceReviewNo" value="<?php echo htmlspecialchars($issuanceReviewNo); ?>">
                        <button type="submit" name="approve" class="btn btn-success">Approve</button>
                        <button type="submit" name="reject" class="btn btn-danger">Reject</button>
                    </form>
                </div>
            </li>
            <div id="reviewDetails<?php echo $index; ?>" class="collapse" style="max-height: 300px; overflow-y: auto;">
                <?php 
                $itemIndex = 1; // Start from Item 1
                foreach ($reviews as $review): 
                ?>
                    <li class="list-group-item">
                        <div class="text-center"><strong>Item <?php echo $itemIndex++; ?>:</strong></div>
                        <div><strong>Date:</strong> <?php echo htmlspecialchars($review['date']); ?></div>
                        <div><strong>Time:</strong> <?php echo htmlspecialchars($review['time']); ?></div>
                        <div><strong>Quantity:</strong> <?php echo htmlspecialchars($review['quantity']); ?></div>
                        <div><strong>Item Description:</strong> <?php echo htmlspecialchars($review['itemDescription']); ?></div>
                        <div><strong>Reference No:</strong> <?php echo htmlspecialchars($review['refNo']); ?></div>
                        <div><strong>Unit Price:</strong> <?php echo htmlspecialchars($review['unitPrice']); ?></div>
                        <div><strong>Amount:</strong> <?php echo htmlspecialchars($review['amount']); ?></div>
                        <div><strong>Issued By:</strong> <?php echo htmlspecialchars($review['issuedBy']); ?></div>
                        <div><strong>Issued By Date:</strong> <?php echo htmlspecialchars($review['issuedByDate']); ?></div>
                        <div><strong>Received By:</strong> <?php echo htmlspecialchars($review['receivedBy']); ?></div>
                        <div><strong>Received By Date:</strong> <?php echo htmlspecialchars($review['receivedByDate']); ?></div>
                        <div><strong>Posted By:</strong> <?php echo htmlspecialchars($review['postedBy']); ?></div>
                        <div><strong>Posted By Date:</strong> <?php echo htmlspecialchars($review['postedByDate']); ?></div>
                        <div><strong>Status:</strong> <?php echo htmlspecialchars($review['status']); ?></div>
                        <div><strong>Department:</strong> <?php echo htmlspecialchars($review['department']); ?></div>
                    </li>
                <?php endforeach; ?>
            </div>
            <?php $index++; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <li class="list-group-item text-center">No pending issuance reviews</li>
    <?php endif; ?>
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
