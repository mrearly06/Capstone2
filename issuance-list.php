<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Issuance</title>
    <!-- Add your CSS links here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">

      <!------ Custom Style   ------------------------------>
      <link rel="stylesheet" type="text/css" href="assets/css/sidebar-content.css">
    <style>
        .card {
            margin-bottom: 20px;
        }
        .table-responsive {
            max-height: 400px;
        }
        .custom-modal-width {
            max-width: 85% !important;  /* Customize width to fit your needs */
        }
   
 
        .fade-left-out {
  animation: fadeLeftOut 1s forwards;
}


@keyframes fadeLeftOut {
  from { transform: translateX(0); opacity: 1; }
  to { transform: translateX(-100%); opacity: 0; }
}

.fade-right-out {
  animation: fadeRightOut 1s forwards;

}
@keyframes fadeRightOut {
  from { transform: translateX(0); opacity: 1; }
  to { transform: translateX(100%); opacity: 0; }
}

.modal {
  background-color: transparent !important;
  backdrop-filter: none;
}

.fade-right-out {
  animation: fadeRightOut 1s forwards;
  backdrop-filter: blur(4px);         /* Applies blur */
  background-color: rgba(0, 0, 0, 0.3); /* Optional: darken background */
}
.fade-right-out {
  animation: fadeRightOut 1s forwards;
  backdrop-filter: blur(4px);
  background-color: rgba(0, 0, 0, 0.3);
}


.fixed-footer {
  position: sticky;
  bottom: 0;
  z-index: 1055; /* stays above modal body */
  border-top: 1px solid #dee2e6;
}

    </style>
</head>
<body>

<?php include "backend/session-sidebar.php"?>
<?php require "header.php"?>

