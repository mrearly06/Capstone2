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
        <!-- 
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Inventory</a></li>
                <li class="breadcrumb-item active" aria-current="page">Item Inventory</li>
            </ol>
        </nav>
       -->

            <!-- Issuance Slip -->
            <div class="container mt-4">
                <form id="inventoryForm" action="" method="POST" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-header">
                                
                                <h4 class="mt-3">INVENTORY FORM</h4>
                            </div>
                            <div class="slip-number">
                            <h5>No. <span id="slipNumber">Fetching...</span></h5>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                <label for="issuedBy" class="form-label">Logged by:</label>
                                        <input type="text" class="form-control loggedBy" id="loggeddBy" name="logged_by" 
                                            placeholder="Enter ID or Name" 
                                            value="<?php echo htmlspecialchars($currentUserName); ?>" readonly>
                                        <input type="hidden" id="loggedById" name="logged_by_id" value="<?php echo htmlspecialchars($currentUserID); ?>"> <!-- Hidden input for userId -->
                                        <div class="list-group issuedByList"></div>                       
                                </div>
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-4">
                                        <label for="issuedDate" class="form-label">Date:</label>
                                        <input type="date" class="form-control" id="loggedDate" name="logged_date" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="table-responsive" style="max-height: 300px; overflow-x: auto;">
    <table class="table table-bordered" id="itemTable" style="min-width: 2000px;">
    <thead>
        <tr>
            <th style="width: 20%">Item Name</th>
            <th style="width: 10%">Quantity</th>
            <th style="width: 10%">Date Acquired</th>
            <th style="width: 10%">Unit Value</th>
            <th style="width: 25%">Item Description</th>
            <th style="width: 10%">Total Value</th>
            <th style="width: 10%">Category</th>
            <th style="width: 10%">Item Image</th>
            <th style="width: 10%">Action</th>
        </tr>
    </thead>
    <tbody id="itemTableBody">
        <tr>
            <td>
                <input type="text" name="item_name[]" class="form-control item-name" placeholder="Enter item name" required style="width: 100%;">
            </td>
            <td>
                <input type="number" name="quantity[]" class="form-control quantity" placeholder="0" required style="width: 100%;">
            </td>
            <td>
                <input type="date" name="date_acquired[]" class="form-control date-acquired" required style="width: 100%;">
            </td>
            <td>
                <input type="number" name="unit_value[]" class="form-control unit-value" placeholder="0.00" step="1" required style="width: 100%;">
            </td>
            <td>
                <input type="text" name="item_description[]" class="form-control item-description" placeholder="Enter description" required style="width: 100%;">
            </td>
            <td>
                <input type="number" name="total_value[]" class="form-control total-value" placeholder="0.00" step="0.01" readonly style="width: 100%;">
            </td>
            <td>
                <select name="category[]" class="form-select category" required style="width: 300px;">
                    <option disabled selected>Select a category</option>
                    <option value="Office Supplies">Office Supplies</option>
                    <option value="Furniture">Furniture</option>
                    <option value="Computers and IT Equipment">Computers and IT Equipment</option>
                    <option value="Laboratory Equipment">Laboratory Equipment</option>
                    <option value="Audio-Visual Equipment">Audio-Visual Equipment</option>
                    <option value="Classroom Materials">Classroom Materials</option>
                    <option value="Sports & Physical Education Equipment">Sports & Physical Education Equipment</option>
                    <option value="Maintenance & Janitorial Supplies">Maintenance & Janitorial Supplies</option>
                    <option value="Library Resources">Library Resources</option>
                    <option value="Others">Others</option>
                </select>
            </td>
            <td>
                <input type="file" name="item_image[]" class="form-control item-image" accept="image/*" style="width: 250px;">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm delete-row">×</button>
            </td>
        </tr>
        </tbody>
    </table>
    <div id="alertMessage" class="alert-message text-danger mt-2" style="display: none;"></div>
</div>

                            <div class="text-end mb-3">
                                <button type="button" class="btn btn-primary" id="addRow">Add Row</button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
document.addEventListener('DOMContentLoaded', function () {
    function fetchSlipNumber() {
        const slipNumberElement = document.getElementById('slipNumber');
        slipNumberElement.innerText = "Fetching...";

        $.ajax({
            url: 'backend/get_latest_inventory_slip_no.php', // Ensure this file path is correct
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    slipNumberElement.innerText = response.latestSlipNo;
                } else {
                    slipNumberElement.innerText = "Error";
                    console.error("Failed to fetch slip number:", response.message);
                }
            },
            error: function (xhr, status, error) {
                slipNumberElement.innerText = "Error";
                console.error("AJAX error:", status, error);
                console.log("Response text:", xhr.responseText);
            }
        });
    }

    fetchSlipNumber(); // Call this function when the page loads
});
</script>


