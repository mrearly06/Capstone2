<?php
// mail_config.php

return [
    'host' => 'smtp.gmail.com',  // SMTP server
    'username' => '07109568@dwc-legazpi.edu',    // SMTP username
    'password' => 'yrruc_09',       // SMTP password
    'port' => 587,                             // SMTP port
    'encryption' => PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS, // Encryption type
    'from_email' => '07109568@dwc-legazpi.edu', // From email address
    'from_name' => 'Pogi'             // From name
];