<div class="main-content">
    <div class="content1"> 
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-3">
                
            </ol>
        </nav>

        <div class="container mt-4">
            <div class="d-flex justify-content-between mb-2">
                <div class="btn-group" role="group" aria-label="Approval Status">
                    <button type="button" class="btn btn-outline-secondary">Pending</button>
                    <button type="button" class="btn btn-outline-secondary">Approved</button>
                    <button type="button" class="btn btn-outline-secondary">Rejected</button>
                </div>
                    <?php if (isset($_SESSION['userType']) && $_SESSION['userType'] === 'supply_manager'): ?>
                        <a href="issuance-form.php" class="btn btn-primary" id="requestButton">
                            <i class="fas fa-plus"></i> Add Issuance
                        </a>
                    <?php endif; ?>
            </div>

            <div class="card p-3">
                <div class="card-header d-flex justify-content-between">
                    <h5>Property Issuance</h5>
                       <!-- Button Group -->
                       <div class="btn-group" role="group" aria-label="Request Type">
                            <button type="button" class="btn btn-primary" id="inventoryRequestBtn">Issuance List</button>
                            <button type="button" class="btn btn-outline-secondary" id="assetRequestBtn">Incoming Issuance</button>
                        </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive overflow-auto">
                        <table id="propertyIssuanceTable" class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="text-nowrap w-auto">Issuance No.</th>
                                    <th scope="col" class="text-nowrap w-auto">Date</th>
                                    <th scope="col" class="text-nowrap w-auto">Time</th>
                                    <th scope="col" class="text-nowrap w-auto">Quantity</th>
                                    <th scope="col" class="text-nowrap w-auto">Item Description</th>
                                    <th scope="col" class="text-nowrap w-auto">Reference No.</th>
                                    <th scope="col" class="text-nowrap w-auto">Unit Price</th>
                                    <th scope="col" class="text-nowrap w-auto">Amount</th>
                                    <th scope="col" class="text-nowrap w-auto">Issued By</th>
                                    <th scope="col" class="text-nowrap w-auto">Issued By Date</th>
                                    <th scope="col" class="text-nowrap w-auto">Received By</th>
                                    <th scope="col" class="text-nowrap w-auto">Received By Date</th>
                                    <th scope="col" class="text-nowrap w-auto">Posted By</th>
                                    <th scope="col" class="text-nowrap w-auto">Posted By Date</th>
                                    <th scope="col" class="text-nowrap w-auto">Status</th>
                                    <th scope="col" class="text-nowrap w-auto">Department</th>
                                </tr>

                            </thead>
                            <tbody>
                                <?php
                                // Fetch data from the database
                                include 'backend/connection.php'; // Include database connection file
                                $query = "SELECT * FROM issuance"; // Query to fetch all data from the 'issuance' table
                                $result = $conn->query($query);

                                if ($result->num_rows > 0) {
                                    // Loop through each row and display the data
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['issuanceNo'] . "</td>";
                                        echo "<td>" . $row['date'] . "</td>";
                                        echo "<td>" . $row['time'] . "</td>";
                                        echo "<td>" . $row['quantity'] . "</td>";
                                        echo "<td>" . $row['itemDescription'] . "</td>";
                                        echo "<td>" . $row['refNo'] . "</td>";
                                        echo "<td>" . $row['unitPrice'] . "</td>";
                                        echo "<td>" . $row['amount'] . "</td>";
                                        echo "<td>" . $row['issuedBy'] . "</td>";
                                        echo "<td>" . $row['issuedByDate'] . "</td>";
                                        echo "<td>" . $row['receivedBy'] . "</td>";
                                        echo "<td>" . $row['receivedByDate'] . "</td>";
                                        echo "<td>" . $row['postedBy'] . "</td>";
                                        echo "<td>" . $row['postedByDate'] . "</td>";
                                        echo "<td>" . $row['status'] . "</td>";
                                        echo "<td>" . $row['department'] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='16'>No data available</td></tr>";
                                }
                                $conn->close(); // Close the database connection
                                ?>
                            </tbody>
                        </table>

                        <table id="incomingIssuanceTable" class="table table-hover" style="display: none;">
                            <!-- Table content for Incoming Issuance -->
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="text-nowrap w-auto">Issuance No.</th>
                                    <th scope="col" class="text-nowrap w-auto">Date</th>
                                    <th scope="col" class="text-nowrap w-auto">Time</th>
                                    <th scope="col" class="text-nowrap w-auto">Issued By</th>
                                    <th scope="col" class="text-nowrap w-auto">Issued Date</th>
                                    <th scope="col" class="text-nowrap w-auto"></th>
                                   
                                </tr>

                            </thead>
                            <tbody>
                                <?php
                                include 'backend/connection.php';

                                // Query with JOINs and name concatenation
                                $query = "
                                SELECT 
                                    ir.issuanceReviewNo,
                                    ir.date,
                                    ir.time,
                                    ir.refNo,
                                    CONCAT(u1.firstName, ' ', u1.middleName, ' ', u1.lastName) AS issuedBy,
                                    ir.issuedByDate
                                FROM issuance_review ir
                                LEFT JOIN user u1 ON ir.issuedBy = u1.userID
                                LEFT JOIN item_instance ii ON ir.itemInstanceID = ii.itemInstanceID
                                LEFT JOIN item i ON ii.itemNo = i.itemNo
                                GROUP BY ir.issuanceReviewNo
                            ";
                            

                                $result = $conn->query($query);

                                if ($result->num_rows > 0) {
                                  while ($row = $result->fetch_assoc()) {
                                      echo "<tr>";
                                      echo "<td>" . $row['issuanceReviewNo'] . "</td>";
                                      echo "<td>" . $row['date'] . "</td>";
                                      echo "<td>" . $row['time'] . "</td>";
                                      echo "<td>" . $row['issuedBy'] . "</td>";
                                      echo "<td>" . $row['issuedByDate'] . "</td>";
                                      
                                      // Add view icon (calls modal instead of opening a new page)
                                      echo "<td class='text-center'>";
                                      echo "<a href='#' class='viewBtn' data-id='" . $row['issuanceReviewNo'] . "' data-bs-toggle='modal' data-bs-target='#viewModal'>";
                                      echo "<i class='fas fa-eye'></i>";
                                      echo "</a>";
                                      echo "</td>";
                              
                                      echo "</tr>";
                                  }
                              } else {
                                  echo "<tr><td colspan='14'>No data available</td></tr>";
                              }
                              
                              $conn->close();
                              ?>
                            </tbody>

                            
                        </table>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <!-- Footer content if needed -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'modals/view-incoming-issuance-details.php'; ?>


<!-- Modal -->
<div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestModalLabel">Request as Department Head</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="requestSubject" class="form-label">Request Subject</label>
                        <input type="text" class="form-control" id="requestSubject" required>
                    </div>
                    <div class="mb-3">
                        <label for="requestDetails" class="form-label">Details</label>
                        <textarea class="form-control" id="requestDetails" rows="3" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Submit Request</button>
            </div>
        </div>
    </div>
</div>



