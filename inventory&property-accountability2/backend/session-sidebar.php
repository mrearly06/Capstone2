<?php
session_start(); // Start the PHP session

// Include the correct sidebar based on user type
if (isset($_SESSION['userType'])) {
    if ($_SESSION['userType'] === 'admin') {
        include "admin-sidebar.php";
    } elseif ($_SESSION['userType'] === 'supply_manager') {
        include "supply-manager-sidebar.php";
    } else {
        include "sidebar.php";
    }
} else {
    // Fallback in case the userType is not set
    include "sidebar.php";
}
?>
