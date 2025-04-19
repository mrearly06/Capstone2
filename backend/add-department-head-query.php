<?php
include "connection.php";

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get the submitted form data
$userID = isset($_POST['userID']) ? $conn->real_escape_string($_POST['userID']) : '';
$departmentID = isset($_POST['departmentID']) ? $conn->real_escape_string($_POST['departmentID']) : '';

// Check if both userID and departmentID are provided
if (!empty($userID) && !empty($departmentID)) {
    // Log the values
    file_put_contents('debug.log', "userID: $userID, departmentID: $departmentID\n", FILE_APPEND);

    // Check if userID exists in the users table
    $userCheckQuery = "SELECT COUNT(*) as count FROM user WHERE userID = '$userID'";
    $userCheckResult = $conn->query($userCheckQuery);
    $userCount = $userCheckResult->fetch_assoc()['count'];

    // Check if departmentID exists in the departments table
    $departmentCheckQuery = "SELECT COUNT(*) as count FROM department WHERE departmentID = '$departmentID'";
    $departmentCheckResult = $conn->query($departmentCheckQuery);
    $departmentCount = $departmentCheckResult->fetch_assoc()['count'];

    // Check if the department already has a department head
    $departmentHeadCheckQuery = "SELECT COUNT(*) as count FROM department_head WHERE departmentID = '$departmentID'";
    $departmentHeadCheckResult = $conn->query($departmentHeadCheckQuery);
    $departmentHeadCount = $departmentHeadCheckResult->fetch_assoc()['count'];

    // Proceed with the insertion if both IDs exist and no department head exists for the department
    if ($userCount > 0 && $departmentCount > 0) {
        if ($departmentHeadCount == 0) {
            // Prepare the SQL statement to insert into department_head table
            $sql = "INSERT INTO department_head (userID, departmentID) VALUES ('$userID', '$departmentID')";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(['success' => true, 'message' => 'Department Head added successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'This department already has a department head.']);
        }
    } else {
        if ($userCount == 0 && $departmentCount == 0) {
            echo json_encode(['success' => false, 'message' => 'Both userID and departmentID are invalid.']);
        } elseif ($userCount == 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid userID provided.']);
        } elseif ($departmentCount == 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid departmentID provided.']);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'userID and departmentID are required.']);
}

// Close the connection
$conn->close();
?>
