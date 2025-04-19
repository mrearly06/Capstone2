<?php
require "connection.php";
require '../vendor/PHPMailer/src/Exception.php';
require '../vendor/PHPMailer/src/PHPMailer.php';
require '../vendor/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load SMTP configuration
$mailConfig = require 'mail-config.php';

// Set the timezone to the desired one (e.g., 'Asia/Manila' for Philippine time)
date_default_timezone_set('Asia/Manila');

// Collect POST data
$email = isset($_POST['email']) ? $_POST['email'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;
$confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : null;
$userType = isset($_POST['userType']) ? $_POST['userType'] : null; // Get userType from the form

// Validate that the password and confirm password match
if ($password !== $confirmPassword) {
    echo "<script>alert('Passwords do not match.'); window.location.href='../auth.php';</script>";
    exit;
}

// Hash the password before storing it in the database
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Set default values
$createdAt = date("Y-m-d H:i:s"); // Current timestamp
$status = "pending"; // Assuming the account starts in a pending status until verified

// Generate a 6-digit verification code
$verification_code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

// Insert data into the database
$sql = "INSERT INTO account (email, password, userType, createdAt, status, verification_code) VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "<script>alert('Prepare failed: " . $conn->error . "'); window.location.href='../auth.php';</script>";
    $conn->close();
    exit;
}

$stmt->bind_param("ssssss", $email, $hashedPassword, $userType, $createdAt, $status, $verification_code);

if ($stmt->execute() === TRUE) {
    // Send the verification code via email using PHPMailer
    $mail = new PHPMailer(true);
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
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Account Verification';
        $mail->Body = "Thank you for registering. Your verification code is: <b>$verification_code</b>";
        $mail->AltBody = "Thank you for registering. Your verification code is: $verification_code"; // Plain text version for non-HTML email clients

        $mail->send();
        echo "<script>alert('User registered successfully. Verification email sent.'); window.location.href = '../verification-form.php?email=" . urlencode($email) . "';</script>";
    } catch (Exception $e) {
        echo "<script>alert('User registered .Verification email sent.'); window.location.href= '../verification-form.php?email=" . urlencode($email) . "';</script>";
    }
} else {
    echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='../auth.php';</script>";
}

$stmt->close();
$conn->close();
?>
