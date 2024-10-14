<?php
// Database configuration
require_once('../../db conn.php');
session_start();
$patient_id = $_SESSION['patient_id'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // SQL query to get max medical_record_id
    $sql = "SELECT MAX(medical_record_id) AS max_id FROM medical_record";
    $MedicalIDResult = $conn->query($sql);

    // Check if result is not empty and fetch the max value
    if ($MedicalIDResult->num_rows > 0) {
        $row = $MedicalIDResult->fetch_assoc();
        $max_id = $row['max_id'];
    } else {
        echo "No records found";
    }

    // Debugging: Output the POST data
    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";

    // Check if 'medication' is set in the POST array
    if (isset($_POST['medication_name']) && !empty($_POST['medication_name'])) {
        // Get the medication data from the POST request
        $medication_names = $_POST['medication_name'];
        $purposes = $_POST['purpose'];  // Corrected: `$purposes[]` should be `$purposes`
        $dosages = $_POST['dosage'];
        $frequencies = $_POST['frequency'];

        // Loop through the medication data and insert each row into the database
        $all_success = true; // Flag to check if all insertions were successful

        for ($i = 0; $i < count($medication_names); $i++) {
            $medication_name = $medication_names[$i];
            $purpose = $purposes[$i];
            $dosage = $dosages[$i];
            $frequency = $frequencies[$i];

            echo $i;
            echo "Medical Record ID: $max_id,<br> Medication: $medication_name, <br>Purpose: $purpose,<br> Dosage: $dosage, <br>Frequency: $frequency<br>";

            $sql = "INSERT INTO medication (medical_record_id,medication_name, purpose, dosage, frequency) VALUES (?,?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("sssss", $max_id, $medication_name, $purpose, $dosage, $frequency);

                if ($stmt->execute()) {
                    echo "Insertion successful for medication: $medication_name<br>";
                } else {
                    echo "Failed to insert medication: $medication_name. Error: " . $stmt->error . "<br>";
                    $all_success = false; // Set the flag to false if an error occurs
                }

                $stmt->close();
            } else {
                echo "Failed to prepare statement for medication: $medication_name. Error: " . $conn->error . "<br>"; // Changed from `$mysqli->error` to `$conn->error`
                $all_success = false;
            }
        }

        if ($all_success) {
            echo "All medications inserted successfully!";
        } else {
            echo "One or more medications failed to insert.";
        }
    } else {
        echo "No medication data found. Please submit the form again.";
    }

    // Check if 'medication' is set in the POST array




    // // Check if Patient Lifestyle is set in the POST array
    $smoking = $_POST['smoking'];
    $alcohol = $_POST['alcohol'];
    $allergies = $_POST['allergies'];

    $sql = "INSERT INTO patient_lifestyle (patient_id, smoking_history, alcohol_consumption, allergies_history) VALUES (?,?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssss",  $patient_id, $smoking, $alcohol, $allergies);

        if ($stmt->execute()) {
            echo "Insertion successful for patient lifestyle: $patient_id<br>";
        } else {
            echo "Failed to insert patient lifestyle: $patient_id. Error: " . $stmt->error . "<br>";
            $all_success = false; // Set the flag to false if an error occurs
        }

        $stmt->close();
    } else {
        echo "Failed to prepare statement for patient lifestyle: $conn->error<br>"; // Changed from `$mysqli->error` to `$conn->error`
        $all_success = false;
    }

    // Check if Patient Exam is set in the POST array
    $temperature = $_POST['temperature'];
    $blood_pressure = $_POST['blood_pressure'];
    $heart_rate = $_POST['heart_rate'];
    $respiratory_rate = $_POST['respiratory_rate'];

    $sql = "INSERT INTO physical_exam (medical_record_id, temperature, blood_pressure, heart_rate,respiratory_rate) VALUES (?,?,?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssss",  $max_id, $temperature, $blood_pressure, $heart_rate, $respiratory_rate);

        if ($stmt->execute()) {
            echo "Insertion successful for physical exam<br>";
        } else {
            echo "Failed to insert physical exam: Error: " . $stmt->error . "<br>";
            $all_success = false; // Set the flag to false if an error occurs
        }

        $stmt->close();
    } else {
        echo "Failed to prepare statement for physical exam: $conn->error<br>"; // Changed from `$mysqli->error` to `$conn->error`
        $all_success = false;
    }



    $procedure_names = $_POST['procedure_name'];
    $diagnosis_purposes = $_POST['diagnosis_purpose'];
    $diagnosis_results = $_POST['diagnosis_result'];


    for ($i = 0; $i < count($procedure_names); $i++) {
        $procedure_name = $procedure_names[$i];
        $diagnosis_purpose = $diagnosis_purposes[$i];
        $diagnosis_result = $diagnosis_results[$i];

        echo $i;
        echo "Medical Record ID: $max_id,<br> Procedure Name: $procedure_name, <br>Purpose: $diagnosis_purpose,<br> Result: $diagnosis_result, <br>";

        $sql = "INSERT INTO diagnosis (medical_record_id,procedure_name, purpose, result) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssss", $max_id, $procedure_name, $diagnosis_purpose, $diagnosis_result);

            if ($stmt->execute()) {
                echo "Insertion successful for diagnosis: $procedure_name <br>";
            } else {
                echo "Failed to insert diagnosis: $procedure_name . Error: " . $stmt->error . "<br>";
                $all_success = false; // Set the flag to false if an error occurs
            }

            $stmt->close();
        } else {
            echo "Failed to prepare statement for diagnosis: $procedure_name . Error: " . $mysqli->error . "<br>";
            $all_success = false;
        }
    }
} else {
    echo "Invalid request method.";
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
    <a href="http://localhost/congenial-sniffle-master/patient%20page/medical%20history%20handler/medical%20history%20view.php">
        <button>press here</button>
    </a>
</body>

</html>