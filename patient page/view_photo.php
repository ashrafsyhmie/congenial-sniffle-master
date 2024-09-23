<?php

require_once('../db conn.php'); // Ensure this file contains a valid connection to your database

$patient_id = 1;

$sql = "SELECT patient_photo FROM patient ";
$result = mysqli_query($conn, $sql);

// Function to fetch all information from the patient table
function fetchAllPatientInfo($conn)
{

    global $patient_id;
    $sql = "SELECT * FROM patient WHERE patient_id = $patient_id";
    $result = mysqli_query($conn, $sql);

    // Initialize an array to store the results
    $patientInfo = array();

    // Fetch each row and store it in the array
    while ($row = mysqli_fetch_assoc($result)) {
        $patientInfo[] = $row;
    }

    // Return the array containing all patient information
    return $patientInfo;
}



// Fetch all patient information
$allPatientInfo = fetchAllPatientInfo($conn);



// Output the fetched information
foreach ($allPatientInfo as $patient) {
    echo '<td><img src="data:image/jpeg;base64,' . base64_encode($patient['patient_photo']) . '" alt="patient photo" class="patient-photo"></td>';
}
