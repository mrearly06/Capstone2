<?php
include "backend/connection.php";

// Fetch items from the item_review table, including related details from the user and inventory_request tables
$sql = "
    SELECT 
        item_review.item_reviewID, 
        item_review.itemName, 
        item_review.quantity, 
        item_review.description, 
        item_review.dateAcquired, 
        item_review.unitValue, 
        item_review.totalValue, 
        item_review.category, 
        item_review.status, 
        item_review.itemImage, 
        CONCAT(user.firstName, ' ', LEFT(user.middleName, 1), '.', ' ', user.lastName) AS fullName,
        user.userID,
        inventory_request.requestStatus
    FROM 
        item_review
    LEFT JOIN 
        user ON item_review.itemizedBy = user.userID
    LEFT JOIN 
        inventory_request ON item_review.inventory_requestID = inventory_request.inventory_requestID
";
$result_items = $conn->query($sql);

// Check if there are results
if ($result_items && $result_items->num_rows > 0): ?>
    <!-- HTML for displaying items -->
    <div class="container mt-1">
        <div class="row">
            <div class="col-md-12 col-lg-12 mx-auto">
                <!-- Card Container -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Item Inventory</h5>
                        <button type="button" class="btn btn-primary mt-1" data-bs-toggle="modal" data-bs-target="#addItemModal">
                            <i class="fas fa-plus"></i> Add Item
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover tble-item">
                                <thead class="thead-padding">
                                    <tr>
                                        <th scope="col" class="text-nowrap w-auto">Image</th>
                                        <th scope="col" class="text-nowrap w-auto">Item #</th>
                                        <th scope="col" class="text-nowrap w-auto">Item Name</th>
                                        <th scope="col" class="text-nowrap w-auto">Category</th>
                                        <th scope="col" class="text-nowrap w-auto">Quantity</th>
                                        <th scope="col" class="text-nowrap w-auto">Item Description</th>
                                        <th scope="col" class="text-nowrap w-auto">Date Acquired</th>
                                        <th scope="col" class="text-nowrap w-auto">Item Status</th>
                                        <th scope="col" class="text-nowrap w-auto">Unit Value</th>
                                        <th scope="col" class="text-nowrap w-auto">Total Value</th>
                                        <th scope="col" class="text-nowrap w-auto">Itemized By</th>
                                        <th scope="col" class="text-nowrap w-auto">Request Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result_items->fetch_assoc()): ?>
                                        <tr>
                                            <td><img src="uploads/<?php echo htmlspecialchars($row['itemImage']); ?>" alt="<?php echo htmlspecialchars($row['itemName']); ?>" style="width: 100px; height: auto;"></td>
                                            <th scope="row"><?php echo htmlspecialchars($row['item_reviewID']); ?></th>
                                            <td><?php echo htmlspecialchars($row['itemName']); ?></td>
                                            <td><?php echo htmlspecialchars($row['category']); ?></td>
                                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                                            <td><?php echo htmlspecialchars($row['dateAcquired']); ?></td>
                                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                                            <td><?php echo htmlspecialchars($row['unitValue']); ?></td>
                                            <td><?php echo htmlspecialchars($row['totalValue']); ?></td>
                                            <td><?php echo htmlspecialchars($row['fullName']); ?> (<?php echo htmlspecialchars($row['userID']); ?>)</td>
                                            <td><?php echo htmlspecialchars($row['requestStatus']); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
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
    
<?php else: ?>
    <p>No items found.</p>
<?php endif;

// Close the database connection
$conn->close();
?>
