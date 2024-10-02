<?php
// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../../vendor/autoload.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $recipients = explode(',', $_POST['recipients']);  // Split emails by comma
    $subject = $_POST['subject'];
    $body = $_POST['body'];

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP settings for Hostinger
        $mail->isSMTP();
        $mail->Host       = 'smtp.hostinger.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'medassist.admin@medassist.icu';  // Your Hostinger email
        $mail->Password   = '#2!U7Iw7@';                      // Your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;      // Encryption type
        $mail->Port       = 465;

        // Set email sender
        $mail->setFrom('medassist.admin@medassist.icu', 'MedAssist');

        // Add multiple recipients
        foreach ($recipients as $recipient) {
            $mail->addAddress(trim($recipient));  // Trim to remove any extra spaces
        }

        // Set email subject and body
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body);  // Plain text for non-HTML clients

        // Send the email
        $mail->send();

        // Redirect to the form with a success status
        header('Location: ./email.php?status=sent');
        exit();
    } catch (Exception $e) {
        echo "Email could not be sent. Error: {$mail->ErrorInfo}";
    }
}
