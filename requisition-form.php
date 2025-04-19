<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Issuance</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/sidebar-content.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <style>
        body, html {
            height: 100vh;
            overflow-y: auto;
        }
        .card {
            margin-bottom: 20px;
        }
      
    </style>
</head>
<body>
<!-- Sidebar -->
<?php include "backend/session-sidebar.php"?>

<?php require "header.php"?>

<!-- Main content -->
<div class="main-content">
    <div class="content"> 
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-3">
               
            </ol>
        </nav>
        <div class="container-fluid mt-4">
            <div class="requisition-form">
                <!-- Requisition Form -->
                <div class="card p-3 requisition-form">
                    <div class="card-header">
                        <h4 class="mb-0">Requisition Form</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <div class="requisition-form-content">
                            <!-- Upper right controls inside the form -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <!-- Left-aligned Control No. and Date Inputs -->
                                <div class="d-flex">
                                    <div class="me-3">
                                        <label for="controlNo" class="form-label">Control No.</label>
                                        <input type="text" id="controlNo" name="controlNo" class="form-control" placeholder="Control No.">
                                     </div>

                                    <div class="me-3">
                                        <label for="date" class="form-label">Date</label>
                                        <input type="date" id="date" class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="requestedBy" class="form-label">Requested By</label>
                                        <input type="text" id="requestedBy" class="form-control requestedBy" name="requestedBy" placeholder="Enter user ID, last name, middle name, or first name" autocomplete="off" required>

                                        <!-- Hidden input to store the selected userID -->
                                        <input type="hidden" name="requestedByUserID" class="requestedByUserID">

                                        <!-- Dynamic suggestion list -->
                                        <div class="requestedByList list-group" style="width:310px;"></div>
                                    </div>
                                </div>

                                <!-- Right-aligned Office/Department Input -->
                                    <div class="col-md-3 ms-auto">
                                        <label for="officeDepartment" class="form-label">Office/Department</label>
                                        <input type="text" id="officeDepartment" class="form-control officeDepartment" name="officeDepartment" placeholder="Enter office/department" autocomplete="off">
                                        
                                        <!-- Hidden input to store the selected departmentID -->
                                        <input type="hidden" name="officeDepartmentID" class="officeDepartmentID">
                                        
                                        <!-- Dynamic suggestion list -->
                                        <div class="officeDepartmentList list-group" style="width:310px;"></div>
                                    </div>

                            </div>

                            <div class="row">
                                <label class="form-label">Kindly furnish, provide, and/or purchase the following items requested below:</label>
                                <div class="col-3 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Medicines" id="medicines" name="category[]">
                                        <label class="form-check-label" for="medicines">Medicines</label>
                                    </div>
                                </div>
                                <div class="col-3 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Furniture" id="furniture" name="category[]">
                                        <label class="form-check-label" for="furniture">Furniture</label>
                                    </div>
                                </div>
                                <!-- New checkbox options -->
                                <div class="col-3 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Psychological Tests" id="psychologicalTests" name="category[]">
                                        <label class="form-check-label" for="psychologicalTests">Psychological Tests</label>
                                    </div>
                                </div>
                                <div class="col-3 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Lab Equipment/Machine" id="labEquipment" name="category[]">
                                        <label class="form-check-label" for="labEquipment">Lab Equipment/Machine</label>
                                    </div>
                                </div>
                                <div class="col-3 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Yearbook/Coffee Table Book" id="yearbook" name="category[]">
                                        <label class="form-check-label" for="yearbook">Yearbook/Coffee Table Book</label>
                                    </div>
                                </div>
                                <div class="col-3 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Campaign Materials for Marketing" id="campaignMaterials" name="category[]">
                                        <label class="form-check-label" for="campaignMaterials">Campaign Materials for Marketing</label>
                                    </div>
                                </div>
                                <div class="col-3 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Books/References/AV Materials" id="booksAVMaterials" name="category[]">
                                        <label class="form-check-label" for="booksAVMaterials">Books/References/AV Materials</label>
                                    </div>
                                </div>
                                <div class="col-3 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Others" id="others" name="category[]">
                                        <label class="form-check-label" for="others">Others</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-end">
                                <div class="col-3 mb-3">
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="additionalInput" placeholder="">  
                                        <button class="btn btn-outline-secondary" type="button" id="addAmountRow">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="dynamicFieldsContainer"></div>
                            </div>

                            <!-- Container to hold the dynamically added rows -->
                          
                             <!-- Submit Button Outside Form -->
                                <div class="text-center mt-4 d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary" id="submitFormsButton">Submit</button>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
let controlNoCounter = 1; // Default value for the first control number

