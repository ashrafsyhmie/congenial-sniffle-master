<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
require_once '../../db conn.php';

// Desired date
$preferredDate = '2024-09-27'; // Use your desired date

// Query to fetch all appointments on the preferred date
$query = "SELECT appointment.*, patient.email, patient.patient_name , doctor.doctor_name
          FROM appointment 
          JOIN patient ON appointment.patient_id = patient.patient_id 
          JOIN doctor ON appointment.doctor_id = doctor.doctor_id
          WHERE date = '$preferredDate'";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    $mail = new PHPMailer(true);

    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.hostinger.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'medassist.admin@medassist.icu';
    $mail->Password   = '#2!U7Iw7@';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    // Set the email from address
    $mail->setFrom('medassist.admin@medassist.icu', 'MedAssist');

    // Prepare the email content
    while ($appointment = $result->fetch_assoc()) {
        $patientEmail = $appointment['email'];
        $patientName = $appointment['patient_name'];
        $doctorName = $appointment['doctor_name'];
        $appointmentDate = $appointment['date'];
        $timeslot = $appointment['timeslot']; // Include this if you want to mention the time in the email

        // Add recipient for each patient
        $mail->addAddress($patientEmail);

        // Set email format to HTML
        $mail->isHTML(true);
        $mail->Subject = "Upcoming Appointment Reminder with Doctor: $doctorName";
        $mail->Body = 'Dear ' . $patientName . ',<br>
                        We hope this message finds you well.<br>
                        This is a friendly reminder about your upcoming appointment on <b>' . $appointmentDate . '</b> at <b>' . $timeslot . '</b> with <b>' . $doctorName . '</b>.<br>
                        Please make sure to arrive 10-15 minutes early for any necessary preparations.<br>
                        If you need to reschedule or have any questions, feel free to reply to this email or call us.<br><br>
                        We look forward to seeing you!<br><br>
                        Best regards,<br>
                        MedAssist';

        try {
            // Send the email
            $mail->send();
            echo 'Message has been sent to ' . $patientEmail . '<br>';
        } catch (Exception $e) {
            echo "Message could not be sent to $patientEmail. Mailer Error: {$mail->ErrorInfo}<br>";
        }

        // Clear all addresses for the next iteration
        $mail->clearAddresses();
    }
} else {
    echo "No appointments found for $preferredDate.";
}

// Close the database connection
$conn->close();
