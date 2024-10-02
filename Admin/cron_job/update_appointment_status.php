<?php
// Database connection
require_once '../../db conn.php'; // Adjust path as needed

// Set the timezone (adjust to the correct timezone, e.g., 'Asia/Kuala_Lumpur')
$timezone = new DateTimeZone('Asia/Kuala_Lumpur');

// Get the current date and time with the correct timezone
$currentDateTime = new DateTime('now', $timezone); // Current date and time with timezone
$currentDate = $currentDateTime->format('Y-m-d'); // Current date in 'Y-m-d' format
$currentTime = $currentDateTime->format('h:iA'); // Current time in 'h:iA' format

// Query to select all upcoming appointments for today or earlier
$query = "SELECT * FROM appointment WHERE status = 'upcoming' AND date <= ?";

// Prepare the statement
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $currentDate);
$stmt->execute();
$result = $stmt->get_result();

// Loop through each appointment to check if its time has passed
while ($appointment = $result->fetch_assoc()) {
    $appointmentId = $appointment['appointment_id'];
    $appointmentDate = $appointment['date'];
    $timeslot = $appointment['timeslot'];

    // Extract the start time from the timeslot (e.g., '09:00AM' from '09:00AM - 09:30AM')
    $times = explode(' - ', $timeslot);
    $startTime = $times[0]; // Start time is the first part of the timeslot

    // Combine the appointment date and start time into a DateTime object with timezone
    $appointmentDateTime = DateTime::createFromFormat('Y-m-d h:ia', "$appointmentDate $startTime", $timezone);

    if ($appointmentDateTime !== false) {
        // Compare the appointment time with the current time
        if ($appointmentDateTime < $currentDateTime) {
            // If the appointment time has passed, update the status to 'done'
            $updateQuery = "UPDATE appointment SET status = 'done' WHERE appointment_id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param('i', $appointmentId);
            $updateStmt->execute();

            if ($updateStmt->affected_rows > 0) {
                echo "Appointment ID $appointmentId status updated to 'done'.\n";
            }
        } else {
            echo "Appointment ID $appointmentId is still upcoming.\n";
        }
    } else {
        echo "Error: Invalid date or timeslot format for appointment ID $appointmentId.\n";
    }
}

// Close the database connection
$stmt->close();
$conn->close();
