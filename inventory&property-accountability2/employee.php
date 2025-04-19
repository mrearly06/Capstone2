<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Inventory</title>

    <link rel="stylesheet" type="text/css" href="style/inventory.css">
          <!------ Custom Style   ------------------------------>
          <link rel="stylesheet" type="text/css" href="assets/css/sidebar-content.css">
    

  
    <style>
  
    .card {
        background-color: #fff; /* Card background color */
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        margin-bottom: 20px;
    }
    .card-header {
        background-color: #f1f3f5; /* Slightly gray header */
        font-weight: bold;
    }
    .campuz-container {
        display: flex;
        flex-direction: column;
    }
    .card-body {
        padding: 0;
    }
    .department-list{
        max-height:20vh;
        overflow:auto;
    }
    .department-list, .user-list {
        list-style-type: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-wrap: wrap;
    }
    .department-list li, .user-list li {
        margin: 10px;
        flex: 1 1 calc(33.333% - 20px); /* 3 columns with margin adjustment */
        box-sizing: border-box;
    }
    .user-list {
    display: flex; /* Align items horizontally */
    flex-wrap: wrap; /* Allow items to wrap to the next line */
    gap: 10px; /* Space between items */
    list-style-type: none; /* Remove bullets from list */
    padding: 0; /* Remove padding */
    margin: 0; /* Remove margin */
}

.user-list li {
    display: flex; /* Use Flexbox for the list items */
    flex-direction: column; /* Stack image and name vertically */
    align-items: center; /* Center align items horizontally */
    text-align: center; /* Center text */
    border: 1px solid #ddd; /* Optional: Add border for better visibility */
    border-radius: 5px; /* Optional: Add rounded corners */
    padding: 10px; /* Add padding inside list item */
    background-color: #fff; /* Background color for list item */
}

.user-list img {
    border-radius: 50%; /* Make image circular */
    width: 80px; /* Set a fixed width for images */
    height: 80px; /* Set a fixed height for images */
    object-fit: cover; /* Ensure image covers the container */
    margin-bottom: 5px; /* Space between image and name */
}

</style>

</head>
<body>
 
