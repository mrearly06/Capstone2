<?php


// Check if the session contains the user ID
if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
    
    // Include database connection
    include "backend/connection.php";  // Adjust the path if necessary

    // Query to get user details
    $sql = "SELECT u.firstName, u.middleName, u.lastName, u.userImage, a.userType 
            FROM user u 
            JOIN account a ON u.acc_id = a.acc_id
            WHERE u.userID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($firstName, $middleName, $lastName, $profile_image, $userType);
        $stmt->fetch();
    } else {
        // Handle case where no user found
        $firstName = $middleName = $lastName = $userType = $profile_image = 'Unknown';
    }

    $stmt->close();
    $conn->close();
} else {
    // Handle case where the session is not set (e.g., user is not logged in)
    $firstName = $middleName = $lastName = $userType = $profile_image = 'Guest';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>


  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
 <!-- Include Bootstrap 5 CSS -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome for Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

  
  <style>
    /* Ensure the profile image fits the navbar height */
    .profile-img {
      height: 40px;
      width: auto; /* Maintain aspect ratio */
      object-fit: cover; /* Ensures image stays covered within the height */
    }

    .navbar {
    height: 60px; /* Adjust the navbar height if needed */
    
    background-color: rgb(2, 64, 151) !important; /* Slightly transparent green */
    box-shadow: 0 0 5px 0 black;
  z-index: 1;
    position:fixed;
    width:100%;
    
}



    .dropdown {
      height: 100%; /* Make sure the dropdown aligns with navbar height */
    }

    .d-flex.align-items-center {
      height: 100%;
    }

    .dropdown-item-user-profile{
      width:280px;
      display:flex;
      flex-direction:column;
      align-items:center;
    }
    .users-name{
      font-size:16px;
    }
    .dropdown-item-logout{
      display:flex;
      
    }
    .fa-sign-out-alt{
      background-color: blue;
    }
    .sidebar{
      z-index:101;
    }

   
 
  </style>

</head>
<body>

<nav class="navbar text-bg-primary  mb-1">
  <div class="container-fluid d-flex justify-content-end">
    
    <div class="dropdown profile-pic">
      <a href="#" class="d-flex align-items-center text-decoration-none" id="dropdownProfile" data-bs-toggle="dropdown" aria-expanded="false">
        <!-- Profile Image dynamically loaded from database -->
        <img src="uploads/<?php echo htmlspecialchars($profile_image); ?>" alt="Profile" class="profile-img rounded-circle" style="height: 40px;">
      </a>
      <ul class="dropdown-menu dropdown-menu-end text-small" aria-labelledby="dropdownProfile" style="z-index:99;">
        <!-- Link to profile.php which displays the user's profile -->
        <li class="dropdown-item-user-profile"><a class="dropdown-item" href="profile.php"></a>
       
      
            <!-- Display Profile Image -->
            <img src="uploads/<?php echo htmlspecialchars($profile_image); ?>" alt="Profile" class="rounded-circle" style="height: 120px; width: 120px;z-index:100;">

            <!-- Display User's Full Name -->
            <h3 class="mt-3 users-name"><?php echo htmlspecialchars($firstName . ' ' . $middleName . ' ' . $lastName); ?></h3>

            <!-- Additional User Information (optional) -->
            <!-- Display User's Role (userType) Below the Name -->
            <p class="user-type"><?php echo htmlspecialchars($userType); ?></p>
      
      </li>
        <hr class="dropdown-divider">
        <li class=""><a class="dropdown-item dropdown-item-logout" href="backend/logout.php">    <i class="fas fa-sign-out-alt me-2" style="background-color:	rgb(220,220,220); padding: 0.3rem; border-radius: 50%;"></i> Logout </a></li>
      </ul>
    </div>
  </div>
</nav>



<!-- Bootstrap JS with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kzZZmPzHnhA03JhLXMKhHQh3fELhWcRsEGhaOGFkMNsVFsBePbZXD8tUWR1GRfRr" crossorigin="anonymous"></script>
<!-- Bootstrap 5 and JavaScript bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<!-- Font Awesome JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>


<script>
    document.getElementById("logoutButton").addEventListener("click", function () {
       localStorage.removeItem("selectedItems"); // If you want to clear only selected items
    });
</script>

</body>
</html>
