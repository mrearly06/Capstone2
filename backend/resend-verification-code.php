<?php
require "connection.php";


// Set the timezone for consistency
date_default_timezone_set('Asia/Manila');

// Centralized expiry interval
$expiryInterval = '+2 minutes';

// Collect and validate POST data
$email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL) : null;

if (!$email) {
    echo "<script>alert('Invalid email address.'); window.location.href='../auth.php';</script>";
    exit;
}

// Check if the account exists
$sql = "SELECT acc_id FROM account WHERE email = ? AND status = 'pending'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Account not found or already verified.'); window.location.href='../auth.php';</script>";
    exit;
}

// Generate a new verification code and update the expiration time
$newVerificationCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
$newExpirationTime = date("Y-m-d H:i:s", strtotime($expiryInterval));

$updateSql = "UPDATE account SET verification_code = ?, verification_code_expires = ? WHERE email = ?";
$updateStmt = $conn->prepare($updateSql);
$updateStmt->bind_param("sss", $newVerificationCode, $newExpirationTime, $email);

if (!$updateStmt->execute()) {
    echo "<script>alert('Failed to update verification code.'); window.location.href='../verification-form.php';</script>";
    exit;
}

// Send the new verification code via email
require '../vendor/autoload.php'; // Include PHPMailer
require 'mail-config.php'; // Include your mail configuration

$mail = new PHPMailer\PHPMailer\PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = $mailConfig['host'];
    $mail->SMTPAuth = true;
    $mail->Username = $mailConfig['username'];
    $mail->Password = $mailConfig['password'];
    $mail->SMTPSecure = $mailConfig['encryption'];
    $mail->Port = $mailConfig['port'];

    // Recipients
    $mail->setFrom($mailConfig['from_email'], $mailConfig['from_name']);
    $mail->addAddress($email); // Add the recipient's email

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Resend Verification Code';
    $mail->Body = "Your new verification code is: <b>$newVerificationCode</b>. This code will expire in 2 minutes.";
    $mail->AltBody = "Your new verification code is: $newVerificationCode. This code will expire in 2 minutes.";

    $mail->send();

    // Redirect with success message
    echo "<script>alert('A new verification code has been sent to your email.'); window.location.href = '../verification-form.php?email=" . urlencode($email) . "';</script>";

    exit;
} catch (Exception $e) {
    error_log("Mailer Error for $email: {$mail->ErrorInfo}");
    echo "<script>alert('Failed to send the verification email. Please try again later.');</script>";
}

// Clean up resources
$stmt->close();
$updateStmt->close();
$conn->close();
?>
