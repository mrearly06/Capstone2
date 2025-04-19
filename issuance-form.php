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

         .dropdown-container {
        background: white;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 10px;
        width: 100%;
    }

    .list-group-item {
        cursor: pointer;
    }

    .list-group-item:hover {
        background-color: #f1f1f1;
    }

    
.collapsible-parent:hover {
    background-color: #f0f0f0;
}
.collapsible-child {
    background-color: #fcfcfc;
    font-style: italic;
}


    </style>
</head>
<body>
  <!-- Sidebar -->
<?php include "backend/session-sidebar.php" ?>

<?php require "header.php" ?>

<?php // Retrieve the logged-in user's details
date_default_timezone_set('Asia/Manila'); // Adjust to your desired timezone

$currentUserID = $_SESSION['userID'] ?? ''; // Assuming userID is stored in session
$currentUserName = $_SESSION['firstName'] . ' ' . $_SESSION['middleName'] . ' ' . $_SESSION['lastName']; ?>

?>

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
                                            <th style="width: 10%; white-space: nowrap;">Image</th>
                                            <th style="width: 10%; white-space: nowrap;">Item Instance Code</th>
                                            <th style="width: 15%; white-space: nowrap;">Item Name</th>
                                            <th style="width: 20%; white-space: nowrap;">Description</th>
                                            <th style="width: 10%; white-space: nowrap;">Quantity</th>
                                            <th style="width: 10%; white-space: nowrap;">Date Acquired</th>
                                            <th style="width: 10%; white-space: nowrap;">REF. (RS NO.)</th>
                                            <th style="width: 10%; white-space: nowrap;">UNIT PRICE</th>
                                            <th style="width: 10%; white-space: nowrap;">AMOUNT</th>
                                            <th style="width: 5%; white-space: nowrap;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemTableBody">
                                        <tr>
                                            <td style="white-space: nowrap;">
                                                <img src="default-image.png" alt="Item Image" class="img-thumbnail" style="width: 50px; height: 50px;">
                                            </td>
                                            <td style="white-space: nowrap;"><input type="text" name="item_instance_code[]" class="item-instance-code" required></td>
                                            <td style="white-space: nowrap;"><input type="text" name="item_name[]" class="item-name" required></td>
                                            <td style="white-space: nowrap;"><input type="text" name="description[]" class="description" required></td>
                                            <td style="white-space: nowrap;"><input type="number" name="qty[]" class="qty" required></td>
                                            <td style="white-space: nowrap;"><input type="date" name="date_acquired[]" class="date-acquired" required></td>
                                            <td style="white-space: nowrap;"><input type="text" name="ref_no[]"></td>
                                            <td style="white-space: nowrap;"><input type="number" name="unit_price[]" class="unit-price" step="0.01" required></td>
                                            <td style="white-space: nowrap;"><input type="number" name="amount[]" class="amount" readonly></td>
                                            <td style="white-space: nowrap;"><button type="button" class="btn btn-danger btn-sm delete-row">×</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div id="alertMessage" class="alert-message text-danger mt-2" style="display: none;"></div>
                            </div>

                                <table>
                                    <tbody id="hiddenItemTableBody"></tbody>
                                </table>



                            <div class="text-end mb-3 d-flex justify-content-between align-items-center gap-2">
                                 <!-- Select Property Button (Opens Large Modal) -->
                                 <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#largeModal">
                                    Select Property
                                </button>

                                <?php include "modals/add-issuance.php"?>
                            
                                <!-- Add Row Button -->
                                <button type="button" class="btn btn-primary" id="addRow">Add Row</button>

                            </div>

                   

                            
                            <div class="row">
                                <div class="col-md-4">
                                <label for="issuedBy" class="form-label">Issued by:</label>
                                        <input type="text" class="form-control issuedBy" id="issuedBy" name="issued_by" 
                                            placeholder="Enter ID or Name" 
                                            value="<?php echo htmlspecialchars($currentUserName); ?>" readonly>
                                        <input type="hidden" id="issuedById" name="issued_by_id" value="<?php echo htmlspecialchars($currentUserID); ?>"> <!-- Hidden input for userId -->
                                        <div class="list-group issuedByList"></div>

                                        <label for="issuedDate" class="form-label">Date:</label>
                                        <input type="date" class="form-control" id="issuedDate" name="issued_date" value="<?php echo date('Y-m-d'); ?>">
                                    
                                </div>
                                <div class="col-md-4">
                                        <label for="receivedBy" class="form-label">Received by:</label>
                                        <!-- Read-only input field -->
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="receivedBy" 
                                            name="received_by" 
                                            placeholder="Select a recipient" 
                                            readonly 
                                            onclick="toggleDropdown()"
                                            style="font-family: 'Courier New', monospace; cursor: pointer;"
                                        >
                                        <!-- Hidden input to store the selected user's ID -->
                                        <input type="hidden" id="receivedById" name="received_by_id">

                                        <!-- Dropdown container -->
                                        <div id="dropdownContainer" class="dropdown-container" style="display: none; position: relative; z-index: 1000;">
                                            <!-- Search bar inside the dropdown -->
                                            <input 
                                                type="text" 
                                                id="searchInput" 
                                                class="form-control mb-2" 
                                                placeholder="Search recipient..." 
                                                onkeyup="filterRecipients()"
                                            >
                                            <!-- List of recipients -->
                                            <ul id="recipientList" class="list-group" style="max-height: 200px; overflow-y: auto;">
                                                <?php
                                                include 'backend/connection.php';

                                                $query = "SELECT userID, firstName, middleName, lastName FROM user";
                                                $result = $conn->query($query);

                                                if ($result && $result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        $userID = $row['userID'];
                                                        $fullName = $row['firstName'] . ' ' . $row['middleName'] . ' ' . $row['lastName'];
                                                        echo "<li class='list-group-item' onclick=\"selectRecipient('$userID', '$fullName')\">$fullName (ID NO: $userID)</li>";
                                                    }
                                                } else {
                                                    echo "<li class='list-group-item disabled'>No users available</li>";
                                                }

                                                $conn->close();
                                                ?>
                                            </ul>
                                        </div>

                                        <label for="receivedDate" class="form-label mt-3">Date:</label>
                                        <input type="date" class="form-control" id="receivedDate" name="received_date" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="postedBy" class="form-label">Posted by:</label>
                                    <!-- Read-only input field -->
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="postedBy" 
                                        name="posted_by" 
                                        placeholder="Select a poster" 
                                        readonly 
                                        onclick="togglePostedDropdown()" 
                                        style="font-family: 'Courier New', monospace; cursor: pointer;"
                                    >
                                    <!-- Hidden input to store the selected user's ID -->
                                    <input type="hidden" id="postedById" name="posted_by_id">

                                    <!-- Dropdown container -->
                                    <div id="postedDropdownContainer" class="dropdown-container" style="display: none; position: relative; z-index: 1000;">
                                        <!-- Search bar inside the dropdown -->
                                        <input 
                                            type="text" 
                                            id="postedSearchInput" 
                                            class="form-control mb-2" 
                                            placeholder="Search poster..." 
                                            onkeyup="filterPosters()"
                                        >
                                        <!-- List of posters -->
                                        <ul id="postedList" class="list-group" style="max-height: 200px; overflow-y: auto;">
                                            <?php
                                            include 'backend/connection.php';

                                            $query = "SELECT userID, firstName, middleName, lastName FROM user";
                                            $result = $conn->query($query);

                                            if ($result && $result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $userID = $row['userID'];
                                                    $fullName = $row['firstName'] . ' ' . $row['middleName'] . ' ' . $row['lastName'];
                                                    echo "<li class='list-group-item' onclick=\"selectPoster('$userID', '$fullName')\">$fullName (ID NO: $userID)</li>";
                                                }
                                            } else {
                                                echo "<li class='list-group-item disabled'>No users available</li>";
                                            }

                                            $conn->close();
                                            ?>
                                        </ul>
                                    </div>

                                    <label for="postedDate" class="form-label mt-3">Date:</label>
                                    <input type="date" class="form-control" id="postedDate" name="posted_date" required>
                                </div>

                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-success submitBtn">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="itemDetailsModal" tabindex="-1" aria-labelledby="itemDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Item Instance Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Image</th>
              <th>Item Instance Code</th>
              <th>Quantity</th>
              <th>Date Acquired</th>
              <th>Description</th>
              <th>Unit Value</th>
            </tr>
          </thead>
          <tbody id="modalItemDetailsBody"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <script>
    function updatePostedById() {
        const selectElement = document.getElementById('postedBy');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const postedByIdInput = document.getElementById('postedById');

        // Extract the value from the selected option
        if (selectedOption.value) {
            postedByIdInput.value = selectedOption.value;
        } else {
            postedByIdInput.value = ''; // Clear the input if no option is selected
        }
    }
