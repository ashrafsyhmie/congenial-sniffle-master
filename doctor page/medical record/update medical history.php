<?php
// Database configuration
require_once('../../db conn.php');
session_start();
$admin_id = $_SESSION['admin_id'];

$messages = []; // Array to hold messages
$all_success = true; // Flag to track overall success

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get POST data
    $patient_id = $_POST['patient_id'];
    $medical_record_id = $_POST['medical_record_id'];

    // Medication handling
    if (isset($_POST['medication_name']) && !empty($_POST['medication_name'])) {
        $medication_names = $_POST['medication_name'];
        $purposes = $_POST['purpose'];
        $dosages = $_POST['dosage'];
        $frequencies = $_POST['frequency'];

        foreach ($medication_names as $i => $medication_name) {
            $purpose = $purposes[$i];
            $dosage = $dosages[$i];
            $frequency = $frequencies[$i];

            // Check if medication exists
            $check_sql = "SELECT * FROM medication WHERE medical_record_id = ? AND medication_name = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("ss", $medical_record_id, $medication_name);
            $check_stmt->execute();
            $result = $check_stmt->get_result();

            if ($result->num_rows > 0) {
                // Update medication
                $update_sql = "UPDATE medication SET purpose = ?, dosage = ?, frequency = ? WHERE medical_record_id = ? AND medication_name = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("sssss", $purpose, $dosage, $frequency, $medical_record_id, $medication_name);

                if (!$update_stmt->execute()) {
                    $messages[] = "Failed to update medication: $medication_name. Error: " . $update_stmt->error;
                    $all_success = false;
                }
                $update_stmt->close();
            } else {
                // Insert medication
                $insert_sql = "INSERT INTO medication (medical_record_id, medication_name, purpose, dosage, frequency) VALUES (?, ?, ?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("issss", $medical_record_id, $medication_name, $purpose, $dosage, $frequency);

                if (!$insert_stmt->execute()) {
                    $messages[] = "Failed to insert medication: $medication_name. Error: " . $insert_stmt->error;
                    $all_success = false;
                }
                $insert_stmt->close();
            }

            $check_stmt->close();
        }
    }

    // Update patient lifestyle
    $smoking = $_POST['smoking'];
    $alcohol = $_POST['alcohol'];

    // Handle allergies input
    $allergies_input = $_POST['allergies'];
    $allergies_choice = $_POST['allergies_choice'];
    $allergies = ($allergies_choice === 'no') ? 'No' : (!empty($allergies_input) ? $allergies_input : 'No');

    $sql = "UPDATE patient_lifestyle SET smoking_history = ?, alcohol_consumption = ?, allergies_history = ? WHERE patient_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $smoking, $alcohol, $allergies, $patient_id);

    if (!$stmt->execute()) {
        $messages[] = "Failed to update patient lifestyle: $patient_id. Error: " . $stmt->error;
        $all_success = false;
    }
    $stmt->close();

    // Update physical exam
    $temperature = $_POST['temperature'];
    $blood_pressure = $_POST['blood_pressure'];
    $heart_rate = $_POST['heart_rate'];
    $respiratory_rate = $_POST['respiratory_rate'];

    $sql = "UPDATE physical_exam SET temperature = ?, blood_pressure = ?, heart_rate = ?, respiratory_rate = ? WHERE medical_record_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $temperature, $blood_pressure, $heart_rate, $respiratory_rate, $medical_record_id);

    if (!$stmt->execute()) {
        $messages[] = "Failed to update physical exam. Error: " . $stmt->error;
        $all_success = false;
    }
    $stmt->close();

    // Update or insert diagnosis
    if (isset($_POST['procedure_name'])) {
        $procedure_names = $_POST['procedure_name'];
        $diagnosis_purposes = $_POST['diagnosis_purpose'];
        $diagnosis_results = $_POST['diagnosis_result'];

        foreach ($procedure_names as $i => $procedure_name) {
            $diagnosis_purpose = $diagnosis_purposes[$i];
            $diagnosis_result = $diagnosis_results[$i];

            // Check if diagnosis exists
            $sql = "SELECT * FROM diagnosis WHERE medical_record_id = ? AND procedure_name = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $medical_record_id, $procedure_name);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Update existing diagnosis
                $sql = "UPDATE diagnosis SET purpose = ?, result = ? WHERE medical_record_id = ? AND procedure_name = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssis", $diagnosis_purpose, $diagnosis_result, $medical_record_id, $procedure_name);

                if (!$stmt->execute()) {
                    $messages[] = "Failed to update diagnosis: $procedure_name. Error: " . $stmt->error;
                    $all_success = false;
                }
            } else {
                // Insert new diagnosis
                $sql = "INSERT INTO diagnosis (medical_record_id, procedure_name, purpose, result) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("isss", $medical_record_id, $procedure_name, $diagnosis_purpose, $diagnosis_result);

                if (!$stmt->execute()) {
                    $messages[] = "Failed to insert diagnosis: $procedure_name. Error: " . $stmt->error;
                    $all_success = false;
                }
            }
            $stmt->close();
        }
    }

    // Update conditions

    if (isset($_POST['condition_name'], $_POST['medical_condition_status']) && !empty($_POST['condition_name'])) {
        $condition_names = $_POST['condition_name'];
        $condition_statuses = $_POST['medical_condition_status'];

        // Prepare the SQL query for INSERT or UPDATE
        $sql = "INSERT INTO medical_conditions (medical_record_id, condition_name, condition_status) 
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE condition_status = ?";
        $stmt = $conn->prepare($sql);

        // Loop through each medical condition and its status
        foreach ($condition_names as $index => $medical_condition) {
            $medical_condition_status = $condition_statuses[$index];

            // Skip if the condition status is 'None'
            if ($medical_condition_status === 'None') {
                continue;
            }

            // Bind parameters for the query
            $stmt->bind_param("isss", $medical_record_id, $medical_condition, $medical_condition_status, $medical_condition_status);

            // Execute the query
            if (!$stmt->execute()) {
                echo "Failed to insert/update condition: $medical_condition. Error: " . $stmt->error . "<br>";
            } else {
                echo "Condition '$medical_condition' inserted/updated successfully.<br>";
            }
        }

        // Close the prepared statement after the loop
        $stmt->close();
    }



    // Final message display
    if ($all_success) {
        $messages[] = "All records updated successfully.";
    } else {
        $messages[] = "Some updates failed.";
    }

    // Display success/error messages
    foreach ($messages as $message) {
        echo "<div class='alert alert-info'>$message</div>";
    }
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