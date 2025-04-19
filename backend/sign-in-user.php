<?php
// Include your database connection script
include 'connection.php';

// Start the session
session_start();


// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize the input data
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Prepare a SQL statement to fetch the user by email
    $stmt = $conn->prepare("SELECT acc_id, email, password, userType, status FROM account WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $account = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $account['password'])) {
            // Check if the account is active
            if ($account['status'] === 'verified') {
                // Set session variables
                $_SESSION['acc_id'] = $account['acc_id']; // Set the account ID
                $_SESSION['userType'] = $account['userType']; // Store the user_type in the session
                
                // Fetch the user details from the user table
                $userStmt = $conn->prepare("SELECT userID, firstName, middleName, lastName FROM user WHERE acc_id = ?");
                $userStmt->bind_param("i", $account['acc_id']);
                $userStmt->execute();
                $userResult = $userStmt->get_result();

                if ($userResult->num_rows > 0) {
                    $user = $userResult->fetch_assoc();
                    $_SESSION['userID'] = $user['userID']; // Set the userID from the user table
                    $_SESSION['firstName'] = $user['firstName']; // Set the first name
                    $_SESSION['middleName'] = $user['middleName']; // Set the middle name
                    $_SESSION['lastName'] = $user['lastName']; // Set the last name
                } else {
                    $_SESSION['userID'] = null; // Default to null if no userID found
                    $_SESSION['firstName'] = null;
                    $_SESSION['middleName'] = null;
                    $_SESSION['lastName'] = null;
                }

                // Close the user statement
                $userStmt->close();

                // Check if user profile exists
                $profileStmt = $conn->prepare("SELECT acc_id FROM user WHERE acc_id = ?");
                $profileStmt->bind_param("i", $account['acc_id']);
                $profileStmt->execute();
                $profileResult = $profileStmt->get_result();

                // Redirect based on user type and profile existence
                if ($profileResult->num_rows === 0) {
                    // Redirect to user profile creation page
                    header('Location: ../add-user-form.php?userType=' . urlencode($account['userType']));

                } else {
                    // Redirect based on user type
                    if ($account['userType'] === 'admin') {
                        header('Location: ../dashboard.php'); // Admin dashboard
                    } elseif ($account['userType'] === 'supply_manager') {
                        header('Location: ../index.php'); // Supply Manager dashboard
                    } else {
                        header('Location: ../index.php'); // Regular user
                    }
                }

                exit();
            } else {
                echo "<script>
                window.alert('Your account is not yet verified, please verify first.');
                window.location.href = '../verification-form.php?email=" . urlencode($email) . "';
            </script>";
            }
        } else {
            echo "<script>
                window.alert('Invalid password.');
                window.location.href = '../auth.php';
            </script>";
        }
    } else {
        echo "<script>
            window.alert('No account found with that email.');
            window.location.href = '../auth.php';
        </script>";
    }

    // Close the statements and connection
    $stmt->close();
    $profileStmt->close();
    $conn->close();
} else {
    // Return an error if the request method is not POST
    die(json_encode(['success' => false, 'message' => 'Invalid request method']));
}
?>
