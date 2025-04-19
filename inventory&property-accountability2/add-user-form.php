<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<!-- Font Awesome for Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<style>
    body{
        background-color: rgb(240,240,240);
    }
    .container-form{
        height:60vh;
        background-color: #fff;
    }

</style>
</head>
<body>
 <!-- Additional Information Form -->

<div class="container align-self-center border border-3 mt-5 rounded container-form">
    <div id="additionalInfoForm">
        <h5 class="card-title text-center mb-3 fw-light fs-5 pt-5">User Profile Form</h5>
        <form id="additionalInfoForm" action="database/save_additional_info.php" method="post">
            <div class="container">
                <!-- First Row -->
                <div class="row mb-3">
                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name">
                            <label for="firstName">First Name</label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="middleName" name="middleName" placeholder="Middle Name">
                            <label for="middleName">Middle Name</label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name">
                            <label for="lastName">Last Name</label>
                        </div>
                    </div>
                </div>

                <!-- Second Row -->
                <div class="row mb-3">
                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="address" name="address" placeholder="Address">
                            <label for="address">Address</label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <input type="date" class="form-control" id="birthdate" name="birthdate" placeholder="Birthdate">
                            <label for="birthdate">Birthdate</label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="phoneNo" name="phoneNo" placeholder="Phone No.">
                            <label for="phoneNo">Phone No.</label>
                        </div>
                    </div>
                </div>

                <!-- Third Row -->
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <select class="form-control" id="departmentOffice" name="departmentOffice">
                                <option value="">Select Department/Office</option>
                                <?php
                                include "backend/connection.php";
                                // Fetch departments
                                $sql = "SELECT departmentID, departmentName FROM department";
                                $result = $conn->query($sql);

                                // Generate options
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['departmentName'] . '">' . $row['departmentName'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No departments available</option>';
                                }

                                // Close the connection
                                $conn->close();
                                ?>
                            </select>
                            <label for="departmentOffice">Department/Office</label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="position" name="position" placeholder="Position">
                            <label for="position">Position</label>
                        </div>
                    </div>
                </div>

                <!-- Next Button -->
                <div class="next-btn-container">
                    <a href="upload-profile-image.php" class="btn btn-primary float-end">Next</a>
                </div>
            </div>
        </form>
    </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', (event) => {
    // Load saved form data if available
    if (localStorage.getItem('formData')) {
        const formData = JSON.parse(localStorage.getItem('formData'));
        Object.keys(formData).forEach(key => {
            const field = document.getElementById(key);
            if (field) field.value = formData[key];
        });
    }

    // Save form data on input changes
    document.getElementById('additionalInfoForm').addEventListener('input', () => {
        const formElements = document.querySelectorAll('#additionalInfoForm input, #additionalInfoForm select');
        const formData = {};
        formElements.forEach(element => {
            formData[element.id] = element.value;
        });
        localStorage.setItem('formData', JSON.stringify(formData));
    });
});
</script>


<!-- Bootstrap JS with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kzZZmPzHnhA03JhLXMKhHQh3fELhWcRsEGhaOGFkMNsVFsBePbZXD8tUWR1GRfRr" crossorigin="anonymous"></script>

<!-- Font Awesome JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

</body>
</html>