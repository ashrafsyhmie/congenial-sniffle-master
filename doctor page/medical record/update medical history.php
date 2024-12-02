<?php
// Database configuration
require_once('../../db conn.php');
session_start();


$messages = []; // Array to hold messages
$all_success = true; // Flag to track overall success

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get POST data
    $patient_id = $_POST['patient_id'];
    $medical_record_id = $_POST['medical_record_id'];

    // Medication handling
    // if (isset($_POST['medication_name']) && !empty($_POST['medication_name'])) {
    //     $medication_names = $_POST['medication_name'];
    //     $purposes = $_POST['purpose'];
    //     $dosages = $_POST['dosage'];
    //     $frequencies = $_POST['frequency'];

    //     foreach ($medication_names as $i => $medication_name) {
    //         $purpose = $purposes[$i];
    //         $dosage = $dosages[$i];
    //         $frequency = $frequencies[$i];

    //         // Check if medication exists
    //         $check_sql = "SELECT * FROM medication WHERE medical_record_id = ? AND medication_name = ?";
    //         $check_stmt = $conn->prepare($check_sql);
    //         $check_stmt->bind_param("ss", $medical_record_id, $medication_name);
    //         $check_stmt->execute();
    //         $result = $check_stmt->get_result();

    //         if ($result->num_rows > 0) {
    //             // Update medication
    //             $update_sql = "UPDATE medication SET purpose = ?, dosage = ?, frequency = ? WHERE medical_record_id = ? AND medication_name = ?";
    //             $update_stmt = $conn->prepare($update_sql);
    //             $update_stmt->bind_param("sssss", $purpose, $dosage, $frequency, $medical_record_id, $medication_name);

    //             if (!$update_stmt->execute()) {
    //                 $messages[] = "Failed to update medication: $medication_name. Error: " . $update_stmt->error;
    //                 $all_success = false;
    //             }
    //             $update_stmt->close();
    //         } else {
    //             // Insert medication
    //             $insert_sql = "INSERT INTO medication (medical_record_id, medication_name, purpose, dosage, frequency) VALUES (?, ?, ?, ?, ?)";
    //             $insert_stmt = $conn->prepare($insert_sql);
    //             $insert_stmt->bind_param("issss", $medical_record_id, $medication_name, $purpose, $dosage, $frequency);

    //             if (!$insert_stmt->execute()) {
    //                 $messages[] = "Failed to insert medication: $medication_name. Error: " . $insert_stmt->error;
    //                 $all_success = false;
    //             }
    //             $insert_stmt->close();
    //         }

    //         $check_stmt->close();
    //     }
    // }

    if (isset($_POST['medication_name']) && !empty($_POST['medication_name'])) {
        $medication_names = $_POST['medication_name'];
        $purposes = $_POST['purpose'];
        $dosages = $_POST['dosage'];
        $frequencies = $_POST['frequency'];

        // Step 1: Fetch existing medications for comparison
        $existing_medications = [];
        $existing_sql = "SELECT medication_name FROM medication WHERE medical_record_id = ?";
        $existing_stmt = $conn->prepare($existing_sql);
        $existing_stmt->bind_param("i", $medical_record_id);
        $existing_stmt->execute();
        $existing_result = $existing_stmt->get_result();

        while ($row = $existing_result->fetch_assoc()) {
            $existing_medications[] = $row['medication_name'];
        }

        // Step 2: Process posted medications
        foreach ($medication_names as $i => $medication_name) {
            $purpose = $purposes[$i];
            $dosage = $dosages[$i];
            $frequency = $frequencies[$i];

            // Check if medication exists
            $check_sql = "SELECT * FROM medication WHERE medical_record_id = ? AND medication_name = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("is", $medical_record_id, $medication_name);
            $check_stmt->execute();
            $result = $check_stmt->get_result();

            if ($result->num_rows > 0) {
                // Update medication
                $update_sql = "UPDATE medication SET purpose = ?, dosage = ?, frequency = ? WHERE medical_record_id = ? AND medication_name = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("ssssi", $purpose, $dosage, $frequency, $medical_record_id, $medication_name);

                if (!$update_stmt->execute()) {
                    echo "Failed to update medication: " . htmlspecialchars($medication_name) . ". Error: " . htmlspecialchars($update_stmt->error);
                }
                $update_stmt->close();
            } else {
                // Insert medication
                $insert_sql = "INSERT INTO medication (medical_record_id, medication_name, purpose, dosage, frequency) VALUES (?, ?, ?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("issss", $medical_record_id, $medication_name, $purpose, $dosage, $frequency);

                if (!$insert_stmt->execute()) {
                    echo "Failed to insert medication: " . htmlspecialchars($medication_name) . ". Error: " . htmlspecialchars($insert_stmt->error);
                }
                $insert_stmt->close();
            }

            // Close check statement
            $check_stmt->close();
        }

        // Step 3: Identify and delete medications that were removed
        foreach ($existing_medications as $existing_medication) {
            if (!in_array($existing_medication, $medication_names)) {
                // Medication was not found in submitted data; delete it
                $delete_sql = "DELETE FROM medication WHERE medical_record_id = ? AND medication_name = ?";
                $delete_stmt = $conn->prepare($delete_sql);
                $delete_stmt->bind_param("is", $medical_record_id, $existing_medication);

                if (!$delete_stmt->execute()) {
                    echo "Failed to delete medication: " . htmlspecialchars($existing_medication) . ". Error: " . htmlspecialchars($delete_stmt->error);
                }
                // Close delete statement
                $delete_stmt->close();
            }
        }

        echo "Medication records updated successfully!";
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


    // Assume database connection is established

    // Medical record ID
    $medical_record_id = $_POST['medical_record_id'];

    // Fetch existing data from the database
    $sql = "SELECT * FROM diagnosis WHERE medical_record_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $medical_record_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $existing_data = [];
    while ($row = $result->fetch_assoc()) {
        $existing_data[] = $row;
    }
    $stmt->close();

    // Get POST data (form submission)
    $procedure_names = $_POST['procedure_name'];
    $diagnosis_purposes = $_POST['diagnosis_purpose'];
    $diagnosis_results = $_POST['diagnosis_result'];

    $posted_data = [];
    foreach ($procedure_names as $index => $procedure_name) {
        // Skip if procedure_name is empty or null
        if (empty($procedure_name)) {
            continue; // Skip empty procedure_name
        }
        $posted_data[] = [
            'procedure_name' => $procedure_name,
            'purpose' => $diagnosis_purposes[$index],
            'result' => $diagnosis_results[$index]
        ];
    }

    // Arrays to store operations
    $to_update = [];
    $to_insert = [];
    $to_delete = [];

    // Compare posted data with existing data
    foreach ($posted_data as $index => $posted_row) {
        $matched = false;
        foreach ($existing_data as $existing_row) {
            if ($posted_row['procedure_name'] === $existing_row['procedure_name']) {
                $matched = true;
                // If the procedure name matches but other data has changed, it's an update
                if ($posted_row['purpose'] !== $existing_row['purpose'] || $posted_row['result'] !== $existing_row['result']) {
                    $to_update[] = $posted_row;
                }
                break;
            }
        }

        // If no matching procedure was found in the database, it's a new entry (to insert)
        if (!$matched) {
            $to_insert[] = $posted_row;
        }
    }

    // Check for rows to delete (i.e., rows in $existing_data that aren't in $posted_data)
    foreach ($existing_data as $existing_row) {
        $found = false;
        foreach ($posted_data as $posted_row) {
            if ($existing_row['procedure_name'] === $posted_row['procedure_name']) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            $to_delete[] = $existing_row;
        }
    }

    // Insert new rows
    foreach ($to_insert as $row) {
        $sql = "INSERT INTO diagnosis (medical_record_id, procedure_name, purpose, result) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $medical_record_id, $row['procedure_name'], $row['purpose'], $row['result']);
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    // Update existing rows
    foreach ($to_update as $row) {
        $sql = "UPDATE diagnosis SET purpose = ?, result = ? WHERE medical_record_id = ? AND procedure_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssis", $row['purpose'], $row['result'], $medical_record_id, $row['procedure_name']);
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    // Delete removed rows
    foreach ($to_delete as $row) {
        $sql = "DELETE FROM diagnosis WHERE medical_record_id = ? AND procedure_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $medical_record_id, $row['procedure_name']);
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    // Return success message or redirect
    echo "Diagnosis updated successfully!";




    // Update or insert diagnosis
    // if (isset($_POST['procedure_name'])) {
    //     $procedure_names = $_POST['procedure_name'];
    //     $diagnosis_purposes = $_POST['diagnosis_purpose'];
    //     $diagnosis_results = $_POST['diagnosis_result'];

    //     foreach ($procedure_names as $i => $procedure_name) {
    //         $diagnosis_purpose = $diagnosis_purposes[$i];
    //         $diagnosis_result = $diagnosis_results[$i];

    //         // Check if diagnosis exists
    //         $sql = "SELECT * FROM diagnosis WHERE medical_record_id = ? AND procedure_name = ?";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bind_param("is", $medical_record_id, $procedure_name);
    //         $stmt->execute();
    //         $result = $stmt->get_result();

    //         if ($result->num_rows > 0) {
    //             // Update existing diagnosis
    //             $sql = "UPDATE diagnosis SET purpose = ?, result = ? WHERE medical_record_id = ? AND procedure_name = ?";
    //             $stmt = $conn->prepare($sql);
    //             $stmt->bind_param("ssis", $diagnosis_purpose, $diagnosis_result, $medical_record_id, $procedure_name);

    //             if (!$stmt->execute()) {
    //                 $messages[] = "Failed to update diagnosis: $procedure_name. Error: " . $stmt->error;
    //                 $all_success = false;
    //             }
    //         } else {
    //             // Insert new diagnosis
    //             $sql = "INSERT INTO diagnosis (medical_record_id, procedure_name, purpose, result) VALUES (?, ?, ?, ?)";
    //             $stmt = $conn->prepare($sql);
    //             $stmt->bind_param("isss", $medical_record_id, $procedure_name, $diagnosis_purpose, $diagnosis_result);

    //             if (!$stmt->execute()) {
    //                 $messages[] = "Failed to insert diagnosis: $procedure_name. Error: " . $stmt->error;
    //                 $all_success = false;
    //             }
    //         }
    //         $stmt->close();
    //     }
    // }

    // Update conditions

    // if (isset($_POST['condition_name'], $_POST['medical_condition_status']) && !empty($_POST['condition_name'])) {
    //     $condition_names = $_POST['condition_name'];
    //     $condition_statuses = $_POST['medical_condition_status'];

    //     // Prepare the SQL query for INSERT or UPDATE
    //     $sql = "INSERT INTO medical_conditions (medical_record_id, condition_name, condition_status) 
    //             VALUES (?, ?, ?)
    //             ON DUPLICATE KEY UPDATE condition_status = ?";
    //     $stmt = $conn->prepare($sql);

    //     // Loop through each medical condition and its status
    //     foreach ($condition_names as $index => $medical_condition) {
    //         $medical_condition_status = $condition_statuses[$index];

    //         // Skip if the condition status is 'None'
    //         if ($medical_condition_status === 'None') {
    //             continue;
    //         }

    //         // Bind parameters for the query
    //         $stmt->bind_param("isss", $medical_record_id, $medical_condition, $medical_condition_status, $medical_condition_status);

    //         // Execute the query
    //         if (!$stmt->execute()) {
    //             echo "Failed to insert/update condition: $medical_condition. Error: " . $stmt->error . "<br>";
    //         } else {
    //             echo "Condition '$medical_condition' inserted/updated successfully.<br>";
    //         }
    //     }

    //     // Close the prepared statement after the loop
    //     $stmt->close();
    // }





    // if (isset($_POST['condition_name'], $_POST['medical_condition_status']) && !empty($_POST['condition_name'])) {
    //     $condition_names = $_POST['condition_name'];
    //     $condition_statuses = $_POST['medical_condition_status'];

    //     foreach ($condition_names as $index => $medical_condition) {
    //         if (empty($medical_condition)) {
    //             continue; // Skip if condition name is empty
    //         }

    //         $medical_condition_status = isset($condition_statuses[$index]) ? $condition_statuses[$index] : null;

    //         // Skip if the condition status is 'None' or null
    //         if ($medical_condition_status === 'None' || empty($medical_condition_status)) {
    //             continue;
    //         }

    //         // Check if the condition already exists in the database
    //         $sql = "SELECT * FROM medical_conditions WHERE medical_record_id = ? AND condition_name = ?";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bind_param("is", $medical_record_id, $medical_condition);
    //         $stmt->execute();
    //         $result = $stmt->get_result();

    //         if ($result->num_rows > 0) {
    //             // Update the existing record
    //             $sql = "UPDATE medical_conditions SET condition_status = ? WHERE medical_record_id = ? AND condition_name = ?";
    //             $stmt = $conn->prepare($sql);
    //             $stmt->bind_param("sis", $medical_condition_status, $medical_record_id, $medical_condition);

    //             if (!$stmt->execute()) {
    //                 echo "Failed to update condition: $medical_condition. Error: " . $stmt->error . "<br>";
    //             } else {
    //                 echo "Condition '$medical_condition' updated successfully.<br>";
    //             }
    //         } else {
    //             // Insert new condition
    //             $sql = "INSERT INTO medical_conditions (medical_record_id, condition_name, condition_status) VALUES (?, ?, ?)";
    //             $stmt = $conn->prepare($sql);
    //             $stmt->bind_param("iss", $medical_record_id, $medical_condition, $medical_condition_status);

    //             if (!$stmt->execute()) {
    //                 echo "Failed to insert condition: $medical_condition. Error: " . $stmt->error . "<br>";
    //             } else {
    //                 echo "Condition '$medical_condition' inserted successfully.<br>";
    //             }
    //         }
    //         $stmt->close();
    //     }
    // }

    if (isset($_POST['condition_name'], $_POST['medical_condition_status']) && !empty($_POST['condition_name'])) {
        $condition_names = $_POST['condition_name'];
        $condition_statuses = $_POST['medical_condition_status'];

        // Step 1: Fetch existing conditions for comparison
        $existing_conditions = [];
        $existing_sql = "SELECT condition_name FROM medical_conditions WHERE medical_record_id = ?";
        $existing_stmt = $conn->prepare($existing_sql);
        $existing_stmt->bind_param("i", $medical_record_id);
        $existing_stmt->execute();
        $existing_result = $existing_stmt->get_result();

        while ($row = $existing_result->fetch_assoc()) {
            $existing_conditions[] = $row['condition_name'];
        }

        // Step 2: Process posted conditions
        foreach ($condition_names as $index => $medical_condition) {
            if (empty($medical_condition)) {
                continue; // Skip if condition name is empty
            }

            $medical_condition_status = isset($condition_statuses[$index]) ? $condition_statuses[$index] : null;

            // Skip if the condition status is 'None' or null
            if ($medical_condition_status === 'None' || empty($medical_condition_status)) {
                continue;
            }

            // Check if the condition already exists in the database
            $sql = "SELECT * FROM medical_conditions WHERE medical_record_id = ? AND condition_name = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $medical_record_id, $medical_condition);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Update the existing record
                $sql = "UPDATE medical_conditions SET condition_status = ? WHERE medical_record_id = ? AND condition_name = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sis", $medical_condition_status, $medical_record_id, $medical_condition);

                if (!$stmt->execute()) {
                    echo "Failed to update condition: " . htmlspecialchars($medical_condition) . ". Error: " . htmlspecialchars($stmt->error) . "<br>";
                } else {
                    echo "Condition '" . htmlspecialchars($medical_condition) . "' updated successfully.<br>";
                }
            } else {
                // Insert new condition
                $sql = "INSERT INTO medical_conditions (medical_record_id, condition_name, condition_status) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $medical_record_id, $medical_condition, $medical_condition_status);

                if (!$stmt->execute()) {
                    echo "Failed to insert condition: " . htmlspecialchars($medical_condition) . ". Error: " . htmlspecialchars($stmt->error) . "<br>";
                } else {
                    echo "Condition '" . htmlspecialchars($medical_condition) . "' inserted successfully.<br>";
                }
            }
            // Close statement
            $stmt->close();
        }

        // Step 3: Identify and delete conditions that were removed
        foreach ($existing_conditions as $existing_condition) {
            if (!in_array($existing_condition, $condition_names)) {
                // Condition was not found in submitted data; delete it
                $delete_sql = "DELETE FROM medical_conditions WHERE medical_record_id = ? AND condition_name = ?";
                $delete_stmt = $conn->prepare($delete_sql);
                $delete_stmt->bind_param("is", $medical_record_id, $existing_condition);

                if (!$delete_stmt->execute()) {
                    echo "Failed to delete condition: " . htmlspecialchars($existing_condition) . ". Error: " . htmlspecialchars($delete_stmt->error) . "<br>";
                } else {
                    echo "Condition '" . htmlspecialchars($existing_condition) . "' deleted successfully.<br>";
                }
                // Close delete statement
                $delete_stmt->close();
            }
        }
    }


    // Final message display
    if ($all_success) {
        $messages[] = "All records updated successfully.";
        header("Location: ../appointment record.php?message=Medical record updated successfully&message_type=success");
    } else {
        $messages[] = "Some updates failed.";
    }

    // Display success/error messages
    foreach ($messages as $message) {
        echo "<div class='alert alert-info'>$message</div>";
    }
}
