<?php
require 'connection.php';

// Collect POST data
$verificationCode = isset($_POST['verificationCode']) ? $_POST['verificationCode'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;

// Validate input
if (empty($verificationCode)) {
    echo "<script>alert('Verification code is required.'); window.location.href = '../verification-form.php?email=" . urlencode($email) . "';</script>";
    exit;
}

// Query to check the verification code and match with the provided email
$sql = "SELECT email FROM account WHERE verification_code = ? AND email = ? AND status = 'pending'";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "<script>alert('Database prepare failed.'); window.location.href = '../verification-form.php?email=" . urlencode($email) . "';</script>";
    $conn->close();
    exit;
}

$stmt->bind_param("ss", $verificationCode, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Invalid verification code'); window.location.href = '../verification-form.php?email=" . urlencode($email) . "';</script>";
    $stmt->close();
    $conn->close();
    exit;
}

// Update the account status to 'verified'
$updateSql = "UPDATE account SET status = 'verified', verification_code = NULL WHERE email = ?";
$updateStmt = $conn->prepare($updateSql);
if (!$updateStmt) {
    echo "<script>alert('Database prepare failed.'); window.location.href = '../verification-form.php?email=" . urlencode($email) . "';</script>";
    $conn->close();
    exit;
}

$updateStmt->bind_param("s", $email);
if ($updateStmt->execute() === TRUE) {
    echo "<script>alert('Account verified successfully.'); window.location.href = '../auth.php';</script>";
} else {
    echo "<script>alert('Error updating account status: " . $updateStmt->error . "'); window.location.href = '../verification-form.php?email=" . urlencode($email) . "';</script>";
}

$updateStmt->close();
$stmt->close();
$conn->close();
?>
