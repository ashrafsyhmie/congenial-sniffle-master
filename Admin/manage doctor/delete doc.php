<?php

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // For debugging (to see if the id is passed correctly)
    // echo $id;

    require_once "../../db conn.php";

    // Correcting the SQL to use the correct column name 'doctor_id'
    $sql = "DELETE FROM doctor WHERE doctor_id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    // Redirect to the page that lists all doctors
    header("Location: /Admin/Admin/view all doctors.php");
    exit;
}
?>
