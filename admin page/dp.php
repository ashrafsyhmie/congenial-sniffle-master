php
Copy code
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

// Add the gender column
$sql = "ALTER TABLE patients_info ADD gender VARCHAR(10)";

// Execute the query
if($conn->query($sql) === TRUE){
  echo "Table updated successfully";
} else {
  echo "Error updating table: " . $conn->error;
}

// Close the connection
$conn->close();
?>