<script>
$(document).ready(function () {
    // Function to fetch latest item code and increment it
    let currentItemCode;

    // Function to fetch the latest item code once on page load
    function initializeItemCode() {
        $.ajax({
            url: "backend/get_latest_item_code.php",
            method: "GET",
            dataType: "json",
            success: function (response) {
                currentItemCode = response.newCode;
                // Set the code for the first row if necessary
                $(".item-code").first().val(currentItemCode);
            },
            error: function () {
                console.error("Error fetching latest item code.");
            },
        });
    }

   
    // Initialize the current item code on page load
    initializeItemCode();

    // Add new row with incremented code
    $("#addRow").on("click", function () {
        // Ensure we have initialized the code


        let newRow = `
            <tr>
                <td><input type="text" name="item_name[]" class="form-control item-name" required></td>
                <td><input type="number" name="quantity[]" class="form-control quantity" required></td>
                <td><input type="date" name="date_acquired[]" class="form-control date-acquired" required></td>
                <td><input type="number" name="unit_value[]" class="form-control unit-value" required></td>
                <td><input type="text" name="item_description[]" class="form-control item-description" required></td>
                <td><input type="number" name="total_value[]" class="form-control total-value" readonly></td>
                <td>
                <select name="category[]" class="form-select category" required style="width: 300px;">
                        <option value="" disabled selected>Select a category</option>
                        <option value="Office Supplies">Office Supplies</option>
                        <option value="Furniture">Furniture</option>
                        <option value="Computers and IT Equipment">Computers and IT Equipment</option>
                        <option value="Laboratory Equipment">Laboratory Equipment</option>
                        <option value="Audio-Visual Equipment">Audio-Visual Equipment</option>
                        <option value="Classroom Materials">Classroom Materials</option>
                        <option value="Sports & Physical Education Equipment">Sports & Physical Education Equipment</option>
                        <option value="Maintenance & Janitorial Supplies">Maintenance & Janitorial Supplies</option>
                        <option value="Library Resources">Library Resources</option>
                        <option value="Others">Others</option>
                    </select>
                </td>
                <td><input type="file" name="item_image[]" class="form-control item-image" accept="image/*" style="width: 250px;"></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">×</button></td>
            </tr>
        `;
        $("#itemTableBody").append(newRow);
    });

    // Remove row logic
    $(document).on("click", ".delete-row", function () {
        $(this).closest("tr").remove();
    });




    // Auto-calculate amount when quantity or unit price changes
    $(document).on("input", ".quantity, .unit-value", function () {
        const row = $(this).closest("tr");
        const qty = parseFloat(row.find(".quantity").val()) || 0;
        const unitPrice = parseFloat(row.find(".unit-value").val()) || 0;
        row.find(".total-value").val((qty * unitPrice).toFixed(2));
    });

    // Check for duplicate descriptions
    $(document).on("input", ".item-description", function () {
        checkDuplicates();
    });

    // Function to check for duplicate descriptions
    function checkDuplicates() {
        const descriptions = [];
        let duplicateFound = false;

        $(".item-description").each(function () {
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

    $("#inventoryForm").on("submit", function (event) {
    event.preventDefault(); // Prevent default form submission

    const formData = new FormData();

    // Add text data to the FormData object
    formData.append("slipNumber", $("#slipNumber").text().trim());
    formData.append("loggedBy", $("#loggedBy").val());
    formData.append("loggedById", $("#loggedById").val());
    formData.append("loggedDate", $("#loggedDate").val());

    // Add table data to the FormData object
    $("#itemTableBody tr").each(function () {
        const itemName = $(this).find("input[name='item_name[]']").val();
        const quantity = $(this).find("input[name='quantity[]']").val();
        const dateAcquired = $(this).find("input[name='date_acquired[]']").val();
        const unitValue = $(this).find("input[name='unit_value[]']").val();
        const itemDescription = $(this).find("input[name='item_description[]']").val();
        const totalValue = $(this).find("input[name='total_value[]']").val();
        const category = $(this).find("select[name='category[]']").val();
        const itemImage = $(this).find("input[name='item_image[]']")[0].files[0];  // Get the file

        if (itemName && quantity && unitValue && totalValue) {
            // Append item data to FormData
            formData.append("itemName[]", itemName);
            formData.append("quantity[]", quantity);
            formData.append("dateAcquired[]", dateAcquired);
            formData.append("unitValue[]", unitValue);
            formData.append("itemDescription[]", itemDescription);
            formData.append("totalValue[]", totalValue);
            formData.append("category[]", category);

            // If there's an image file, append it
            if (itemImage) {
                formData.append("itemImage[]", itemImage);
            }
        }
    });

    // Now send the FormData via AJAX
    $.ajax({
        url: "backend/process-inventory.php",
        method: "POST",
        data: formData,
        processData: false, // Important to prevent jQuery from automatically transforming the data
        contentType: false, // Important to tell jQuery not to set contentType (it will be automatically set to multipart/form-data)
        success: function (response) {
            console.log("Server Response:", response);
            if (response.success) {
                alert("Inventory form submitted successfully!");
                $("#inventoryForm")[0].reset();
                $("#itemTableBody").empty();
                $("#alertMessage").hide(); // Clear alert message
                window.location.reload();
            } else {
                alert("Failed to submit inventory form: " + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response Text:", xhr.responseText); // Log full response
            alert("An error occurred: " + xhr.responseText); // Show full error
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

</body>
</html>