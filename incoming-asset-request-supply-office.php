<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Temporarily removing session and user authorization checks
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Request List Group in Cards</title>

    <!-- Custom Styles -->
    <link rel="stylesheet" type="text/css" href="assets/css/sidebar-content.css">
    <style>
        .list-group-item {
            margin-bottom: 0 !important;
        }
        .container-request {
            margin: 0;
        }
        .fade-out {
            opacity: 1;
            transition: opacity 0.5s ease-out;
        }
        .fade-out.hidden {
            opacity: 0;
        }
        .container {
            overflow-y: auto;
            max-height: 500px;
        }
        .collapse {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<?php include "backend/session-sidebar.php"; ?>
<?php require "header.php"; ?>

<!-- Start of Main Content -->
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
        <!-- Fetch Asset Requests -->
        <?php
        include 'backend/connection.php';

        // Fetch grouped asset requests without session check
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
            WHERE 
                ar.status = 'For Review At Supply Office'
            ORDER BY 
                ar.assetRequestId DESC
        ";

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $groupedData = [];
        while ($row = $result->fetch_assoc()) {
            $groupedData[$row['assetRequestId']][] = $row;
        }
        ?>

        <!-- Asset Request List -->
        <ul class="list-group list-group-flush">
            <?php if (count($groupedData) > 0): ?>
                <?php foreach ($groupedData as $assetRequestId => $requests): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Asset Request ID:</strong> <?php echo htmlspecialchars($assetRequestId); ?>
                            <button class="btn btn-link p-2 ms-2" data-bs-toggle="collapse" data-bs-target="#requestDetails<?php echo $assetRequestId; ?>">
                                View Details
                            </button>
                        </div>
                        <div class="btn-group">
                            <form method="post" action="backend/process-asset-request.php" class="d-inline">
                                <input type="hidden" name="assetRequestId" value="<?php echo htmlspecialchars($assetRequestId); ?>">
                                <button type="submit" name="approve-supply-office" class="btn btn-primary">Approve</button>
                                <button type="submit" name="reject" class="btn btn-danger">Reject</button>
                            </form>
                        </div>
                    </li>

                    <!-- Request Details -->
                    <div id="requestDetails<?php echo $assetRequestId; ?>" class="collapse">
                        <?php $assetIndex = 1; ?>
                        <?php foreach ($requests as $request): ?>
                            <li class="list-group-item">
                                <div><strong>Asset <?php echo $assetIndex++; ?>:</strong></div>
                                <div><strong>Date:</strong> <?php echo htmlspecialchars($request['date']); ?></div>
                                <div><strong>Time:</strong> <?php echo htmlspecialchars($request['time']); ?></div>
                                <div><strong>Status:</strong> <?php echo htmlspecialchars($request['status']); ?></div>
                                <div><strong>Office Department:</strong> <?php echo htmlspecialchars($request['officeDepartment']); ?></div>
                                <div><strong>Requested By:</strong> <?php echo htmlspecialchars($request['requestedBy']); ?></div>
                                <div><strong>Control No:</strong> <?php echo htmlspecialchars($request['controlNo']); ?></div>
                                <div><strong>Category:</strong> <?php echo htmlspecialchars($request['category']); ?></div>
                                <div><strong>Quantity:</strong> <?php echo htmlspecialchars($request['quantity']); ?></div>
                                <div><strong>Description:</strong> <?php echo htmlspecialchars($request['description']); ?></div>
                                <div><strong>Amount:</strong> <?php echo htmlspecialchars($request['amount']); ?></div>
                            </li>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="list-group-item text-center">No pending asset requests</li>
            <?php endif; ?>
        </ul>

        <?php $stmt->close(); $conn->close(); ?>
    </div>
</div>

</body>
</html>
