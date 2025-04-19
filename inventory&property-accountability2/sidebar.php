
<?php
include "backend/connection.php";

// Assuming you already have a database connection in a variable $conn
function isDepartmentHead($userID, $conn) {
    // Prepare the SQL statement
    $sql = "SELECT * FROM department_head WHERE userID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID); // Bind the userID parameter
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if the query returned any rows
    if ($result->num_rows > 0) {
        return true; // User is a department head
    } else {
        return false; // User is not a department head
    }
}

// Example: Retrieve the logged-in user's userID (assuming it's stored in session)
$userID = $_SESSION['userID'];

// Check if the user is a department head
if (isDepartmentHead($userID, $conn)) {
    $_SESSION['role'] = 'department_head'; // Store the role in session
} else {
    $_SESSION['role'] = 'employee'; // Default role for non-department heads
}
?>

<!-- Triple horizontal bar (sidebar toggle button) -->


<!-- Sidebar -->
<div class="sidebar" style="z-index:99;">

<button id="sidebarToggle" class="btn btn-transparent" style="position: absolute; top: 0px; right: 3px; z-index: 100;color:#fff;">
    <i class="fas fa-bars"></i>
</button>

    <div class="d-flex title-logo p-3">
        <a class="navbar-brand ps-3" href="#">
            <img src="image/dwcl-logo.png" alt="Logo" width="70" height="70" class="">
        </a>
        <h4 class="text-center p-3">DWCL</h4>
    </div>
    
    <ul class="nav flex-column">
        <li class="nav-item p-1">
            <a class="nav-link active" href="index.php">
                <i class="fas fa-home"></i> Home
            </a>
        </li>

        <!-- Inventory Collapsible -->
        <li class="nav-item p-1">
            <a class="nav-link" href="#inventoryCollapse" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="inventoryCollapse">
                <i class="fas fa-box"></i> Inventory 
                <i class="fas fa-chevron-down ms-auto" style="font-size:12px;"></i>
            </a>
            <ul class="collapse list-unstyled ms-4" id="inventoryCollapse">
             <!--     <li><a class="nav-link" href="item.php">Items/Equipments</a></li>    -->
                <li><a class="nav-link" href="item-list.php">Inventory List</a></li>
            </ul>
        </li>

        <!-- Users Collapsible -->
        <li class="nav-item p-1">
            <a class="nav-link" href="#usersCollapse" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="usersCollapse">
                <i class="fas fa-users"></i> Users
                <i class="fas fa-chevron-down ms-auto" style="font-size:12px;"></i>
            </a>
            <ul class="collapse list-unstyled ms-4" id="usersCollapse">
                <li><a class="nav-link" href="employee.php">Employee</a></li>
                <li><a class="nav-link" href="issuance-list.php">Issuance List</a></li>
            </ul>
        </li>

     
        <li class="nav-item p-1">
            <a class="nav-link" href="#requestCollapse" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="requestCollapse">
                <i class="fas fa-envelope"></i> Requests 
                <i class="fas fa-chevron-down ms-auto" style="font-size:12px;"></i>
            </a>
            <ul class="collapse list-unstyled ms-4" id="requestCollapse">
                <li><a class="nav-link" href="my-request-list.php">My Requests</a></li>
               <!-- Requests Collapsible - Visible only if the user is a department head -->
        <?php if ($_SESSION['role'] === 'department_head'): ?>
                <li><a class="nav-link" href="incoming-asset-request.php">Incoming Asset Request</a></li>
        <?php endif; ?>
                <li><a class="nav-link" href="requisition-form.php">Requisition Form</a></li>
            </ul>
        </li>
   

        <!-- Settings Dropdown -->
        <li class="nav-item p-1">
            <a class="nav-link" href="#settingsCollapse" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="settingsCollapse">
                <i class="fas fa-cog"></i> Settings
                <i class="fas fa-chevron-down ms-auto" style="font-size:12px;"></i>
            </a>
            <ul class="collapse list-unstyled ms-4" id="settingsCollapse">
                <li><a class="nav-link" href="#">Account Settings</a></li>
                <li><a class="nav-link" href="#">Privacy Settings</a></li>
                <li><a class="nav-link" href="#">Security</a></li>
                <li><a class="nav-link" href="#">Activity Logs</a></li>
            </ul>
        </li>

        <!-- Reports Nav Item --> 
        <li class="nav-item p-1">
            <a class="nav-link" href="reports.php">
                <i class="fas fa-file-alt"></i> Reports
            </a>
        </li>
    </ul>
</div>
<!-- End Sidebar -->


