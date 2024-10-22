<?php
require_once("../db conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the appointment ID from the form
    $appointment_id = $_POST['appointment_id'];



    // Cancel the appointment in the database
    $sql = "UPDATE appointment SET status = 'cancelled' WHERE appointment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $appointment_id);
    if ($stmt->execute()) {
        // Success message or redirect to confirmation page
        header("Location: ./all appointment.php?message=Appointment ID " . $appointment_id . " cancelled successfully&message_type=success");
        exit;
    } else {
        // Handle errors here
        echo "Error cancelling appointment";
    }
}