// Function to fetch the latest Control No from the backend and generate the next one
function generateControlNo() {
    // Set the Control No to a placeholder (or leave it blank until fetched)
    document.getElementById('controlNo').value = "Fetching...";

    // Call AJAX to get the latest control number from the server
    $.ajax({
        url: 'backend/get_latest_control_no.php',  // URL for your backend script
        method: 'GET',  // Using GET to fetch the latest Control No
        success: function(response) {
            if (response.success) {
                // Get the latest Control No from the server response
                let latestControlNo = response.latestControlNo;  // assuming your server returns a control no like "DW-5"

                // Extract the number part and increment it
                let controlNoNumber = parseInt(latestControlNo.split('-')[1]) + 1;
                controlNoCounter = controlNoNumber;

                // Set the generated Control No in the form
                const controlNo = `DW-${controlNoCounter}`;
                document.getElementById('controlNo').value = controlNo;
            } else {
                console.error("Failed to fetch latest Control No: ", response.message);
                // If fetching fails, fallback to default DW-1 or use controlNoCounter as a base
                document.getElementById('controlNo').value = `DW-${controlNoCounter}`;
            }
        },
        error: function(xhr, status, error) {
            console.error("Error fetching Control No: ", status, error);
            // Fallback to DW-1 if there's an error with the AJAX call
            document.getElementById('controlNo').value = `DW-${controlNoCounter}`;
        }
    });
}

// Call generateControlNo when the page loads
window.onload = generateControlNo;
</script>


<script>
$(document).ready(function() {
    $('.requestedBy').on('input', function() {
        let query = $(this).val();
        if (query !== '') {
            $.ajax({
                url: 'backend/fetch-users.php', // Replace with the correct path to your PHP file
                method: 'GET',
                data: { query: query },
                success: function(response) {
                    let requestedByList = $('.requestedByList');
                    requestedByList.empty(); // Clear previous results

                    if (response.length > 0) {
                        // Populate the list with results
                        response.forEach(function(user) {
                            requestedByList.append(`
                                <a href="javascript:void(0);" class="list-group-item list-group-item-action requestedByOption" 
                                   data-userid="${user.userID}" 
                                   data-name="${user.firstName} ${user.middleName} ${user.lastName}">
                                  (${user.userID}) ${user.firstName} ${user.middleName} ${user.lastName}
                                </a>
                            `);
                        });
                    } else {
                        // If no users found
                        requestedByList.append('<a class="list-group-item">No users found</a>');
                    }
                },
                error: function() {
                    console.error('Error fetching data.');
                }
            });
        } else {
            // Clear suggestions if input is empty
            $('.requestedByList').empty();
        }
    });

    // Handle click on suggestion
    $(document).on('click', '.requestedByOption', function() {
        let userId = $(this).data('userid');
        let fullName = $(this).data('name');
        
        // Set the input field value to the selected user's full name
        $('.requestedBy').val(fullName);

        // Set the hidden input field value to the selected userID
        $('.requestedByUserID').val(userId);

        // Optionally, display the selected user details
       // $('.confirmedRequestedBy').html(`<strong>Selected User:</strong> ${userId} - ${fullName}`);

        // Clear the suggestions
        $('.requestedByList').empty();
    });
});


</script>


<script>
$(document).ready(function() {
    // Event handler for input on Office/Department field
    $('.officeDepartment').on('input', function() {
        let query = $(this).val();
        if (query !== '') {
            $.ajax({
                url: 'backend/fetch-departments.php', // Path to your PHP file
                method: 'GET',
                data: { query: query },
                success: function(response) {
                    let officeDepartmentList = $('.officeDepartmentList');
                    officeDepartmentList.empty(); // Clear previous results

                    if (response.length > 0) {
                        // Populate the list with results
                        response.forEach(function(department) {
                            officeDepartmentList.append(`
                                <a href="javascript:void(0);" class="list-group-item list-group-item-action officeDepartmentOption" 
                                   data-departmentid="${department.departmentID}" 
                                   data-name="${department.departmentName}">
                                  (${department.departmentID}) ${department.departmentName}
                                </a>
                            `);
                        });
                    } else {
                        // If no departments found
                        officeDepartmentList.append('<a class="list-group-item">No departments found</a>');
                    }
                },
                error: function() {
                    console.error('Error fetching data.');
                }
            });
        } else {
            // Clear suggestions if input is empty
            $('.officeDepartmentList').empty();
        }
    });

    // Handle click on suggestion
    $(document).on('click', '.officeDepartmentOption', function() {
        let departmentId = $(this).data('departmentid');
        let departmentName = $(this).data('name');
        
        // Set the input field value to the selected department's name
        $('.officeDepartment').val(departmentName);

        // Set the hidden input field value to the selected departmentID
        $('.officeDepartmentID').val(departmentId);

        // Clear the suggestions
        $('.officeDepartmentList').empty();
    });
});
</script>

