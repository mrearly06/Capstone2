<?php
// Check if issuanceNo is present in the URL query string
$issuanceNo = isset($_GET['issuanceNo']) ? $_GET['issuanceNo'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Issuance</title>
    <!-- Add your CSS links here -->

    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background-color: #343a40;
            color: #fff;
            transition: all 0.3s;
            overflow-y: auto;
        }
        .sidebar .nav-link {
            color: #fff;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
            color: #fff;
        }
        .sidebar .nav-item.active .nav-link {
            background-color: #007bff;
        }
        .main-content {
            margin-left: 250px;
            transition: margin-left 0.3s;
            background-color: rgb(240,240,240);
            height: 100vh;
        }
        .sidebar-collapse .main-content {
            margin-left: 0;
        }
        .card {
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #f1f3f5;
        }
        .title-logo {
            background-color: #3e4348;
            padding: 1rem;
            filter: saturate(1.2);
        }
        .card {
            margin-bottom: 20px;
        }
        .table-responsive {
            max-height: 400px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<?php include "backend/session-sidebar.php"?>


    <?php require "header.php" ?>

    <!-- Main content -->
<div class="main-content">
    
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb p-3">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Inventory</a></li>
            <li class="breadcrumb-item active" aria-current="page">Item Inventory</li>
        </ol>
    </nav>
    <!-- End Breadcrumbs -->

<?php
// Start the session at the beginning of your script
// Check if there is a success message
if (isset($_SESSION['success_message'])) {
    echo "
    <div class='alert alert-success alert-dismissible fade show' role='alert' id='success-alert'>
        " . $_SESSION['success_message'] . "
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>
    <script>
        // Auto-hide the alert after 6 seconds (6000 milliseconds)
        setTimeout(function() {
            let alert = document.getElementById('success-alert');
            if (alert) {
                alert.classList.remove('show'); // Hide the alert
                alert.classList.add('fade');    // Add fade class for transition
                setTimeout(function() {
                    alert.remove(); // Remove it from DOM after fade
                }, 500); // Wait for the fade-out transition to complete
            }
        }, 6000);
    </script>
    ";
    // Unset the message so it doesn't show again on refresh
    unset($_SESSION['success_message']);
}
?>



    <!-- Issuance Form -->
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h5>Property Issuance Form</h5>
            </div>
            <div class="card-body">
            <form class="propertyIssuanceForm" action="backend/add-issuance-request-query.php" method="POST">
                <div class="row">
                    <!-- Issuance Number and other fields -->
                  
                    <div class="col-md-4 mb-3">
                        <label for="issuanceDateStart" class="form-label">Issuance Date Start</label>
                        <input type="date" class="form-control issuanceDateStart" name="issuanceDateStart" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="issuanceDateEnd" class="form-label">Issuance Date End</label>
                        <input type="date" class="form-control issuanceDateEnd" name="issuanceDateEnd" required>
                    </div>
                 <!--     <div class="col-md-4 mb-3">
                        Text input to show the userID from session 
                        <input type="hidden" class="form-control requestedBy" name="requestedBy" value="<?php echo $userID; ?>" readonly>
                    </div>
                    -->
                </div>

                <div class="row">
                    <!-- Issuance Purpose (Checkboxes), Issued To, and Issued By fields -->
                    <div class="col-md-4 mb-3">
                    <label for="issuancePurpose" class="form-label">Issuance Purpose</label>
                    
                    <!-- Official Use Checkbox -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="issuancePurpose[]" value="Official Use" id="officialUse">
                        <label class="form-check-label" for="officialUse">Official Use</label>
                    </div>
                    
                    <!-- Replacement Checkbox -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="issuancePurpose[]" value="Replacement" id="replacement">
                        <label class="form-check-label" for="replacement">Replacement</label>
                    </div>
                    
                    <!-- Event Support Checkbox -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="issuancePurpose[]" value="Event Support" id="eventSupport">
                        <label class="form-check-label" for="eventSupport">Event Support</label>
                    </div>
                    
                    <!-- Temporary Checkbox -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="issuancePurpose[]" value="Temporary" id="temporary">
                        <label class="form-check-label" for="temporary">Temporary</label>
                    </div>
                    
                    <!-- Others Checkbox -->
                    <div class="form-check">
                        <input class="form-check-input othersCheckbox" type="checkbox" name="issuancePurpose[]" value="Others" id="others">
                        <label class="form-check-label" for="others">Others</label>
                    </div>
                    
                    <!-- Text input that becomes enabled when 'Others' is checked -->
                    <input type="text" class="form-control mt-2 othersInput" name="otherPurposeDetails" placeholder="Please specify" disabled>
                </div>


                <div class="col-md-4 mb-3">
                    <label for="issuedTo" class="form-label">Issued To</label>
                    <input type="text" class="form-control issuedTo" name="issuedTo" placeholder="Enter user ID, last name, middle name, or first name" autocomplete="off" required>

                    <!-- Hidden input to store the selected userID -->
                    <input type="hidden" name="userID" class="userID">

                    <!-- Dynamic suggestion list -->
                    <div class="issuedToList list-group" style="width:310px;"></div>

                    <!-- Display the confirmed issuedTo value here -->
                    <div class="confirmedIssuedTo mt-2"></div>
                </div>


                </div>

                <!-- Item Code with dynamic search -->
                <div class="col-md-4 mb-3">
    <label for="itemCode" class="form-label">Asset</label>
    <div class="itemCode-button d-flex gap-1">
        <input type="text" class="form-control itemCode" name="itemCode" placeholder="Enter item code or name" autocomplete="off">

        <!-- Confirm Button -->
        <div class="text-end mt-2">
            <button type="button" class="btn btn-success confirmButton">Confirm</button>
        </div>
    </div>

    <div class="itemCodeList list-group" style="width:310px;"></div> <!-- For dynamic suggestions -->

    <!-- Display the confirmed itemCode value here -->
    <div class="confirmedItemCode mt-2"></div>

    <!-- Container for dynamically added input fields -->
    <div class="selectedItemsContainer mt-3"></div>
</div>


                <!-- Button to Add Another Form -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

            </div>
        </div>

       

    </div>
    <!-- End Issuance Form -->

</div> <!-- End of Main Content -->

<!-- Bootstrap JS (with Popper) -->
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {

// Handle dynamic item search and selection
function setupItemSearch(form) {
    var $itemCodeInput = form.find('.itemCode');
    var $itemCodeList = form.find('.itemCodeList');
    var $confirmedItemCode = form.find('.confirmedItemCode');

    // Container to hold dynamically added input fields for confirmed items
    var $selectedItemsContainer = form.find('.selectedItemsContainer');

    // Variable to temporarily store selected item before confirmation
    var selectedItemCode = '';
    var selectedItemNo = '';

    $itemCodeInput.on('input', function() {
        var query = $(this).val();
        if (query.length > 1) {
            $.ajax({
                url: 'backend/search-items.php',
                method: 'POST',
                data: { query: query },
                success: function(data) {
                    $itemCodeList.html(data);
                }
            });
        } else {
            $itemCodeList.html('');
        }
    });

    // Select item from the search list
    $itemCodeList.on('click', '.list-group-item', function(e) {
        e.preventDefault();
        selectedItemCode = $(this).text();
        selectedItemNo = $(this).data('itemno'); // Assuming you have a data attribute for itemNo

        // Add the selected item code to the input field and clear the list
        $itemCodeInput.val(selectedItemCode);
        $itemCodeList.html('');
    });

    // Confirm button logic: only add the hidden input when confirmed
    form.find('.confirmButton').click(function() {
        if (selectedItemCode) {
            // Append a new hidden input for the confirmed item
            $selectedItemsContainer.append(`
                <div class="form-group mt-2">
                    <input type="text" name="itemNo[]" value="${selectedItemNo}"> <!-- Hidden input for itemNo -->
                </div>
            `);

            // Display confirmed item for user feedback
            $confirmedItemCode.append(`<div><strong>Confirmed Item:</strong> ${selectedItemCode}</div>`);

            // Clear the input field and reset the stored values
            $itemCodeInput.val('');
            selectedItemCode = '';
            selectedItemNo = '';
        }
    });
}

// Setup initial form's dynamic search
setupItemSearch($('.propertyIssuanceForm'));
});



