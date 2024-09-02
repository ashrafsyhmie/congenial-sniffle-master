<?php

require_once('./db conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["doctor_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["doctor_image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["doctor_image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["doctor_image"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["doctor_image"]["name"])) . " has been uploaded.";

            // Now save the file path into the database
            $doctor_name = $_POST['doctor_name'];
            $specialization = $_POST['specialization'];
            $image_path = $target_file;

            $sql = "INSERT INTO doctor (doctor_name, specialization, doctor_photo) VALUES ('$doctor_name', '$specialization', '$image_path')";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="./upload_photo_doctor.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="doctor_image" id="doctor_image">
        Doctor Name: <input type="text" name="doctor_name">
        Specialization: <input type="text" name="specialization">
        <input type="submit" value="Upload Image" name="submit">
    </form>

</body>

</html>