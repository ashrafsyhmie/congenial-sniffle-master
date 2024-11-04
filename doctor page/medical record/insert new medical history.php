<?php
require_once('../../db conn.php');
session_start();
$patient_id = $_SESSION['patient_id'];

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $patient_id) {

    $appointment_id = $_POST['appointment_id'];


    // Get the latest medical_record_id
    $sql = "SELECT MAX(medical_record_id) AS max_id FROM medical_record";
    $MedicalIDResult = $conn->query($sql);
    $max_id = ($MedicalIDResult && $MedicalIDResult->num_rows > 0) ? $MedicalIDResult->fetch_assoc()['max_id'] + 1 : 1;

    //insert new medical record
    $sql = "INSERT INTO medical_record (appointment_id, patient_id, notes) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $appointment_id, $patient_id, $_POST['notes']);
    if (!$stmt->execute()) {
        echo "Failed to insert medical record.<br>";
    }
    $stmt->close();

    // Debugging: Output the POST data for verification
    echo "<pre>", var_dump($_POST), "</pre>";

    // Medication Data Insertion
    if (!empty($_POST['medication_name'])) {
        $medication_names = $_POST['medication_name'];
        $purposes = $_POST['purpose'];
        $dosages = $_POST['dosage'];
        $frequencies = $_POST['frequency'];

        $sql = "INSERT INTO medication (medical_record_id, medication_name, purpose, dosage, frequency) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        foreach ($medication_names as $i => $medication_name) {
            $stmt->bind_param("issss", $max_id, $medication_names[$i], $purposes[$i], $dosages[$i], $frequencies[$i]);
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
    $stmt->bind_param("issss", $max_id, $_POST['temperature'], $_POST['blood_pressure'], $_POST['heart_rate'], $_POST['respiratory_rate']);
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
            $stmt->bind_param("isss", $max_id, $procedure_names[$i], $diagnosis_purposes[$i], $diagnosis_results[$i]);
            if (!$stmt->execute()) {
                echo "Failed to insert diagnosis: $procedure_name<br>";
            }
        }
        $stmt->close();
    }

    //Medical Condition Insertion
    $conditions = [
        'Eye Problem' => $_POST['eye_problem'] ?? 'None',
        'Seizure' => $_POST['seizure'] ?? 'None',
        'Epilepsy' => $_POST['epilepsy'] ?? 'None',
        'Hearing Problem' => $_POST['hearing_problem'] ?? 'None',
        'Diabetes' => $_POST['diabetes'] ?? 'None',
        'Cardiovascular Disease' => $_POST['cardiovascular_disease'] ?? 'None',
        'History of Strokes' => $_POST['history_of_strokes'] ?? 'None',
        'Respiratory Problem' => $_POST['respiratory_problem'] ?? 'None',
        'Kidney Problem' => $_POST['kidney_problem'] ?? 'None',
        'Stomach and Liver Problem' => $_POST['stomach_liver_problem'] ?? 'None',
        'Pancreatic Problems' => $_POST['pancreatic_problems'] ?? 'None',
        'Anxiety and Depression' => $_POST['anxiety_depression'] ?? 'None',
        'Other Mental Health Issue' => $_POST['mental_health_issue'] ?? 'None',
        'Sleep Disorder' => $_POST['sleep_disorder'] ?? 'None',
        'Neck or Back Problem' => $_POST['neck_back_problem'] ?? 'None'
    ];

    // Prepare the SQL statement for inserting conditions
    $sql = "INSERT INTO medical_conditions (medical_record_id, condition_name, condition_status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Check for statement preparation success
    if ($stmt) {
        foreach ($conditions as $condition_name => $condition_status) {
            // Skip if the condition status is 'None'
            if ($condition_status === 'None') {
                continue;
            }

            $stmt->bind_param("iss", $max_id, $condition_name, $condition_status);

            if (!$stmt->execute()) {
                echo "Failed to insert condition: $condition_name. Error: " . $stmt->error . "<br>";
            } else {
                echo "Inserted condition: $condition_name with status: $condition_status<br>";
            }
        }
        $stmt->close();
    } else {
        echo "Failed to prepare statement for medical conditions. Error: " . $conn->error . "<br>";
    }


    echo "All records processed.";
} else {
    echo "Invalid request or session data missing.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="../manage patient/view all patient.php">
        <button>Press here</button>
    </a>
</body>

</html>