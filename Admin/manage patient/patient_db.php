<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "patients";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve POST data with checks
    $Pt_name = isset($_POST['txtName']) ? $_POST['txtName'] : '';
    $Address = isset($_POST['add']) ? $_POST['add'] : '';
    $Email = isset($_POST['email']) ? $_POST['email'] : '';
    $gender = isset($_POST['sex']) ? $_POST['sex'] : '';
    $Num_Phone = isset($_POST['txtNum']) ? $_POST['txtNum'] : '';
    $emergency = isset($_POST['emerCont']) ? $_POST['emerCont'] : '';
    $dob = isset($_POST['dob']) ? $_POST['dob'] : '';

  // Prepare the statement
  $stmt = $conn->prepare("INSERT INTO patients_info (name, address, email, gender, cont_number, emerg_number, d_o_b) VALUES (?, ?, ?, ?, ?, ?, ?)");
  if ($stmt) {
    // Bind parameters
    $stmt->bind_param("sssssss", $Pt_name, $Address, $Email, $gender, $Num_Phone, $emergency, $dob);

    // Execute the statement
    if ($stmt->execute()) {
      echo "New record created successfully";
      echo "<script>alert('Patient info submitted successfully!')</script>";
      
    } else {
      echo "Error: " . $stmt->error;
      echo "<script>alert('Error: something happen')</script>";
    }

    // Close the statement
    $stmt->close();
  } else {
    echo "Error preparing the statement: " . $conn->error;
  }
} else {
  // Form is not submitted, handle this case accordingly
  echo "The form is not submitted or submitted incorrectly.";
}

// Close the database connection
$conn->close();
?>