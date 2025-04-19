<?php
// Start the session
session_start();

// Redirect if profile is already submitted
if (isset($_SESSION['profileSubmitted']) && $_SESSION['profileSubmitted'] === true) {
    header("Location: dashboard.php"); // Redirect to your desired page
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .prev-btn-container {
            text-align: left;
        }
        .image-preview-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
        .image-preview {
            width: 250px;
            height: 250px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd;
            background-color: #f0f0f0; /* Light background color for visibility */
        }
        .remove-file-btn {
            margin-left: 10px;
            background: rgb(220,220,220);
            border: none;
            font-size: 18px;
            cursor: pointer;
            position: absolute;
            right: -25px;
            top: 3px;
            display: none;
        }
        .upload-image-container {
            position: relative;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div id="formContainer" class="col-sm-9 col-md-7 col-lg-6 mx-auto">
            <div class="card border-0 shadow rounded-3 my-5">
                <div class="card-body p-4 p-sm-5">                    
                    <!-- Upload Files Form -->
                    <div id="uploadForm">
                        <h5 class="card-title text-center mb-5 fw-light fs-5">Upload Files</h5>
                        <form id="uploadFormForm" action="backend/upload_files.php" method="post" enctype="multipart/form-data">
                            <div class="form mb-3 upload-image-container">
                                <input type="file" class="form-control" id="fileUpload" name="fileUpload" accept="image/*" onchange="previewImage(event)">
                                <button type="button" class="remove-file-btn" onclick="removeFile()">X</button>
                            </div>
                            <div class="image-preview-container">
                                <img id="imagePreview" class="image-preview" src="" alt="">
                            </div>
                            <div class="prev-btn-container mb-3">
                                <a href="add-user-form.php"><button class="btn btn-secondary text-uppercase fw-bold" type="button">Prev</button></a>
                            </div>
                            <div class="d-grid next-btn-container">
                                <button class="btn btn-primary text-uppercase fw-bold" onclick="confirmSubmit(event)" type="button">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmSubmit(event) {
    event.preventDefault(); // Prevent the default form submission

    // Optional: Add any form validation or confirmation logic here

    // Submit the form programmatically
    document.getElementById('uploadFormForm').submit();

    // Redirect to summary.php
    window.location.href = 'summary.php';
}
</script>

<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('imagePreview');
    const removeBtn = document.querySelector('.remove-file-btn');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            const imageDataUrl = e.target.result;
            preview.src = imageDataUrl;
            preview.style.display = 'block';
            removeBtn.style.display = 'inline-block';

            // Save the image data URL to local storage
            localStorage.setItem('imagePreview', imageDataUrl);

            // Also save image name if needed
            localStorage.setItem('imageName', input.files[0].name);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function removeFile() {
    // Clear the image preview and file input value
    const preview = document.getElementById('imagePreview');
    const input = document.getElementById('fileUpload');
    const removeBtn = document.querySelector('.remove-file-btn');
   
    preview.src = ''; 
    preview.style.display = 'none'; 
    removeBtn.style.display = 'none'; 

    // Remove the image data URL from local storage
    localStorage.removeItem('imagePreview');

    // Clear the file input
    input.value = ''; 
}




// Load image preview from local storage on page load
window.onload = loadImagePreview;
</script>
</body>
</html>
