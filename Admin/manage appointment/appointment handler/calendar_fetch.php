<?php
// Include database connection and any other required files
require_once '../../../db conn.php';
require './timeslots-function.php';
require './calendar.php';

if (isset($_GET['patient_id'])) {
    $patient_id = $_GET['patient_id'];
} else if (isset($_POST['patient_id'])) {
    $patient_id = $_POST['patient_id'];
} else {
    $patient_id = $_SESSION['patient_id'];
}

if (isset($_GET['month']) && isset($_GET['year'])) {
    $month = (int)$_GET['month'];
    $year = (int)$_GET['year'];
} else {
    $dateComponents = getdate();
    $month = $dateComponents['mon'];
    $year = $dateComponents['year'];
}

// Replace $patient_id and $doctor_id with actual IDs from your session or request
build_calendar($month, $year, $patient_id, $conn);
