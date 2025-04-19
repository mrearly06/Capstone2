<?php
// Start the session to access session variables
session_start();

// Include your database connection script
include 'connection.php';

// Set the timezone to the desired one (e.g., 'Asia/Manila' for Philippine time)
date_default_timezone_set('Asia/Manila');

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the acc_id from the session
    if (!isset($_SESSION['acc_id'])) {
        die(json_encode(['success' => false, 'message' => 'User not logged in.']));
    }
    $acc_id = $_SESSION['acc_id'];

    // Retrieve the userType from the session
    if (!isset($_SESSION['userType'])) {
        die(json_encode(['success' => false, 'message' => 'User type not set.']));
    }
    $userType = $_SESSION['userType'];

    // Retrieve and sanitize the input data
    $firstName = htmlspecialchars($_POST['firstName']);
    $middleName = htmlspecialchars($_POST['middleName']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $address = htmlspecialchars($_POST['address']);
    $birthdate = htmlspecialchars($_POST['birthdate']);
    $phoneNo = htmlspecialchars($_POST['phoneNo']);
    $departmentName = htmlspecialchars($_POST['departmentOffice']);
    $position = htmlspecialchars($_POST['position']);
    $imageBase64 = $_POST['image']; // This is a base64 encoded image string

    // Decode the image and save it as a file if provided
    $imageName = '';
    if (!empty($imageBase64)) {
        $imageData = str_replace('data:image/jpeg;base64,', '', $imageBase64);
        $imageData = base64_decode($imageData);

        if ($imageData === false) {
            die(json_encode(['success' => false, 'message' => 'Base64 decode failed.']));
        }

        $imageName = uniqid('profile_') . '.jpg';
        $imagePath = __DIR__ . '/../uploads/' . $imageName;

        if (!is_dir(dirname($imagePath)) || !is_writable(dirname($imagePath))) {
            die(json_encode(['success' => false, 'message' => 'Uploads directory issue.']));
        }

        if (file_put_contents($imagePath, $imageData) === false) {
            die(json_encode(['success' => false, 'message' => 'Failed to save the image.']));
        }
    }

    // Retrieve the department ID based on the department name
    $stmt = $conn->prepare("SELECT departmentID FROM department WHERE departmentName = ?");
    $stmt->bind_param("s", $departmentName);
    $stmt->execute();
    $stmt->bind_result($departmentID);
    $stmt->fetch();
    $stmt->close();

    if (!$departmentID) {
        die(json_encode(['success' => false, 'message' => 'Department not found.']));
    }

    $createdAt = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO user (acc_id, firstName, middleName, lastName, address, birthdate, phoneNo, department, position, userImage, createdAt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssssss", $acc_id, $firstName, $middleName, $lastName, $address, $birthdate, $phoneNo, $departmentID, $position, $imageName, $createdAt);

    if ($stmt->execute()) {
        // Fetch the user details after profile creation
        $userStmt = $conn->prepare("SELECT userID, firstName, middleName, lastName FROM user WHERE acc_id = ?");
        $userStmt->bind_param("i", $acc_id);
        $userStmt->execute();
        $userResult = $userStmt->get_result();

        if ($userResult->num_rows > 0) {
            $user = $userResult->fetch_assoc();
            $_SESSION['userID'] = $user['userID']; // Set the userID
            $_SESSION['firstName'] = $user['firstName']; // Set the first name
            $_SESSION['middleName'] = $user['middleName']; // Set the middle name
            $_SESSION['lastName'] = $user['lastName']; // Set the last name
        } else {
            $_SESSION['userID'] = null; // Default to null
            $_SESSION['firstName'] = null;
            $_SESSION['middleName'] = null;
            $_SESSION['lastName'] = null;
        }
        $userStmt->close();

        $_SESSION['profile_created'] = true; // Indicate profile creation
        $_SESSION['profileSubmitted'] = true;

        if ($userType === 'admin') {
            echo "<script>alert('User Profile Added Successfully.'); window.location.href='../dashboard.php';</script>";
        } else {
            echo "<script>alert('User Profile Added Successfully.'); window.location.href='../index.php';</script>";
        }
        exit();
    } else {
        die(json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]));
    }

    $stmt->close();
    $conn->close();
} else {
    die(json_encode(['success' => false, 'message' => 'Invalid request method']));
}
?>
