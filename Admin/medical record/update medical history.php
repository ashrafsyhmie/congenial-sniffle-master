<?php
// Database configuration
require_once('../../db conn.php');
session_start();
$admin_id = $_SESSION['admin_id'];



// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'];
    $medical_record_id = $_POST['medical_record_id'];
    // SQL query to get max medical_record_id
    // $sql = "SELECT MAX(medical_record_id) AS max_id FROM medical_record";
    // $MedicalIDResult = $conn->query($sql);

    // // Check if result is not empty and fetch the max value
    // if ($MedicalIDResult->num_rows > 0) {
    //     $row = $MedicalIDResult->fetch_assoc();
    //     $max_id = $row['max_id'];
    // } else {
    //     echo "No records found";
    //     exit();
    // }

    // Debugging: Output the POST data (remove in production)
    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";

    // Flag to track overall success
    $all_success = true;

    // Medication data handling
    // Medication data handling
    if (isset($_POST['medication_name']) && !empty($_POST['medication_name'])) {
        $medication_names = $_POST['medication_name'];
        $purposes = $_POST['purpose'];
        $dosages = $_POST['dosage'];
        $frequencies = $_POST['frequency'];

        // Loop through medications and update or insert each one
        for ($i = 0; $i < count($medication_names); $i++) {
            $medication_name = $medication_names[$i];
            $purpose = $purposes[$i];
            $dosage = $dosages[$i];
            $frequency = $frequencies[$i];

            // Check if the medication already exists for this medical_record_id
            $check_sql = "SELECT * FROM medication WHERE medical_record_id = ? AND medication_name = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("ss", $medical_record_id, $medication_name);
            $check_stmt->execute();
            $result = $check_stmt->get_result();

            if ($result->num_rows > 0) {
                // Medication exists, so update it
                $update_sql = "UPDATE medication SET purpose = ?, dosage = ?, frequency = ? WHERE medical_record_id = ? AND medication_name = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("sssss", $purpose, $dosage, $frequency, $medical_record_id, $medication_name);

                if ($update_stmt->execute()) {
                    echo "Updated medication: $medication_name<br>";
                } else {
                    echo "Failed to update medication: $medication_name. Error: " . $update_stmt->error . "<br>";
                    $all_success = false;
                }
                $update_stmt->close();
            } else {
                // Medication does not exist, so insert it
                $insert_sql = "INSERT INTO medication (medical_record_id, medication_name, purpose, dosage, frequency) VALUES (?, ?, ?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("issss", $medical_record_id, $medication_name, $purpose, $dosage, $frequency);

                if ($insert_stmt->execute()) {
                    echo "Inserted new medication: $medication_name<br>";
                } else {
                    echo "Failed to insert medication: $medication_name. Error: " . $insert_stmt->error . "<br>";
                    $all_success = false;
                }
                $insert_stmt->close();
            }

            $check_stmt->close();
        }
    } else {
        echo "No medication data found.<br>";
    }


    // Update patient lifestyle
    $patient_id = $_POST['patient_id']; // Ensure patient_id is coming from the form
    $smoking = $_POST['smoking'];
    $alcohol = $_POST['alcohol'];

    // Handle allergies input
    $allergies_input = $_POST['allergies']; // This will come from the allergies text input
    $allergies_choice = $_POST['allergies_choice']; // This will come from the radio buttons

    // Determine what to save based on allergies choice
    if ($allergies_choice === 'no') {
        $allergies = 'No'; // Save 'No' if the radio button is selected
    } else {
        $allergies = !empty($allergies_input) ? $allergies_input : 'No'; // Save the input or 'No' if empty
    }

    $sql = "UPDATE patient_lifestyle SET smoking_history = ?, alcohol_consumption = ?, allergies_history = ? WHERE patient_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssss", $smoking, $alcohol, $allergies, $patient_id);

        if ($stmt->execute()) {
            echo "Patient lifestyle updated successfully!<br>"; // Echo success message
        } else {
            echo "Failed to update patient lifestyle: $patient_id. Error: " . $stmt->error . "<br>";
            $all_success = false;
        }
        $stmt->close();
    } else {
        echo "Failed to prepare statement for patient lifestyle. Error: " . $conn->error . "<br>";
        $all_success = false;
    }



    // Update physical exam
    $temperature = $_POST['temperature'];
    $blood_pressure = $_POST['blood_pressure'];
    $heart_rate = $_POST['heart_rate'];
    $respiratory_rate = $_POST['respiratory_rate'];

    $sql = "UPDATE physical_exam SET temperature = ?, blood_pressure = ?, heart_rate = ?, respiratory_rate = ? WHERE medical_record_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssss", $temperature, $blood_pressure, $heart_rate, $respiratory_rate, $medical_record_id);

        if ($stmt->execute()) {
            echo "Physical exam updated successfully!<br>"; // Echo success message
        } else {
            echo "Failed to update physical exam. Error: " . $stmt->error . "<br>";
            $all_success = false;
        }
        $stmt->close();
    } else {
        echo "Failed to prepare statement for physical exam. Error: " . $conn->error . "<br>";
        $all_success = false;
    }


    // Update diagnosis
    if (isset($_POST['procedure_name'])) {
        $procedure_names = $_POST['procedure_name'];
        $diagnosis_purposes = $_POST['diagnosis_purpose'];
        $diagnosis_results = $_POST['diagnosis_result'];

        // Loop through the submitted diagnosis data
        for ($i = 0; $i < count($procedure_names); $i++) {
            $procedure_name = $procedure_names[$i];
            $diagnosis_purpose = $diagnosis_purposes[$i];
            $diagnosis_result = $diagnosis_results[$i];

            // Check if the diagnosis already exists
            $sql = "SELECT * FROM diagnosis WHERE medical_record_id = ? AND procedure_name = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $medical_record_id, $procedure_name);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Update existing diagnosis
                $sql = "UPDATE diagnosis SET purpose = ?, result = ? WHERE medical_record_id = ? AND procedure_name = ?";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("ssis", $diagnosis_purpose, $diagnosis_result, $medical_record_id, $procedure_name);
                    if ($stmt->execute()) {
                        echo "Diagnosis updated successfully for procedure: $procedure_name!<br>";
                    } else {
                        echo "Failed to update diagnosis: $procedure_name. Error: " . $stmt->error . "<br>";
                    }
                    $stmt->close();
                } else {
                    echo "Failed to prepare update statement for diagnosis: $procedure_name. Error: " . $conn->error . "<br>";
                }
            } else {
                // Insert new diagnosis
                $sql = "INSERT INTO diagnosis (medical_record_id, procedure_name, purpose, result) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("isss", $medical_record_id, $procedure_name, $diagnosis_purpose, $diagnosis_result);
                    if ($stmt->execute()) {
                        echo "New diagnosis inserted successfully for procedure: $procedure_name!<br>";
                    } else {
                        echo "Failed to insert diagnosis: $procedure_name. Error: " . $stmt->error . "<br>";
                    }
                    $stmt->close();
                } else {
                    echo "Failed to prepare insert statement for diagnosis: $procedure_name. Error: " . $conn->error . "<br>";
                }
            }
        }
    }

    // Loop through the conditions to update
    if (isset($_POST['condition'])) {
        foreach ($conditions as $condition_name => $condition_status) {
            // Get the current condition value from the POST data
            $condition_value = $_POST[strtolower(str_replace(' ', '_', $condition_name))] ?? 'None';

            // Check if the condition already exists in the database
            $sql = "SELECT * FROM medical_conditions WHERE medical_record_id = ? AND condition_name = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $medical_record_id, $condition_name);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && mysqli_num_rows($result) > 0) {
                // Update existing record
                $sql = "UPDATE medical_conditions SET condition_status = ? WHERE medical_record_id = ? AND condition_name = ?";
                $stmt_update = $conn->prepare($sql);
                $stmt_update->bind_param("sis", $condition_value, $medical_record_id, $condition_name);
                if (!$stmt_update->execute()) {
                    echo "Failed to update condition: $condition_name. Error: " . $stmt_update->error . "<br>";
                }
                $stmt_update->close();
            } else {

                echo 'There are a few problem with your medical history';
            }
            $stmt->close();
        }
        echo 'All conditions updated successfully!';
    }






    if ($all_success) {
        echo "All records updated successfully!";
    } else {
        echo "One or more updates failed.";
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
    <title>Medical Record Update</title>
</head>

<body>
    <br>
    <a href="http://localhost/congenial-sniffle-master/patient%20page/medical%20history%20handler/medical%20history%20view.php">
        <button>Back</button>
    </a>
</body>

</html>