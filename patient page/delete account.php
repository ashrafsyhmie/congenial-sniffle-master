<?php
session_start();

require_once "../db conn.php";

if (isset($_SESSION["patient_id"])) {
    $id = $_SESSION["patient_id"];



    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM patient WHERE patient_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Record deleted successfully, now redirect
        echo "Record deleted successfully";
        header("Location: ../index.php?message=Account deleted successfully&message_type=success");
        exit;
    } else {
        // Handle error if the deletion fails
        echo "Error deleting record: " . $conn->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