<script>
$(document).ready(function() {
    // Function to generate input rows based on quantity
    function generateInputRows(quantity) {
        // Clear the container before adding new fields (ensures no duplicates)
        $('#dynamicFieldsContainer').empty();

        // Loop through the quantity and create rows
        for (var i = 0; i < quantity; i++) {
            // Create a new row with input fields, appending index `i` to each ID
            var newRow = `
            <div class="row mb-3">
                <div class="col-3 mb-3">
                    <label for="qty${i}" class="form-label">QTY.</label>
                    <input type="number" class="form-control" name="qty[]" id="qty${i}" min="1">
                </div>
                <div class="col-4 mb-3">
                    <label for="description${i}" class="form-label">DESCRIPTION/PARTICULARS</label>
                    <textarea class="form-control" rows="3" name="description[]" id="description${i}"></textarea>
                </div>
                <div class="col-3 mb-3">
                    <label for="amount${i}" class="form-label">AMOUNT</label>
                    <input type="number" class="form-control" name="amount[]" id="amount${i}" placeholder="Enter amount">
                </div>
            </div>
            `;
            // Append the new row to the container
            $('#dynamicFieldsContainer').append(newRow);
        }
    }

    // Initially generate 1 row when the page loads
    generateInputRows(1);

    // Handle the click event for the add button
    $('#addAmountRow').click(function() {
        // Get the quantity value entered by the user
        var quantity = parseInt($('#additionalInput').val());

        // Ensure the quantity is a valid number and greater than 0
        if (quantity && quantity > 0) {
            // Call generateInputRows with the given quantity
            generateInputRows(quantity);
        } else {
            // Show an error message if the quantity is invalid
            alert("Please enter a valid quantity.");
        }
    });

    // Handle form submission
    $('#submitFormsButton').on('click', function() {
        // Gather selected categories
        let selectedCategories = [];
        $('input[name="category[]"]:checked').each(function() {
            selectedCategories.push($(this).val());
        });

        // Combine categories into a single string
        let combinedCategories = selectedCategories.join(', ');

        // Gather item data from dynamically created fields
        let items = [];
        // Loop through each dynamically created row and gather the data
        $('input[name="qty[]"]').each(function(index) {
            let qty = $(this).val();
            let description = $('textarea[name="description[]"]').eq(index).val();
            let amount = $('input[name="amount[]"]').eq(index).val();

            // Ensure we only push non-empty rows
            if (qty && description && amount) {
                let item = {
                    category: combinedCategories,  // Store combined categories for each item
                    quantity: qty,                 // Quantity
                    description: description,      // Description
                    amount: amount                 // Amount
                };
                items.push(item);  // Add item to the items array
            }
        });

        // If no items are filled out, alert the user
        if (items.length === 0) {
            alert("Please fill out at least one row with valid data.");
            return; // Prevent submission
        }

        // Build formData object
        let formData = {
            controlNo: $('#controlNo').val(),
            date: $('#date').val(),
            requestedBy: $('.requestedByUserID').val(),
            officeDepartment: $('.officeDepartmentID').val(),
            items: items  // Add items array (containing all item data)
        };

        // Log form data for debugging
        console.log("Form Data (Before Submission):", formData);
        
        // Now send the `formData` object with AJAX
        $.ajax({
            type: 'POST',
            url: 'backend/submit_requisition_form.php',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            success: function(response) {
                console.log("Server Response: ", response);
                console.log("Submitted Data:", formData);

                if (response.success) {
                // Display a success alert
                alert("Form submitted successfully!");
                // Optionally, you can reset the form or redirect to another page
                // $('#myForm')[0].reset(); // If you want to reset the form
                // window.location.href = "success_page.php"; // If you want to redirect to a success page
                   
                 // Call generateControlNo to update the control number
                 generateControlNo();  // Trigger control number generation after successful submission
                    // Reset the static form fields

                    $('#date').val('');
                    $('#requestedBy').val('');
                    $('#officeDepartment').val('');
                    $('.requestedByUserID').val('');
                    $('.officeDepartmentID').val('');
                    
                    // Reset checkboxes
                    $('input[name="category[]"]').prop('checked', false);
                    
                    // Clear dynamic fields (rows)
                    $('#dynamicFieldsContainer').empty(); 

                    // Optionally reset the additional input field
                    $('#additionalInput').val('');
                    
            } else {
                alert("Failed to submit the form: " + response.message);
            }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error: ", textStatus, errorThrown);
                console.log("Server Response: ", jqXHR.responseText); // Log full server response
            }
        });
    });
});


</script>



</body>
</html>
