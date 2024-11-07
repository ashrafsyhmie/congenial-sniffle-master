<?php
// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../../vendor/autoload.php';

// Start session for error handling
session_start();

// Include database connection file
require '../../db conn.php'; // Make sure to include your database connection here

// Function to check doctor credentials
function checkdoctorCredentials($conn)
{
    if (!isset($_SESSION['doctor_id'])) {
        echo "doctor ID not set in session.";
        return null; // Return null if no doctor_id is set
    }

    $doctor_id = $_SESSION['doctor_id'];
    $sql = "SELECT * FROM doctor WHERE doctor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are results
    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Return the entire row for later use
    } else {
        echo "No doctor data found.";
        return null; // Return null if no data found
    }
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $recipients_email = array_map('trim', explode(',', $_POST['recipients_email']));
    $recipients_email = array_filter($recipients_email, function ($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    });
    $subject = htmlspecialchars($_POST['subject']);
    $body = htmlspecialchars($_POST['body']);
    $enteredPassword = $_POST['password']; // Get the password entered by the doctor

    // Fetch doctor credentials
    $doctorData = checkdoctorCredentials($conn);

    if ($doctorData) {
        $real_password = $doctorData['password']; // Fetch the hashed password from the database
        $email = htmlspecialchars($doctorData['email']); // Fetch the email

        // Verify the entered password against the hashed password
        if (password_verify($enteredPassword, $real_password)) {
            // Initialize PHPMailer
            $mail = new PHPMailer(true);

            try {
                // SMTP settings for Hostinger
                $mail->isSMTP();
                $mail->Host       = 'smtp.hostinger.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = $email; // Use doctor email
                $mail->Password   = $enteredPassword; // Use the newly entered password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Encryption type
                $mail->Port       = 465;

                // Set email sender
                $mail->setFrom($email, 'MedAssist');

                // Add multiple recipients
                foreach ($recipients_email as $recipient) {
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
                // Log the error for debugging (optional)
                error_log("Email could not be sent. Error: {$mail->ErrorInfo}");

                // Redirect back with error message
                $_SESSION['error'] = "Email could not be sent. Error: {$mail->ErrorInfo}";
                header('Location: ./send email patient.php');
                exit();
            }
        } else {
            $_SESSION['error'] = "Invalid password. Please try again.";
            echo "Invalid password. Please try again.";
            // Optionally redirect back after showing the error
            header('Location: ./send email patient.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Could not fetch doctor credentials.";
        echo "Could not fetch doctor credentials.";
        // Optionally redirect back after showing the error
        header('Location: ./send email patient.php');
        exit();
    }
}
