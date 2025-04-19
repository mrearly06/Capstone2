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
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card container-summary">
                <h2 class="text-center mb-4">Form Summary</h2>
                <p class="note text-center">Please review the details below and make sure they are correct.</p>
                <div class="row g-0">
                    <div class="col-md-4 image-container">
                        <img id="uploadedImage" src="" alt="Uploaded Image" class="image-preview">
                    </div>
                    <div class="col-md-6 text-container">
                        <div class="card-body">
                            <div id="summaryContent">
                                <!-- Content will be populated by JavaScript -->
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
  window.onload = function() {
    const formData = JSON.parse(localStorage.getItem('formData')) || {};
    const imagePreview = localStorage.getItem('imagePreview');
    const imageName = localStorage.getItem('imageName');

    if (formData) {
        // Populate the summary content
        const summaryContent = document.getElementById('summaryContent');
        summaryContent.innerHTML = `
            <div class="row pb-3 grid-row">
                <div class="col-md-4 d-flex flex-column"><h4>First Name:</h4> <h5>${formData.firstName || ''}</h5></div>
                <div class="col-md-4 d-flex flex-column"><h4>Middle Name:</h4>  <h5>${formData.middleName || ''}</h5></div>
                <div class="col-md-4 d-flex flex-column"><h4>Last Name:</h4>  <h5>${formData.lastName || ''}</h5></div>
            </div>
            <div class="row pb-3 grid-row">
                <div class="col-md-4"><h4>Address:</h4>  <h5>${formData.address || ''}</h5></div>
                <div class="col-md-4"><h4>Birthdate:</h4>  <h5>${formData.birthdate || ''}</h5></div>
                <div class="col-md-4"><h4>Phone No:</h4>  <h5>${formData.phoneNo || ''}</h5></div>
            </div>
            <div class="row grid-row">
                <div class="col-md-6"><h4>Department/Office:</h4>   <h5>${formData.departmentOffice || ''}</h5></div>
                <div class="col-md-4"><h4>Position:</h4>   <h5>${formData.position || ''}</h5></div>
            </div>
        `;

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
}

function submitForm() {
    document.getElementById('hiddenForm').submit();
}

</script>
</body>
</html>
