<?php
require_once('../../db conn.php');
session_start();
$patient_id = $_SESSION['patient_id'];

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $patient_id) {

    $appointment_id = $_POST['appointment_id'];


    // Get the latest medical_record_id
    // $sql = "SELECT MAX(medical_record_id) AS max_id FROM medical_record";
    // $MedicalIDResult = $conn->query($sql);
    // $max_id = ($MedicalIDResult && $MedicalIDResult->num_rows > 0) ? $MedicalIDResult->fetch_assoc()['max_id'] + 1 : 1;

    //insert new medical record
    $sql = "INSERT INTO medical_record (appointment_id, patient_id, notes) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $appointment_id, $patient_id, $_POST['notes']);
    if ($stmt->execute()) {
        $medical_record_id = $conn->insert_id;
    } else {
        echo "Failed to insert medical record.<br>";
        exit;
    }
    $stmt->close();



    // Medication Data Insertion
    if (!empty($_POST['medication_name'])) {
        $medication_names = $_POST['medication_name'];
        $purposes = $_POST['purpose'];
        $dosages = $_POST['dosage'];
        $frequencies = $_POST['frequency'];

        $sql = "INSERT INTO medication (medical_record_id, medication_name, purpose, dosage, frequency) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        foreach ($medication_names as $i => $medication_name) {
            $stmt->bind_param("issss", $medical_record_id, $medication_names[$i], $purposes[$i], $dosages[$i], $frequencies[$i]);
            if (!$stmt->execute()) {
                echo "Failed to insert medication: $medication_name<br>";
            }
        }
        $stmt->close();
    }

    // Patient Lifestyle Insertion
    $allergies_history = $_POST['allergies'] === "yes" ?  ($_POST['allergies_specify'] ?? '') : "No";

    $sql = "INSERT INTO patient_lifestyle (patient_id, smoking_history, alcohol_consumption, allergies_history) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $patient_id, $_POST['smoking'], $_POST['alcohol'], $allergies_history);

    if (!$stmt->execute()) {
        echo "Failed to insert patient lifestyle.<br>";
    }
    $stmt->close();


    // Physical Exam Insertion
    $sql = "INSERT INTO physical_exam (medical_record_id, temperature, blood_pressure, heart_rate, respiratory_rate, exam_date) VALUES (?, ?, ?, ?, ?, CURDATE())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $medical_record_id, $_POST['temperature'], $_POST['blood_pressure'], $_POST['heart_rate'], $_POST['respiratory_rate']);
    if (!$stmt->execute()) {
        echo "Failed to insert physical exam.<br>";
    }
    $stmt->close();


    // Diagnosis Data Insertion
    if (!empty($_POST['procedure_name'])) {
        $procedure_names = $_POST['procedure_name'];
        $diagnosis_purposes = $_POST['diagnosis_purpose'];
        $diagnosis_results = $_POST['diagnosis_result'];

        $sql = "INSERT INTO diagnosis (medical_record_id, procedure_name, purpose, result) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        foreach ($procedure_names as $i => $procedure_name) {
            $stmt->bind_param("isss", $medical_record_id, $procedure_names[$i], $diagnosis_purposes[$i], $diagnosis_results[$i]);
            if (!$stmt->execute()) {
                echo "Failed to insert diagnosis: $procedure_name<br>";
            }
        }
        $stmt->close();
    }

    //Medical Condition Insertion
    if (!empty($_POST['medical_condition'])) {
        $conditions = array_combine($_POST['medical_condition'], $_POST['medical_condition_status']);
    } else {
        $conditions = [];
        echo "no medical condition";
    }

    $sql = "INSERT INTO medical_conditions (medical_record_id, condition_name , condition_status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    foreach ($conditions as $medical_condition => $medical_condition_status) {
        // Skip if the condition status is 'None'
        if ($medical_condition_status === 'None') {
            continue;
        }

        $stmt->bind_param("iss", $medical_record_id, $medical_condition, $medical_condition_status);

        if (!$stmt->execute()) {
            echo "Failed to insert condition: $medical_condition. Error: " . $stmt->error . "<br>";
        }
    }
    $stmt->close();

    header("Location: ../patient profile.php?id=$patient_id&message=Medical Record ID $medical_record_id Inserted Successfully&message_type=success");
} else {
    echo "Invalid request or session data missing.";
}
