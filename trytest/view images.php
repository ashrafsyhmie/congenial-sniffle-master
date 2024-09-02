<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "try_test_images";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT image, image_name FROM images";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div>';
        echo '<h3>' . $row['image_name'] . '</h3>';
        echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" />';
        echo '</div>';
    }
} else {
    echo "No images found.";
}

$conn->close();
