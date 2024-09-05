<?php
session_start();
$patient_id = $_SESSION['patient_id'];
$patient_name = $_SESSION['patient_name'];

require_once('./db conn.php');

function getPatientData($conn, $patient_id)
{
  $sql = "SELECT * FROM patient WHERE patient_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $patient_id);
  $stmt->execute();
  return $stmt->get_result()->fetch_assoc();
}



$row = getPatientData($conn, $patient_id);

if (!$row) {
  die("Patient not found.");
}

if ($row['patient_id'] != $patient_id) {
    die("Invalid patient ID.");
}

// Save patient ID into URL
$url = "http://example.com/patient_page.php?patient_id=" . $patient_id;
header("Location: $url");
exit;
?>