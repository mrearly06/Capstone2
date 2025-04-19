<?php
// Start the session
session_start();

// Redirect if profile is already submitted
if (isset($_SESSION['profileSubmitted']) && $_SESSION['profileSubmitted'] === true) {
    header("Location: dashboard.php"); // Redirect to your desired page
    exit();
}
// Get the userType from the session
$userType = isset($_SESSION['userType']) ? $_SESSION['userType'] : 'guest';

// Pass the userType to JavaScript
echo "<script>var userType = '$userType';</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: rgb(200, 200, 200);
        }
        .container-summary {
            border: 2px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            background-color: #fff;
        }
        .image-preview {
            margin-top:50px;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd;
            background-color: #f0f0f0;
            background-size: cover;
            background-position: center;
        }
        .image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 20px;
        }
        .text-container {
            flex: 1;
        }
        .grid-row {
            margin-bottom: 20px;
        }
        .note {
            margin-bottom: 20px;
            font-weight: bold;
            color: #ff0000;
        }
        /* Hide the form */
        .hidden-form {
            display: none;
        }

        .image-container {
    display: flex;
    justify-content: center;
    align-items: center;
}

.list-group {
    margin-top: 20px;
}

.list-group-item {
    padding: 15px;
    border: none;
    border-radius: 0;
}

.list-group-item:not(:last-child) {
    border-bottom: 1px solid #dee2e6;
}
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card container-summary">
           
                                <!-- Content will be populated by JavaScript -->
                        
                <p class="note text-center">Please review the details below and make sure they are correct.</p>
                <div class="row g-0">
                    <div class="col-md-12">
                    <div id="summaryContent">
                        <img id="uploadedImage" src="" alt="Uploaded Image" class="image-preview float-start me-3 mb-3">
                        <div class="list-group">
                            <div class="list-group-item">
                                <ul class="list-unstyled">
                                    <li>First Name:<strong> <span id="firstNameDisplay"> </strong></span></li>
                                    <li>Middle Name:<strong> <span id="middleNameDisplay"> </strong></span></li>
                                    <li>Last Name:<strong> <span id="lastNameDisplay"> </strong></span></li>
                                </ul>
                            </div>
                            <div class="list-group-item">
                                <ul class="list-unstyled">
                                    <li>Address:<strong> <span id="addressDisplay"></strong></span></li>
                                    <li>Birthdate:<strong> <span id="birthdateDisplay"></strong></span></li>
                                    <li>Phone No:<strong> <span id="phoneNoDisplay"></strong></span></li>
                                </ul>
                            </div>
                            <div class="list-group-item">
                                <ul class="list-unstyled">
                                    <li>Department/Office:</strong><strong> <span id="departmentOfficeDisplay"></strong></span></li>
                                    <li>Position:<strong><span id="positionDisplay"></span></strong></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="d-grid gap-2 col-6 mx-auto mt-4">
                    <button id="submitData" class="btn btn-primary btn-lg" type="button" onclick="submitForm()">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Hidden Form -->
<form id="hiddenForm" class="hidden-form" action="backend/submit-user-query.php" method="post">
    <input type="hidden" name="firstName" id="firstName">
    <input type="hidden" name="middleName" id="middleName">
    <input type="hidden" name="lastName" id="lastName">
    <input type="hidden" name="address" id="address">
    <input type="hidden" name="birthdate" id="birthdate">
    <input type="hidden" name="phoneNo" id="phoneNo">
    <input type="hidden" name="departmentOffice" id="departmentOffice">
    <input type="hidden" name="position" id="position">
    <input type="hidden" name="image" id="image">
    <input type="hidden" name="imageName" id="imageName"> <!-- Add this field -->
</form>

<script>
console.log('Current user type:', userType);

window.onload = function() {
    const formData = JSON.parse(localStorage.getItem('formData')) || {};
    const imagePreview = localStorage.getItem('imagePreview');
    const imageName = localStorage.getItem('imageName');

    if (formData) {
        // Populate the summary content
        document.getElementById('firstNameDisplay').textContent = formData.firstName || '';
        document.getElementById('middleNameDisplay').textContent = formData.middleName || '';
        document.getElementById('lastNameDisplay').textContent = formData.lastName || '';
        document.getElementById('addressDisplay').textContent = formData.address || '';
        document.getElementById('birthdateDisplay').textContent = formData.birthdate || '';
        document.getElementById('phoneNoDisplay').textContent = formData.phoneNo || '';
        document.getElementById('departmentOfficeDisplay').textContent = formData.departmentOffice || '';
        document.getElementById('positionDisplay').textContent = formData.position || '';

        if (imagePreview) {
            document.getElementById('uploadedImage').src = imagePreview;
            document.getElementById('uploadedImage').style.display = 'block';
        }

        // Populate the hidden form fields
        document.getElementById('firstName').value = formData.firstName || '';
        document.getElementById('middleName').value = formData.middleName || '';
        document.getElementById('lastName').value = formData.lastName || '';
        document.getElementById('address').value = formData.address || '';
        document.getElementById('birthdate').value = formData.birthdate || '';
        document.getElementById('phoneNo').value = formData.phoneNo || '';
        document.getElementById('departmentOffice').value = formData.departmentOffice || '';
        document.getElementById('position').value = formData.position || '';
        document.getElementById('image').value = imagePreview || '';
        document.getElementById('imageName').value = imageName || '';
    } else {
        document.getElementById('summaryContent').innerHTML = '<p>No data available.</p>';
    }

    console.log('Page loaded. Current user type:', userType);
}

function submitForm() {
    document.getElementById('hiddenForm').submit();
}

</script>
</body>
</html>