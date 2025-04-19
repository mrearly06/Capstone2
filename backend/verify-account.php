<?php
require 'connection.php';

// Set the timezone for consistency
date_default_timezone_set('Asia/Manila');

// Collect POST data
$verificationCode = isset($_POST['verificationCode']) ? trim($_POST['verificationCode']) : null;
$email = isset($_POST['email']) ? trim($_POST['email']) : null;

// Validate input
if (empty($verificationCode) || empty($email)) {
    echo "<script>alert('Email and verification code are required.'); window.location.href = '../verification-form.php?email=" . urlencode($email) . "';</script>";
    exit;
}

// Log input for debugging
error_log("Input Email: $email");
error_log("Input Verification Code: $verificationCode");

// Query to fetch account details
$sql = "SELECT email, verification_code, verification_code_expires FROM account WHERE email = ? AND status = 'pending'";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    error_log("Database prepare failed: " . $conn->error);
    echo "<script>alert('Database prepare failed. Please try again later.'); window.location.href = '../verification-form.php?email=" . urlencode($email) . "';</script>";
    exit;
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if the account exists and is pending
if ($result->num_rows === 0) {
    error_log("No matching account found for email: $email with status 'pending'.");
    echo "<script>alert('Invalid email or account not found.'); window.location.href = '../verification-form.php?email=" . urlencode($email) . "';</script>";
    $stmt->close();
    exit;
}

$account = $result->fetch_assoc();
$expirationTime = strtotime($account['verification_code_expires']);

// Log database values for debugging
error_log("DB Verification Code: " . $account['verification_code']);
error_log("DB Expiration Time: " . $account['verification_code_expires']);

// Check if the verification code has expired
if (time() > $expirationTime) {
    error_log("Verification code expired for email: $email");
    echo "<script>alert('Verification code has expired. Please request a new code.'); window.location.href = '../verification-form.php?email=" . urlencode($email) . "';</script>";
    $stmt->close();
    exit;
}

// Check if the verification code matches
if (trim($account['verification_code']) !== $verificationCode) {
    error_log("Verification code mismatch for email: $email");
    echo "<script>alert('Invalid verification code.'); window.location.href = '../verification-form.php?email=" . urlencode($email) . "';</script>";
    $stmt->close();
    exit;
}

// Update account status to 'verified'
$updateSql = "UPDATE account SET status = 'verified', verification_code = NULL, verification_code_expires = NULL WHERE email = ?";
$updateStmt = $conn->prepare($updateSql);

if (!$updateStmt) {
    error_log("Database prepare failed during update: " . $conn->error);
    echo "<script>alert('Database prepare failed during account update. Please try again later.'); window.location.href = '../verification-form.php?email=" . urlencode($email) . "';</script>";
    $stmt->close();
    exit;
}

$updateStmt->bind_param("s", $email);
if (!$updateStmt->execute()) {
    error_log("Error executing update query: " . $updateStmt->error);
    echo "<script>alert('Error updating account status. Please try again later.'); window.location.href = '../verification-form.php?email=" . urlencode($email) . "';</script>";
    $stmt->close();
    exit;
}

// Post-update validation
$checkSql = "SELECT status FROM account WHERE email = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("s", $email);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    $updatedAccount = $checkResult->fetch_assoc();
    if ($updatedAccount['status'] === 'verified') {
        error_log("Account successfully verified for email: $email");
        echo "<script>alert('Account verified successfully.'); window.location.href = '../auth.php';</script>";
    } else {
        error_log("Post-update status mismatch for email: $email. Expected: 'verified', Found: " . $updatedAccount['status']);
        echo "<script>alert('Account status update failed. Please try again.'); window.location.href = '../verification-form.php?email=" . urlencode($email) . "';</script>";
    }
} else {
    error_log("Post-update check failed: No account found for email: $email");
    echo "<script>alert('Account verification failed. Please try again later.'); window.location.href = '../verification-form.php?email=" . urlencode($email) . "';</script>";
}

// Close all statements and connections
$checkStmt->close();
$updateStmt->close();
$stmt->close();
$conn->close();
?>
