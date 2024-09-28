<?php

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    echo $id;

    require_once "../../db conn.php";

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM doctor WHERE doctor_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Record deleted successfully, now redirect
        echo "Record deleted successfully";
        header("Location: http://localhost/congenial-sniffle-master/admin/manage%20doctor/view%20all%20doctors.php");
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
