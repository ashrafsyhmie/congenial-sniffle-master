<?php
// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../../vendor/autoload.php';

// Start session for error handling
session_start();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $recipients = array_map('trim', explode(',', $_POST['recipients_email']));
    $recipients = array_filter($recipients, function ($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    });
    $subject = htmlspecialchars($_POST['subject']);
    $body = htmlspecialchars($_POST['body']);

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP settings for Hostinger
        $mail->isSMTP();
        $mail->Host       = 'smtp.hostinger.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'medassist.admin@medassist.icu';  // Your Hostinger email
        $mail->Password   = '#2!U7Iw7@';                      // Your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Encryption type
        $mail->Port       = 465;

        // Set email sender
        $mail->setFrom('medassist.admin@medassist.icu', 'MedAssist');

        // Add multiple recipients
        foreach ($recipients as $recipient) {
            $mail->addAddress($recipient);  // Email already sanitized
        }

        // Set email subject and body
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body); // Plain text for non-HTML clients

        // Send the email
        $mail->send();

        // Redirect to the form with a success status
        header('Location: ./send email patient.php?status=sent&id=' . $_POST['patient_id']);
        exit();
    } catch (Exception $e) {
        // Redirect back with error message
        $_SESSION['error'] = "Email could not be sent. Error: {$mail->ErrorInfo}";
        header('Location: ./send email patient.php');
        exit();
    }
}
