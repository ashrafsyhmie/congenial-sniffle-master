<?php
session_start();
require_once("../../db conn.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment_id = $_POST['appointment_id'];
    $new_date = $_POST['new_date'];
    $new_timeslot = $_POST['new_timeslot'];

    // Update the appointment in the database
    $sql = "UPDATE appointment SET date = ?, timeslot = ? WHERE appointment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $new_date, $new_timeslot, $appointment_id);

    if ($stmt->execute()) {
        // Appointment rescheduled successfully
        header("Location: all appointment.php?status=success");
    } else {
        // Error handling
        header("Location: all appointment.php?status=error");
    }
}
