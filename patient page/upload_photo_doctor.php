<?php
require_once('./db conn.php'); // Ensure this file contains a valid connection to your database

$errorMsg = "";
$successMsg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageType = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        // Validate image type and size
        if (in_array($imageType, ['jpg', 'jpeg', 'png']) && $_FILES['image']['size'] < 5000000) { // Limit size to 5MB
            $imageData = file_get_contents($_FILES['image']['tmp_name']);

            // Prepare SQL query to update doctor information
            $sql = "UPDATE doctor SET doctor_photo = ? WHERE doctor_id = 3";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $imageData);

            // Execute the query
            if ($stmt->execute()) {
                $successMsg = "Doctor information updated successfully.";
            } else {
                $errorMsg = "Error updating Doctor information: " . $conn->error;
            }
        } else {
            $errorMsg = "Invalid image file type or size.";
        }
    } elseif (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $errorMsg = "Error uploading image.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Photo</title>
</head>

<body>
    <?php if (!empty($successMsg)): ?>
        <p style="color: green;"><?php echo htmlspecialchars($successMsg); ?></p>
    <?php elseif (!empty($errorMsg)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($errorMsg); ?></p>
    <?php endif; ?>

    <form action="./upload_photo_doctor.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="image" id="image">
        <input type="submit" value="Upload Image">
    </form>
</body>

</html>