</script>


<script>
// JavaScript to enable/disable the text input based on the 'Others' checkbox
document.querySelector('.othersCheckbox').addEventListener('change', function() {
    const othersInput = document.querySelector('.othersInput');
    othersInput.disabled = !this.checked;  // Enable input if 'Others' is checked
    if (!this.checked) {
        othersInput.value = '';  // Clear input if checkbox is unchecked
    }
});


$(document).ready(function() {
    $('.issuedTo').on('input', function() {
        let query = $(this).val();
        if (query !== '') {
            $.ajax({
                url: 'backend/fetch-users.php', // Replace with the correct path to your PHP file
                method: 'GET',
                data: { query: query },
                success: function(response) {
                    let issuedToList = $('.issuedToList');
                    issuedToList.empty(); // Clear previous results

                    if (response.length > 0) {
                        // Populate the list with results
                        response.forEach(function(user) {
                            issuedToList.append(`
                                <a href="javascript:void(0);" class="list-group-item list-group-item-action issuedToOption" 
                                   data-userid="${user.userID}" 
                                   data-name="${user.firstName} ${user.middleName} ${user.lastName}">
                                   ${user.userID} - ${user.firstName} ${user.middleName} ${user.lastName}
                                </a>
                            `);
                        });
                    } else {
                        // If no users found
                        issuedToList.append('<a class="list-group-item">No users found</a>');
                    }
                },
                error: function() {
                    console.error('Error fetching data.');
                }
            });
        } else {
            // Clear suggestions if input is empty
            $('.issuedToList').empty();
        }
    });

    // Handle click on suggestion
    $(document).on('click', '.issuedToOption', function() {
        let userId = $(this).data('userid');
        let fullName = $(this).data('name');
        
        // Set the input field value to the selected user's full name
        $('.issuedTo').val(fullName);

        // Set the hidden input field value to the selected userID
        $('.userID').val(userId);

        // Optionally, display the selected user details
        $('.confirmedIssuedTo').html(`<strong>Selected User:</strong> ${userId} - ${fullName}`);

        // Clear the suggestions
        $('.issuedToList').empty();
    });
});



</script>
</html>
