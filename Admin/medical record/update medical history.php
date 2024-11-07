<?php
// Database configuration
require_once('../../db conn.php');
session_start();
$admin_id = $_SESSION['admin_id'];

$messages = []; // Array to hold messages



// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'];
    $medical_record_id = $_POST['medical_record_id'];



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
                    // echo "Updated medication: $medication_name<br>";
                    // $messages[] = "Updated medication: $medication_name";
                } else {
                    echo "Failed to update medication: $medication_name. Error: " . $update_stmt->error . "<br>";
                    $messages[] = "Failed to update medication: $medication_name. Error: " . $update_stmt->error;
                    $all_success = false;
                }
                $update_stmt->close();
            } else {
                // Medication does not exist, so insert it
                $insert_sql = "INSERT INTO medication (medical_record_id, medication_name, purpose, dosage, frequency) VALUES (?, ?, ?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("issss", $medical_record_id, $medication_name, $purpose, $dosage, $frequency);

                if ($insert_stmt->execute()) {
                    // echo "Inserted new medication: $medication_name<br>";
                    // $messages[] = "Insert New medication: $medication_name";
                } else {
                    echo "Failed to insert medication: $medication_name. Error: " . $insert_stmt->error . "<br>";
                    $messages[] = "Failed to insert medication: $medication_name. Error: " . $update_stmt->error;
                    $all_success = false;
                }
                $insert_stmt->close();
            }

            $check_stmt->close();
        }
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
            // echo "Patient lifestyle updated successfully!<br>"; // Echo success message
            // $messages[] = "Patient lifestyle updated successfully!";
        } else {
            echo "Failed to update patient lifestyle: $patient_id. Error: " . $stmt->error . "<br>";
            $messages[] = "Failed to update patient lifestyle: $patient_id. Error: " . $stmt->error;
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
            // echo "Physical exam updated successfully!<br>"; // Echo success message
            // $messages[] = "Physical exam updated successfully!";
        } else {
            echo "Failed to update physical exam. Error: " . $stmt->error . "<br>";
            $messages[] = "Failed to update physical exam. Error: " . $stmt->error;
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
                        // echo "Diagnosis updated successfully for procedure: $procedure_name!<br>";
                        // $messages[] = "Diagnosis updated successfully for procedure: $procedure_name!";
                    } else {
                        echo "Failed to update diagnosis: $procedure_name. Error: " . $stmt->error . "<br>";
                        $messages[] = "Failed to update diagnosis: $procedure_name. Error: " . $stmt->error;
                        $all_success = false;
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
                        // echo "New diagnosis inserted successfully for procedure: $procedure_name!<br>";
                        // $messages[] = "New diagnosis inserted successfully for procedure: $procedure_name!";
                    } else {
                        echo "Failed to insert diagnosis: $procedure_name. Error: " . $stmt->error . "<br>";
                        $messages[] = "Failed to insert diagnosis: $procedure_name. Error: " . $stmt->error;
                        $all_success = false;
                    }
                    $stmt->close();
                } else {
                    echo "Failed to prepare insert statement for diagnosis: $procedure_name. Error: " . $conn->error . "<br>";
                }
            }
        }
    }

    // Loop through the conditions to update


    $conditions = [
        'Eye Problem' => 'None',
        'Seizure' => 'None',
        'Epilepsy' => 'None',
        'Hearing Problem' => 'None',
        'Diabetes' => 'None',
        'Cardiovascular Disease' => 'None',
        'History of Strokes' => 'None',
        'Respiratory Problem' => 'None',
        'Kidney Problem' => 'None',
        'Stomach and Liver Problem' => 'None',
        'Pancreatic Problems' => 'None',
        'Anxiety and Depression' => 'None',
        'Other Mental Health Issue' => 'None',
        'Sleep Disorder' => 'None',
        'Neck or Back Problem' => 'None',
    ];

    if (isset($_POST)) {
        foreach ($conditions as $condition_name => $condition_status) {
            // Get the current condition value from the POST data, default to 'None' if not set
            $condition_key = strtolower(str_replace(' ', '_', $condition_name));
            $condition_value = $_POST[$condition_key] ?? 'None';

            // Check if the condition already exists in the database
            $sql_check = "SELECT * FROM medical_conditions WHERE medical_record_id = ? AND condition_name = ?";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bind_param("is", $medical_record_id, $condition_name);
            $stmt_check->execute();
            $result = $stmt_check->get_result();

            if ($result && mysqli_num_rows($result) > 0) {
                // Condition exists, so update it regardless of its value (None, Yes, I'm not sure)
                $sql_update = "UPDATE medical_conditions SET condition_status = ? WHERE medical_record_id = ? AND condition_name = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("sis", $condition_value, $medical_record_id, $condition_name);

                // Execute the update and check for errors
                if (!$stmt_update->execute()) {
                    echo "Failed to update condition: $condition_name. Error: " . $stmt_update->error . "<br>";
                    $messages[] = "Failed to update condition: $condition_name. Error: " . $stmt_update->error;
                    $all_success = false;
                } else {
                    // echo "Condition updated successfully: $condition_name!<br>";
                    // $messages[] = "Condition updated successfully: $condition_name!";
                }

                $stmt_update->close();
            } else {
                // Condition does not exist, only insert if the value is "Yes" or "I'm not sure"
                if ($condition_value == "Yes" || $condition_value == "I'm not sure") {
                    $sql_insert = "INSERT INTO medical_conditions (medical_record_id, condition_name, condition_status) 
                                   VALUES (?, ?, ?)";
                    $stmt_insert = $conn->prepare($sql_insert);
                    $stmt_insert->bind_param("iss", $medical_record_id, $condition_name, $condition_value);

                    // Execute the insert and check for errors
                    if (!$stmt_insert->execute()) {
                        echo "Failed to insert condition: $condition_name. Error: " . $stmt_insert->error . "<br>";
                    }
                    $stmt_insert->close();
                }
            }
            $stmt_check->close();
        }

        $success_message = 'Medical history has been updated successfully!';
    }

    if ($all_success) {
        header("Location: ../manage patient/patient_profile.php?id=$patient_id&message=Medical Record ID $medical_record_id Updated Successfully&message_type=success");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <br>
    <?php
    // Display success or error message
    // if (isset($_GET['message'])) {
    //     $messageType = $_GET['message_type'] == 'success' ? 'alert-success' : 'alert-danger';
    //     echo '<div class="alert ' . $messageType . '">';
    //     echo '<strong>' . htmlspecialchars($_GET['message']) . '</strong>';
    //     echo '</div>';
    // }
    ?>
    <div class="container">
        <!-- Display Bootstrap Alerts for each message -->
        <?php foreach ($messages as $msg): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $msg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endforeach; ?>

        <!-- Your form goes here -->
        <form method="POST" action="">
            <!-- Form fields... -->
        </form>
    </div>

    <a href="http://localhost/congenial-sniffle-master/patient%20page/medical%20history%20handler/medical%20history%20view.php">
        <button>Back</button>
    </a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>