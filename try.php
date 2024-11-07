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

            $stmt->bind_param("iss", $medical_record_id, $condition_name, $condition_status);

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