<!-- Bootstrap JS (with Popper) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#propertyIssuanceTable').DataTable({
            responsive: true,
            language: {
                paginate: {
                    previous: '&laquo;',
                    next: '&raquo;'
                }
            },
            columnDefs: [
                { orderable: false, targets: [0] } // Disable sorting on the first column
            ]
        });
    });
</script>


<script>

document.addEventListener('DOMContentLoaded', function() {
    // Get buttons and tables
    const inventoryRequestBtn = document.getElementById('inventoryRequestBtn');
    const assetRequestBtn = document.getElementById('assetRequestBtn');
    const propertyIssuanceTable = document.getElementById('propertyIssuanceTable');
    const incomingIssuanceTable = document.getElementById('incomingIssuanceTable');

    // Event listener for "Issuance List" button
    inventoryRequestBtn.addEventListener('click', function() {
        // Show the Issuance List table
        propertyIssuanceTable.style.display = 'table';
        // Hide the Incoming Issuance table
        incomingIssuanceTable.style.display = 'none';
        // Update button styles
        inventoryRequestBtn.classList.add('btn-primary');
        inventoryRequestBtn.classList.remove('btn-outline-secondary');
        assetRequestBtn.classList.add('btn-outline-secondary');
        assetRequestBtn.classList.remove('btn-primary');
    });

    // Event listener for "Incoming Issuance" button
    assetRequestBtn.addEventListener('click', function() {
        // Show the Incoming Issuance table
        incomingIssuanceTable.style.display = 'table';
        // Hide the Issuance List table
        propertyIssuanceTable.style.display = 'none';
        // Update button styles
        assetRequestBtn.classList.add('btn-primary');
        assetRequestBtn.classList.remove('btn-outline-secondary');
        inventoryRequestBtn.classList.add('btn-outline-secondary');
        inventoryRequestBtn.classList.remove('btn-primary');
    });
});


</script>



<script>
  // Store PHP data into JS variable
  const fetchedData = <?= json_encode($rows) ?>;

  console.log("Fetched data:", fetchedData); // For verification
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const viewBtns = document.querySelectorAll('.viewBtn');

  viewBtns.forEach(btn => {
    btn.addEventListener('click', async function () {
      const issuanceId = this.getAttribute('data-id');

      try {
        const response = await fetch(`backend/view-incoming-issuance-details.php?id=${issuanceId}`);
        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

        const data = await response.json();

        if (data.length === 0) {
          document.getElementById('modalBodyContent').innerHTML = "<p>No data found.</p>";
        } else {
          const header = data[0];
          const itemRows = data;

          let headerHTML = `
          <div class="row mb-4">
            <div class="col-md-6">
              <ul class="list-group">
                <li class="list-group-item"><strong>Issuance No:</strong> ${header.issuanceReviewNo}</li>
                <li class="list-group-item"><strong>Date:</strong> ${header.date}</li>
                <li class="list-group-item"><strong>Time:</strong> ${header.time}</li>
                <li class="list-group-item"><strong>Quantity:</strong> ${itemRows.length}</li>
                <li class="list-group-item"><strong>Issued By:</strong> ${header.issuedBy}</li>
                <li class="list-group-item"><strong>Issued By Date:</strong> ${header.issuedByDate}</li>
              </ul>
            </div>
            <div class="col-md-6">
              <ul class="list-group">
                <li class="list-group-item"><strong>Received By:</strong> ${header.receivedBy}</li>
                <li class="list-group-item"><strong>Received By Date:</strong> ${header.receivedByDate}</li>
                <li class="list-group-item"><strong>Posted By:</strong> ${header.postedBy}</li>
                <li class="list-group-item"><strong>Posted By Date:</strong> ${header.postedByDate}</li>
                <li class="list-group-item"><strong>Status:</strong> <span class="badge bg-success">${header.status}</span></li>
                <li class="list-group-item"><strong>Department:</strong> ${header.departmentName}</li>
              </ul>
            </div>
          </div>`;

          let tableHTML = `
          <div class="table-responsive border rounded-3 shadow-sm">
            <table class="table table-hover align-middle text-center">
              <thead class="table-primary">
                <tr>
                  <th scope="col">Item Image</th>
                  <th scope="col">Item Description</th>
                  <th scope="col">Reference No.</th>
                  <th scope="col">Unit Price</th>
                  <th scope="col">Item Instance Code</th>
                </tr>
              </thead>
              <tbody>`;

          itemRows.forEach(row => {
            const imgSrc = row.image ? `uploads/asset_img/${row.image}` : 'uploads/asset_img/image/sample-item.jpg';
            tableHTML += `
              <tr>
                <td><img src="${imgSrc}" alt="Item Image" class="img-thumbnail" style="max-width: 80px;"></td>
                <td>${row.description}</td>
                <td style="display:none;">${row.dateAcquired}</td>
                <td>${row.refNo}</td>
                <td>₱${parseFloat(row.unitValue).toFixed(2)}</td>
                <td>${row.itemInstanceCode}</td>
              </tr>`;
          });

          tableHTML += `</tbody></table></div>`;

          let footerHTML = `
            <div class="modal-footer bg-light fixed-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="proceedBtn" data-issuance-id="${header.issuanceReviewNo}">Proceed</button>
            </div>`;

          document.querySelector('#modalBodyContent').innerHTML = headerHTML + tableHTML + footerHTML;

          // Set up event listener for the Proceed button
          setTimeout(() => {
            const proceedBtn = document.getElementById('proceedBtn');
            if (proceedBtn) {
              proceedBtn.addEventListener('click', () => {
                const issuanceData = {
                  issuanceReviewNo: header.issuanceReviewNo,
                  date: header.date,
                  time: header.time,
                  issuedBy: header.issuedBy,
                  issuedByDate: header.issuedByDate,
                  receivedBy: header.receivedBy,
                  receivedByDate: header.receivedByDate,
                  postedBy: header.postedBy,
                  postedByDate: header.postedByDate,
                  status: header.status,
                  departmentName: header.departmentName,
                  items: itemRows.map(row => ({
                    itemNo: row.itemNo,
                    image: row.image,
                    description: row.description,
                    dateAcquired: row.dateAcquired,
                    refNo: row.refNo,
                    unitValue: row.unitValue,
                    itemInstanceCode: row.itemInstanceCode
                  }))
                };

                localStorage.setItem('selectedIssuance', JSON.stringify(issuanceData));
                console.log('Issuance data stored to localStorage:', issuanceData);

                // Optional: Redirect or trigger next step
                // window.location.href = 'next-page.php';
              });
            }
          }, 0);
        }

        const nextModal = new bootstrap.Modal(document.getElementById('viewModal'));
        nextModal.show();

      } catch (error) {
        console.error('Error fetching modal data:', error);
        document.getElementById('modalBodyContent').innerHTML = `<div class="alert alert-danger">Failed to load content.</div>`;
      }
    });
  });
});
</script>



