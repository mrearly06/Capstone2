<?php
require "connection.php";
require '../vendor/autoload.php'; // Include PHPMailer
require 'mail-config.php'; // Include your mail configuration

// Set the timezone to the desired one (e.g., 'Asia/Manila' for Philippine time)
date_default_timezone_set('Asia/Manila');

// Collect POST data
$email = isset($_POST['email']) ? trim($_POST['email']) : null;
$password = isset($_POST['password']) ? trim($_POST['password']) : null;
$confirmPassword = isset($_POST['confirmPassword']) ? trim($_POST['confirmPassword']) : null;
$userType = isset($_POST['userType']) ? trim($_POST['userType']) : null;

// Validate input fields
if (empty($email)) {
    echo "<script>alert('Email is required.'); window.location.href='../auth.php';</script>";
    exit;
}

if (empty($password) || empty($confirmPassword)) {
    echo "<script>alert('Password and confirm password are required.'); window.location.href='../auth.php';</script>";
    exit;
}

if ($password !== $confirmPassword) {
    echo "<script>alert('Passwords do not match.'); window.location.href='../auth.php';</script>";
    exit;
}

// Hash the password before storing it in the database
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Set default values
$createdAt = date("Y-m-d H:i:s"); // Current timestamp
$status = "pending"; // Account starts in a pending status
$verification_code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT); // Generate a 6-digit verification code
$verification_code_expires = date("Y-m-d H:i:s", strtotime("+2 minutes")); // Set expiration time to 5 minutes from now

// Insert data into the database
$sql = "INSERT INTO account (email, password, userType, createdAt, status, verification_code, verification_code_expires) VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "<script>alert('Prepare failed: " . $conn->error . "'); window.location.href='../auth.php';</script>";
    $conn->close();
    exit;
}

$stmt->bind_param("sssssss", $email, $hashedPassword, $userType, $createdAt, $status, $verification_code, $verification_code_expires);

if ($stmt->execute() === TRUE) {
    // Send the verification code via email using PHPMailer
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
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Account Verification';
        $mail->Body = "Thank you for registering. Your verification code is: <b>$verification_code</b>. This code will expire in 5 minutes.";
        $mail->AltBody = "Thank you for registering. Your verification code is: $verification_code. This code will expire in 5 minutes."; // Plain text version for non-HTML email clients

        $mail->send();
        echo "<script>alert('User registered successfully. Verification email sent.'); window.location.href = '../verification-form.php?email=" . urlencode($email) . "';</script>";
    } catch (Exception $e) {
        echo "<script>alert('User registered successfully. Verification email sent.'); window.location.href = '../verification-form.php?email=" . urlencode($email) . "'</script>";
    }
} else {
    echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='../auth.php';</script>";
}

$stmt->close();
$conn->close();
?>