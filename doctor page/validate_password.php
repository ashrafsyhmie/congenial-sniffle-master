<?php
// validate_password.php

// Start session to access doctor's credentials (assuming the doctor is logged in)
require_once('../db conn.php');
session_start();

// Function to validate doctor's password
function validate_doctor_password($doctor_id, $password)
{
    global $conn;  // Ensure $conn is in scope

    // Query the database to get the stored hashed password for the doctor
    $query = "SELECT password FROM doctor WHERE doctor_id = ?";
    $stmt = mysqli_prepare($conn, $query);  // Use mysqli_prepare with the valid $conn

    // Check if the prepare statement was successful
    if (!$stmt) {
        die('Query preparation failed: ' . mysqli_error($conn));
    }

    // Bind doctor_id as integer
    mysqli_stmt_bind_param($stmt, "i", $doctor_id);
    mysqli_stmt_execute($stmt);

    // Bind the result to get the stored password hash
    mysqli_stmt_bind_result($stmt, $stored_hash);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Debugging: Check if the stored hash is retrieved correctly
    if (!$stored_hash) {
        echo "No stored hash found for doctor_id: $doctor_id <br>";
        return false;  // No password found for the doctor
    }
    echo "Stored hash: " . $stored_hash . "<br>";
    echo "Entered password: " . $password . "<br>";

    // Use password_verify to check if the entered password matches the stored hash
    if (password_verify($password, $stored_hash)) {
        echo "Password is correct!<br>";
        return true;
    } else {
        echo "Password is incorrect.<br>";
        return false;
    }
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $medical_record_id = $_POST['medical_record_id']; // Hidden field for medical_record_id

    $password = $_POST['password']; // Password entered by the doctor

    // Get the doctor's ID from the session
    $doctor_id = $_SESSION['doctor_id']; // Ensure doctor_id is stored in session during login

    // Debugging: Check if doctor_id is correct
    echo "Doctor ID from session: " . $doctor_id . "<br>";

    // Validate the doctor's password
    if (validate_doctor_password($doctor_id, $password)) {
        // Password is correct, allow the doctor to edit the record
        header("Location: ./medical record/edit medical record.php?medical_record_id=$medical_record_id");
        exit(); // Exit after redirect to prevent further processing

    } else {
        // Password is incorrect, show an error message
        header("Location: ./appointment record.php?message=Incorrect password&message_type=danger");
        exit();
    }
}
