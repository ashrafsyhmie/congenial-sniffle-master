<form action="./upload images.php" method="POST" enctype="multipart/form-data">
    <label>Select Image:</label>
    <input type="file" name="image" required>
    <button type="submit" name="submit">Upload Image</button>
</form>

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

if (isset($_POST['submit'])) {
    // Get the image name and content
    $imageName = $_FILES['image']['name'];
    $imageData = addslashes(file_get_contents($_FILES['image']['tmp_name']));

    // Insert image data into the database
    $sql = "INSERT INTO images (image, image_name) VALUES ('$imageData', '$imageName')";
    if ($conn->query($sql) === TRUE) {
        echo "Image uploaded successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>