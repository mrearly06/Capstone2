<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issuance Slip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/sidebar-content.css">

    <style>
        html, body {
    height: 100%;
    overflow-y: auto;
}
        .form-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .slip-number {
            position: absolute;
            right: 20px;
            top: 20px;
        }
        .table input {
            border: none;
            width: 100%;
            background: transparent;
        }
        .table td {
            padding: 0.5rem !important;
        }
    </style>
</head>
<body>
  <!-- Sidebar -->
<?php include "backend/session-sidebar.php" ?>

<?php require "header.php" ?>

<!-- Main content -->
<div class="main-content">
    <div class="content"> 
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Inventory</a></li>
                <li class="breadcrumb-item active" aria-current="page">Item Inventory</li>
            </ol>
        </nav>
      

            <!-- Issuance Slip -->
            <div class="container mt-4">
                <form id="issuanceForm" action="" method="POST">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-header">
                                <h4>DIVINE WORD COLLEGE OF LEGAZPI</h4>
                                <h5>Legazpi City</h5>
                                <h4 class="mt-3">ISSUANCE SLIP</h4>
                            </div>
                            <div class="slip-number">
                                <h5>No. <span id="slipNumber"><?php echo isset($slipNumber) ? $slipNumber : 'Fetching...'; ?></span></h5>
                            </div>
                            <?php
                                // Database connection
                               include "backend/connection.php";

                                // Fetch departments
                                $sql = "SELECT departmentID, departmentName, campus FROM department";
                                $result = $conn->query($sql);
                            ?>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="department" class="form-label">DEPARTMENT:</label>
                                        <select class="form-control" id="department" name="department" required>
                                            <option value="" disabled selected>Select Department</option>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                // Loop through each department and create an option
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='" . $row['departmentID'] . "'>" . $row['departmentName'] . "</option>";
                                                }
                                            } else {
                                                echo "<option value='' disabled>No departments available</option>";
                                            }
                                            ?>
                                        </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="date" class="form-label">DATE:</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>
                            </div>

                            <div class="table-responsive" style="max-height: 300px;">
                                <table class="table table-bordered" id="itemTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%">QTY.</th>
                                            <th style="width: 40%">ITEM DESCRIPTION</th>
                                            <th style="width: 15%">REF. (RS NO.)</th>
                                            <th style="width: 15%">UNIT PRICE</th>
                                            <th style="width: 15%">AMOUNT</th>
                                            <th style="width: 5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemTableBody">
                                        <tr>
                                            <td><input type="number" name="qty[]" class="qty" required></td>
                                            <td><input type="text" name="description[]" required></td>
                                            <td><input type="text" name="ref_no[]"></td>
                                            <td><input type="number" name="unit_price[]" class="unit-price" step="0.01" required></td>
                                            <td><input type="number" name="amount[]" class="amount" readonly></td>
                                            <td><button type="button" class="btn btn-danger btn-sm delete-row">×</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-end mb-3">
                                <button type="button" class="btn btn-primary" id="addRow">Add Row</button>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="issuedBy" class="form-label">Issued by:</label>
                                    <input type="text" class="form-control issuedBy" id="issuedBy" name="issued_by" placeholder="Enter ID or Name" required>
                                    <input type="hidden" id="issuedById" name="issued_by_id"> <!-- Hidden input for userId -->
                                    <div class="list-group issuedByList"></div>

                                    <label for="issuedDate" class="form-label">Date:</label>
                                    <input type="date" class="form-control" id="issuedDate" name="issued_date">
                                </div>
                                <div class="col-md-4">
                                    <label for="receivedBy" class="form-label">Received by:</label>
                                    <input type="text" class="form-control receivedBy" id="receivedBy" name="received_by" placeholder="Enter ID or Name" required>
                                    <input type="hidden" id="receivedById" name="received_by_id"> <!-- Hidden input for userId -->
                                    <div class="list-group receivedByList"></div>

                                    <label for="receivedDate" class="form-label">Date:</label>
                                    <input type="date" class="form-control" id="receivedDate" name="received_date">
                                </div>
                                <div class="col-md-4">
                                    <label for="postedBy" class="form-label">Posted by:</label>
                                    <input type="text" class="form-control postedBy" id="postedBy" name="posted_by" placeholder="Enter ID or Name" required>
                                    <input type="hidden" id="postedById" name="posted_by_id"> <!-- Hidden input for userId -->
                                    <div class="list-group postedByList"></div>

                                    <label for="postedDate" class="form-label">Date:</label>
                                    <input type="date" class="form-control" id="postedDate" name="posted_date">
                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    // Handle input events for all relevant fields
    $('.issuedBy, .receivedBy, .postedBy').on('input', function () {
        let query = $(this).val();
        let inputField = $(this); // The specific input field being updated
        let listGroupClass = inputField.attr('id') + 'List'; // Corresponding list-group class

        if (query !== '') {
            $.ajax({
                url: 'backend/fetch-users.php', // Backend PHP script
                method: 'GET',
                data: { query: query },
                success: function (response) {
                    let listGroup = $('.' + listGroupClass);
                    listGroup.empty(); // Clear previous results

                    if (response.length > 0) {
                        // Populate the list with clickable items
                        response.forEach(function (user) {
                            listGroup.append(`
                                <a href="javascript:void(0);" 
                                   class="list-group-item list-group-item-action userOption" 
                                   data-userid="${user.userID}" 
                                   data-name="${user.firstName} ${user.middleName} ${user.lastName}">
                                  (${user.userID}) ${user.firstName} ${user.middleName} ${user.lastName}
                                </a>
                            `);
                        });
                    } else {
                        listGroup.append('<a class="list-group-item">No users found</a>');
                    }
                },
                error: function () {
                    console.error('Error fetching user data.');
                }
            });
        } else {
            $('.' + listGroupClass).empty(); // Clear suggestions if input is empty
        }
    });

    // Handle click on list-group-item
    $(document).on('click', '.userOption', function () {
    let userId = $(this).data('userid');
    let userName = $(this).data('name');
    let parentList = $(this).parent(); // The parent list-group

    // Determine the input field associated with the clicked suggestion
    let inputField = parentList.siblings('input.form-control');
    let hiddenInputField = parentList.siblings('input[type="hidden"]'); // Hidden input for userId

    // Set the input field value to the selected user's name
    inputField.val(userName);

    // Set the hidden input field value to the selected user's ID
    hiddenInputField.val(userId);

    console.log(`Selected User Name: ${userName}, User ID: ${userId}`);

    // Clear the suggestions
    parentList.empty();
});

});