</script>

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
                    <td><input type="text" name="description[]" class="description" required></td>
                    <td><input type="text" name="ref_no[]"></td>
                    <td><input type="number" name="unit_price[]" class="unit-price" step="0.01" required></td>
                    <td><input type="number" name="amount[]" class="amount" readonly></td>
                    <td><button type="button" class="btn btn-danger btn-sm delete-row">×</button></td>
                </tr>`;
            $("#itemTableBody").append(newRow);
            checkDuplicates(); // Check for duplicates after adding a new row
        });

        // Remove a row from the table
        $(document).on("click", ".delete-row", function () {
            $(this).closest("tr").remove();
            checkDuplicates(); // Recheck duplicates after deletion
        });

        // Auto-calculate amount when quantity or unit price changes
        $(document).on("input", ".qty, .unit-price", function () {
            const row = $(this).closest("tr");
            const qty = parseFloat(row.find(".qty").val()) || 0;
            const unitPrice = parseFloat(row.find(".unit-price").val()) || 0;
            row.find(".amount").val((qty * unitPrice).toFixed(2));
        });

    
        /* * Check for duplicate descriptions
        $(document).on("input", ".description", function () {
            checkDuplicates();
        });

        // Function to check for duplicate descriptions
        function checkDuplicates() {
            const descriptions = [];
            let duplicateFound = false;

            $(".description").each(function () {
                const value = $(this).val().trim();
                if (value) {
                    if (descriptions.includes(value)) {
                        duplicateFound = true;
                    }
                    descriptions.push(value);
                }
            });

            if (duplicateFound) {
                $("#alertMessage")
                    .text("Duplicate description detected. Please ensure all descriptions are unique.")
                    .show();
                $(".submitBtn").prop("disabled", true); // Disable submit button
            } else {
                $("#alertMessage").hide(); // Hide the message if no duplicates
                $(".submitBtn").prop("disabled", false); // Enable submit button
            }
        }

        **/

        // Handle form submission
        $("#issuanceForm").on("submit", function (event) {
            event.preventDefault(); // Prevent default form submission

            const formData = {
                issuanceReviewNo: $("#slipNumber").text().trim(),
                department: $("#department").val(),
                date: $("#date").val(),
                time: new Date().toLocaleTimeString(),
                issuedBy: $("#issuedById").val(),
                issuedByDate: $("#issuedDate").val(),
                receivedBy: $("#receivedById").val(),
                receivedByDate: $("#receivedDate").val(),
                postedBy: $("#postedById").val(),
                postedByDate: $("#postedDate").val(),
                status: $("#status").val(),
            };

            const tableData = [];

            $("#hiddenItemTableBody tr").each(function () {
                const itemInstanceID = $(this).find("input[name='hidden_item_instance_id[]']").val();
                //const itemInstanceID = $(this).find("input[name='item_instance_id[]']").val();
                //const qty = $(this).find("input[name='qty[]']").val();
                //const description = $(this).find("input[name='description[]']").val();
                //const refNo = $(this).find("input[name='ref_no[]']").val();
                //const unitPrice = $(this).find("input[name='unit_price[]']").val();
                //const amount = $(this).find("input[name='amount[]']").val();

              //  if (itemInstanceID && qty && description && unitPrice && amount) {
              //      tableData.push({ itemInstanceID, qty, description, ref_no: refNo, unit_price: unitPrice, amount });
              //  }
             //           if (itemInstanceID) {
             //               tableData.push({ itemInstanceID });
            //}
          //     });

          if (itemInstanceID) {
                    tableData.push({ itemInstanceID });
            }
            });

            if (tableData.length === 0) {
                alert("Please add at least one valid item to the table.");
                return;
            }

            const payload = { formData, tableData };

            console.log("Payload:", payload);

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
                        $("#alertMessage").hide(); // Clear alert message
                        $("#submitBtn").prop("disabled", false); // Ensure the button is enabled
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

        // Trigger duplicate check on page load for preloaded rows
        checkDuplicates();
    });
</script>



<script>
    // Toggle the visibility of the dropdown
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdownContainer');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    // Function to filter recipients based on search input
    function filterRecipients() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const listItems = document.querySelectorAll('#recipientList li');

        listItems.forEach(item => {
            const text = item.textContent || item.innerText;
            item.style.display = text.toLowerCase().includes(filter) ? '' : 'none';
        });
    }

    // Function to handle recipient selection
    function selectRecipient(userID, fullName) {
        const inputField = document.getElementById('receivedBy');
        const hiddenField = document.getElementById('receivedById');

        // Set selected recipient's name and ID
        inputField.value = fullName;
        hiddenField.value = userID;

        // Hide the dropdown
        document.getElementById('dropdownContainer').style.display = 'none';
    }

    // Close the dropdown if clicked outside
    document.addEventListener('click', (event) => {
        const dropdown = document.getElementById('dropdownContainer');
        const inputField = document.getElementById('receivedBy');
        if (!dropdown.contains(event.target) && event.target !== inputField) {
            dropdown.style.display = 'none';
        }
    });
</script>

<script>
    // Toggle the visibility of the dropdown
    function togglePostedDropdown() {
        const dropdown = document.getElementById('postedDropdownContainer');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    // Function to filter posters based on search input
    function filterPosters() {
        const input = document.getElementById('postedSearchInput');
        const filter = input.value.toLowerCase();
        const listItems = document.querySelectorAll('#postedList li');

        listItems.forEach(item => {
            const text = item.textContent || item.innerText;
            item.style.display = text.toLowerCase().includes(filter) ? '' : 'none';
        });
    }

    // Function to handle poster selection
    function selectPoster(userID, fullName) {
        const inputField = document.getElementById('postedBy');
        const hiddenField = document.getElementById('postedById');

        // Set selected poster's name and ID
        inputField.value = fullName;
        hiddenField.value = userID;

        // Hide the dropdown
        document.getElementById('postedDropdownContainer').style.display = 'none';
    }

    // Close the dropdown if clicked outside
    document.addEventListener('click', (event) => {
        const dropdown = document.getElementById('postedDropdownContainer');
        const inputField = document.getElementById('postedBy');
        if (!dropdown.contains(event.target) && event.target !== inputField) {
            dropdown.style.display = 'none';
        }
    });
</script>

<script>
function populateItemTable() {
    const itemTableBody = document.getElementById("itemTableBody");
    itemTableBody.innerHTML = "";

    const selectedItems = JSON.parse(localStorage.getItem("selectedItems")) || [];
    console.log("Selected Items from localStorage:", selectedItems); // Log the selected items

    const groupedItems = {};

    selectedItems.forEach(item => {
        const key = item.itemNo;
        if (!groupedItems[key]) {
            groupedItems[key] = {
                items: [item],
                quantity: parseInt(item.quantity) || 1,
                unitValue: parseFloat(item.unitValue) || 0
            };
        } else {
            groupedItems[key].items.push(item);
            groupedItems[key].quantity += parseInt(item.quantity) || 1;
        }
    });

    Object.keys(groupedItems).forEach((itemNo, index) => {
        const group = groupedItems[itemNo];
        const item = group.items[0];
        const hasMultiple = group.items.length > 1;
        const totalValue = (group.unitValue * group.quantity).toFixed(2);
        const instanceCode = hasMultiple ? "" : item.itemInstanceCode;

        const row = document.createElement("tr");

        row.innerHTML = `
            <td><img src="${item.image || 'default-image.png'}" class="img-thumbnail" style="width:50px; height:50px;"></td>
            <td>
                <input type="text" name="item_instance_code[]" class="item-instance-code" value="${instanceCode}" ${hasMultiple ? "style='display: none;'" : ""}>
                ${hasMultiple ? `<button class="btn btn-link btn-sm view-details" data-itemno="${itemNo}">(View)</button>` : ""}
            </td>
           <td> <input type="text" name="item_instance_id[]" value="${item.itemInstanceID}" ${hasMultiple ? "style='display: block;'" : ""}>
           </td>
            <td><input type="text" name="item_name[]" value="${item.itemName}" class="item-name" required></td>
            <td><input type="text" name="description[]" value="${item.description}" class="description" required></td>
            <td><input type="number" name="qty[]" value="${group.quantity}" class="qty" required></td>
            <td><input type="date" name="date_acquired[]" value="${item.dateAcquired}" class="date-acquired" required></td>
            <td><input type="text" name="ref_no[]"></td>
            <td><input type="number" name="unit_price[]" value="${group.unitValue}" class="unit-price" step="0.01" required></td>
            <td><input type="number" name="amount[]" value="${totalValue}" class="amount" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm delete-row">×</button></td>
        `;


        itemTableBody.appendChild(row);
    });


    const hiddenTableBody = document.getElementById("hiddenItemTableBody");

Object.keys(groupedItems).forEach((itemNo) => {
    const group = groupedItems[itemNo];

    group.items.forEach(item => {
        const totalValue = (item.unitValue * item.quantity).toFixed(2);

        const hiddenRow = document.createElement("tr");

        hiddenRow.innerHTML = `
            <td><input type="hidden" name="hidden_item_instance_id[]" value="${item.itemInstanceID}"></td>
            <td><input type="hidden" name="hidden_item_instance_code[]" value="${item.itemInstanceCode}"></td>
            <td><input type="hidden" name="hidden_item_name[]" value="${item.itemName}"></td>
            <td><input type="hidden" name="hidden_description[]" value="${item.description}"></td>
            <td><input type="hidden" name="hidden_quantity[]" value="${item.quantity}"></td>
            <td><input type="hidden" name="hidden_date_acquired[]" value="${item.dateAcquired}"></td>
            <td><input type="hidden" name="hidden_unit_price[]" value="${item.unitValue}"></td>
            <td><input type="hidden" name="hidden_amount[]" value="${totalValue}"></td>
        `;

        hiddenTableBody.appendChild(hiddenRow);
    });
});

    // Handle modal opening
    document.querySelectorAll(".view-details").forEach(btn => {
        btn.addEventListener("click", function () {
            const itemNo = this.dataset.itemno;
            const group = groupedItems[itemNo];
            const modalBody = document.getElementById("modalItemDetailsBody");
            modalBody.innerHTML = "";

            group.items.forEach(item => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td><img src="${item.image || 'default-image.png'}" class="img-thumbnail" style="width:50px; height:50px;"></td>
                    <td>${item.itemInstanceCode}</td>
                    <td style="display:none;">${item.itemInstanceID}</td>
                    <td>${item.quantity}</td>
                    <td>${item.dateAcquired || "-"}</td>
                    <td>${item.description}</td>
                    <td>${item.unitValue}</td>
                `;
                modalBody.appendChild(row);
            });

            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById("itemDetailsModal"));
            modal.show();
        });
    });
}

populateItemTable();

// Delete row logic
document.getElementById("itemTableBody").addEventListener("click", function (e) {
    if (e.target.classList.contains("delete-row")) {
        e.target.closest("tr").remove();
    }
});
</script>



</body>
</html>