<!-- Sidebar -->
<?php include "backend/session-sidebar.php"?>
<?php require "header.php" ?>
    <!-- Main content -->
    <div class="main-content">
       

    <div class="content1"> 
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Inventory</a></li>
                <li class="breadcrumb-item active" aria-current="page">Campus Inventory</li>
            </ol>
        </nav>
        <!-- End Breadcrumbs -->

    <div class="container campuz-container">
    <!-- North Campus -->
    <div class="card">
        <div class="card-header">
            North Campus
        </div>
        <div class="card-body">
            <!-- Departments/Offices -->
            <?php
                    // Include your database connection script
                    include 'backend/connection.php';

                    $desiredCampus = 'North';
                    // Query to fetch department names from the department table
                    $query = "SELECT departmentName FROM department WHERE campus = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('s', $desiredCampus);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Check if the query was successful
                    if ($result && $result->num_rows > 0) {
                        echo '<div class="department-list-container">';
                        echo '<!-- Departments/Offices -->';
                        echo '<ul class="department-list d-flex flex-column flex-wrap">';

                        // Fetch each row and generate the list items
                        while ($row = $result->fetch_assoc()) {
                            $departmentName = htmlspecialchars($row['departmentName']);
                            echo '<li><strong class="bg-secondary-subtle rounded px-3 py-2 d-inline-block">' . $departmentName . '</strong></li>';
                        }

                        echo '</ul>';
                        echo '</div>';
                    } else {
                        // Handle the case where no departments are found or query failed
                        echo '<div class="department-list-container">';
                        echo '<!-- Departments/Offices -->';
                        echo '<ul class="department-list d-flex flex-column flex-wrap text-center">';
                        echo '<li><strong class="text-secondary px-3 py-2 d-inline-block">No departments available</strong></li>';
                        echo '</ul>';
                        echo '</div>';
                    }

                    // Close the database connection
                    $conn->close();
                    ?>

            <!-- Users in Department of Computer Science -->
            <div class="card mt-4">
                <div class="card-header">
                    Users in Department of Computer Science
                </div>
                <?php
                    // Include your database connection script
                    include 'backend/connection.php';

                    // Set the desired campus to filter by
                    $desiredCampus = 'North';

                    // Query to fetch user profiles based on campus
                    $query = "
                        SELECT u.userID, u.firstName, u.middleName, u.lastName, u.userImage 
                        FROM user u
                        JOIN department d ON u.department = d.departmentID
                        WHERE d.campus = ?
                    ";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('s', $desiredCampus);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Check if the query was successful
                    if ($result && $result->num_rows > 0) {
                        echo '<div class="card-body">';
                        echo '<div class="user-cards-container d-flex flex-wrap gap-3">';

                        // Fetch each row and generate the user cards
                        while ($row = $result->fetch_assoc()) {
                            $userID = htmlspecialchars($row['userID']);
                            $firstName = htmlspecialchars($row['firstName']);
                            $middleName = htmlspecialchars($row['middleName']);
                            $lastName = htmlspecialchars($row['lastName']);
                            $userImage = htmlspecialchars($row['userImage']); // Assuming userImage contains the file name
                            
                             // Get the first letter of the middle name
                             $middleInitial = !empty($middleName) ? substr($middleName, 0, 1) . '.' : '';

                            // Construct full name
                            $fullName = trim("$firstName $middleInitial $lastName");

                            echo '<div class="card" style="width: 12rem;">';
                            echo '<img src="uploads/' . $userImage . '" class="card-img-top rounded-circle" alt="' . $fullName . '" onclick="window.location.href=\'user-profile.php?id=' . $userID . '\'">';
                            echo '<div class="card-body text-center">';
                            echo '<h6 class="card-title">' . $fullName . '</h6>';
                            echo '</div>';
                            echo '</div>';
                        }

                        echo '</div>';
                        echo '</div>';
                    } else {
                        // Handle the case where no users are found or query failed
                        echo '<div class="card-body">';
                        echo '<div class="container" style="width: 100%;">';
                        echo '<div class="card-body text-center text-secondary">';
                        echo '<h6 class="card-title">No users available for this campus</h6>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }

                    // Close the statement and the connection
                    $stmt->close();
                    $conn->close();
                    ?>

            </div>
        </div>
    </div>
    <!-- End North Campus -->

    <!-- South Campus -->
    <div class="card mt-4">
        <div class="card-header">
            South Campus
        </div>
        <div class="card-body">
            <?php
                // Include your database connection script
                include 'backend/connection.php';

                // Set the desired campus to filter by
                $desiredCampus = 'South';

                // Query to fetch department names and campuses from the department table
                $query = "SELECT departmentName FROM department WHERE campus = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('s', $desiredCampus);
                $stmt->execute();
                $result = $stmt->get_result();

                // Check if the query was successful
                if ($result && $result->num_rows > 0) {
                    echo '<div class="department-list-container">';
                    echo '<!-- Departments/Offices -->';
                    echo '<ul class="department-list d-flex flex-column flex-wrap">';

                    // Fetch each row and generate the list items
                    while ($row = $result->fetch_assoc()) {
                        $departmentName = htmlspecialchars($row['departmentName']);
                        echo '<li><strong class="bg-secondary-subtle rounded px-3 py-2 d-inline-block">' . $departmentName . '</strong></li>';
                    }

                    echo '</ul>';
                    echo '</div>';
                } else {
                    // Handle the case where no departments are found or query failed
                    echo '<div class="department-list-container">';
                    echo '<!-- Departments/Offices -->';
                    echo '<ul class="department-list d-flex flex-column flex-wrap text-center">';
                    echo '<li><strong class="text-secondary px-3 py-2 d-inline-block">No user available for this campus</strong></li>';
                    echo '</ul>';
                    echo '</div>';
                }

                // Close the statement and the connection
                $stmt->close();
                $conn->close();
                ?>

            <!-- Users in Department of Business Administration -->
            <div class="card mt-4">
                <div class="card-header">
                    Users in Department of Business Administration
                </div>
                <div class="card-body">
                <?php
                    // Include your database connection script
                    include 'backend/connection.php';

                    // Set the desired campus to filter by
                    $desiredCampus = 'South';

                    // Query to fetch user profiles based on campus
                    $query = "
                        SELECT u.userID, u.firstName, u.middleName, u.lastName, u.userImage 
                        FROM user u
                        JOIN department d ON u.department = d.departmentID
                        WHERE d.campus = ?
                    ";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('s', $desiredCampus);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Check if the query was successful
                    if ($result && $result->num_rows > 0) {
                        echo '<div class="user-cards-container d-flex gap-3">';

                        // Fetch each row and generate the user cards
                        while ($row = $result->fetch_assoc()) {
                            $userID = htmlspecialchars($row['userID']);
                            $firstName = htmlspecialchars($row['firstName']);
                            $middleName = htmlspecialchars($row['middleName']);
                            $lastName = htmlspecialchars($row['lastName']);
                            $userImage = htmlspecialchars($row['userImage']); // Assuming userImage contains the file name

                            // Get the first letter of the middle name
                            $middleInitial = !empty($middleName) ? substr($middleName, 0, 1) . '.' : '';

                            // Construct full name with the middle initial
                            $fullName = trim("$firstName $middleInitial $lastName");

                            echo '<div class="card" style="width: 12rem;">';
                            echo '<img src="uploads/' . $userImage . '" class="card-img-top rounded-circle"  style="width: 12rem; alt="' . $fullName . '" onclick="window.location.href=\'user-profile.php?id=' . $userID . '\'">';
                            echo '<div class="card-body text-center">';
                            echo '<h6 class="card-title">' . $fullName . '</h6>';
                            echo '</div>';
                            echo '</div>';
                        }

                        echo '</div>';
                    } else {
                        // Handle the case where no departments are found or query failed
                        echo '<div class="department-list-container">';
                        echo '<!-- Departments/Offices -->';
                        echo '<ul class="department-list d-flex flex-column flex-wrap text-center">';
                        echo '<li><strong class="text-secondary px-3 py-2 d-inline-block">No user available for this campus</strong></li>';
                        echo '</ul>';
                        echo '</div>';
                    }

                    // Close the statement and the connection
                    $stmt->close();
                    $conn->close();
                ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End South Campus -->
    </div>
</div>
<!-- End of Container -->

    </div>
    <!-- End Main content -->



</body>
</html>
