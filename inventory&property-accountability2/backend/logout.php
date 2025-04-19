<?php
// logout.php
session_start();
session_destroy(); // Destroy all sessions
header("Location: ../auth.php"); // Redirect to login page
exit;
?>