<script>
  document.addEventListener("DOMContentLoaded", function () {
    const currentModal = document.getElementById("viewModal");
    const currentModalContent = document.getElementById("currentModalContent");
    const nextModalEl = document.getElementById("nextModal");
    const nextModalDialog = nextModalEl.querySelector(".modal-dialog");

    const currentInstance = bootstrap.Modal.getOrCreateInstance(currentModal);
    const nextInstance = bootstrap.Modal.getOrCreateInstance(nextModalEl);

    document.addEventListener("click", function (e) {
      // Check if Proceed button was clicked
      if (e.target.matches("#proceedBtn") || e.target.closest("#proceedBtn")) {
        currentModalContent.classList.add("fade-left-out");

        setTimeout(() => {
          currentInstance.hide();
          currentModalContent.classList.remove("fade-left-out");

          // Show next modal
          nextInstance.show();
        }, 500);
      }

      // Check if Back button was clicked
      if (e.target.matches("#backBtn") || e.target.closest("#backBtn")) {
        nextModalDialog.classList.add("fade-right-out");

        setTimeout(() => {
          nextInstance.hide();
          nextModalDialog.classList.remove("fade-right-out");

          // Show previous modal with fade-in
          currentModalContent.classList.add("fade-in");
          currentInstance.show();

          setTimeout(() => {
            currentModalContent.classList.remove("fade-in");
          }, 500);
        }, 500);
      }
    });

    // Clean up modal backdrop if user closes via X or backdrop
    nextModalEl.addEventListener("hidden.bs.modal", function () {
      document.body.classList.remove("modal-open");
      const backdrop = document.querySelector(".modal-backdrop");
      if (backdrop) backdrop.remove();
    });

    currentModal.addEventListener("hidden.bs.modal", function () {
      document.body.classList.remove("modal-open");
      const backdrop = document.querySelector(".modal-backdrop");
      if (backdrop) backdrop.remove();
    });
  });
</script>



</body>
</html>