</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Function to fetch and update slip number
    function fetchSlipNumber() {
        // Show "Fetching..." until data is received
        const slipNumberElement = document.getElementById('slipNumber');
        slipNumberElement.innerText = "Fetching...";

        // AJAX request to fetch the latest slip number
        $.ajax({
            url: 'backend/get_latest_slip_no.php', // Path to your PHP script
            method: 'GET',
            dataType: 'json', // Expect JSON response
            success: function (response) {
                if (response.success) {
                    slipNumberElement.innerText = response.latestReviewNo;
                } else {
                    console.error("Failed to fetch slip number:", response.message);
                    slipNumberElement.innerText = "Error";
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", status, error);
                console.log("Response text:", xhr.responseText);
                slipNumberElement.innerText = "Error";
            }
        });
    }

    // Call the function to fetch slip number
    fetchSlipNumber();
});

</script>


<script>
    $(document).ready(function () {
        // Add new row to the table
        $("#addRow").on("click", function () {
            const newRow = `
                <tr>
                    <td><input type="number" name="qty[]" class="qty" required></td>
                    <td><input type="text" name="description[]" required></td>
                    <td><input type="text" name="ref_no[]"></td>
                    <td><input type="number" name="unit_price[]" class="unit-price" step="0.01" required></td>
                    <td><input type="number" name="amount[]" class="amount" readonly></td>
                    <td><button type="button" class="btn btn-danger btn-sm delete-row">×</button></td>
                </tr>`;
            $("#itemTableBody").append(newRow);
        });

        // Remove a row from the table
        $(document).on("click", ".delete-row", function () {
            $(this).closest("tr").remove();
        });

        // Auto-calculate amount when quantity or unit price changes
        $(document).on("input", ".qty, .unit-price", function () {
            const row = $(this).closest("tr");
            const qty = parseFloat(row.find(".qty").val()) || 0;
            const unitPrice = parseFloat(row.find(".unit-price").val()) || 0;
            row.find(".amount").val((qty * unitPrice).toFixed(2));
        });

          // Handle form submission
          $("#issuanceForm").on("submit", function (event) {
            event.preventDefault(); // Prevent default form submission

            const formData = {
    issuanceReviewNo: $("#slipNumber").text().trim(), // Slip number
    department: $("#department").val(),
    date: $("#date").val(),
    time: new Date().toLocaleTimeString(), // Automatically include current time
    issuedBy: $("#issuedById").val(), // Use 'issuedBy' to match PHP
    issuedByDate: $("#issuedDate").val(),
    receivedBy: $("#receivedById").val(), // Use 'receivedBy' to match PHP
    receivedByDate: $("#receivedDate").val(),
    postedBy: $("#postedById").val(), // Use 'postedBy' to match PHP
    postedByDate: $("#postedDate").val(),
    status: $("#status").val(), // Add status if applicable
};


            // Collect table data
            const tableData = [];
            $("#itemTableBody tr").each(function () {
                const qty = $(this).find("input[name='qty[]']").val();
                const description = $(this).find("input[name='description[]']").val();
                const refNo = $(this).find("input[name='ref_no[]']").val();
                const unitPrice = $(this).find("input[name='unit_price[]']").val();
                const amount = $(this).find("input[name='amount[]']").val();

                if (qty && description && unitPrice && amount) {
                    tableData.push({ qty, description, ref_no: refNo, unit_price: unitPrice, amount });
                }
            });

            if (tableData.length === 0) {
                alert("Please add at least one valid item to the table.");
                return;
            }

            const payload = { formData, tableData };

            // Debugging payload
            console.log("Payload:", payload);

            // Submit via AJAX
            $.ajax({
                url: "backend/process_issuance.php",
                method: "POST",
                data: JSON.stringify(payload),
                contentType: "application/json",
                success: function (response) {
                    console.log("Server Response:", response);
                    if (response.success) {
                        alert("Issuance slip submitted successfully!");
                        $("#issuanceForm")[0].reset();
                        $("#itemTableBody").empty();
                    } else {
                        alert("Failed to submit issuance slip: " + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    alert("An error occurred while submitting the form.");
                },
            });
        });
    });

</script>

</body>
</html>