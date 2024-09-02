<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medassist 2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$successmsg = "";

$Pt_name = "";
$Address = "";
$Email = "";
$gender = "";
$Num_Phone = "";
$emergency = "";
$dob = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve POST data with checks
    $Pt_name = $_POST['txtName'];
    $Address = $_POST['add'];
    $Email = $_POST['email'];
    $gender = $_POST['sex'];
    $Num_Phone = $_POST['txtNum'];
    $emergency = $_POST['emerCont'];
    $dob = $_POST['dob'];

    // Prepare the statement
    $stmt = $conn->prepare("INSERT INTO patients_info (name, address, email, gender, cont_number, emerg_number, d_o_b) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("sssssss", $Pt_name, $Address, $Email, $gender, $Num_Phone, $emergency, $dob);

        // Execute the statement
        if ($stmt->execute()) {
            $successmsg = "New record created successfully";
        } else {
            $successmsg = "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        $successmsg = "Error preparing the statement: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="patient form.css">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />

    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <title>Patient Form</title>
</head>

<body>
    <div class="container contact-form">
        <div class="contact-image ">
            <img src="../img/svg/logo-only.svg" />
        </div>
        <form method="post">
            <h3>Patient Information</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="txtName" class="form-control" placeholder="Patient Name" value="<?php echo $Pt_name; ?>" required />
                    </div>
                    <div class="form-group">
                        <input type="text" name="add" class="form-control" placeholder="Address" value="<?php echo $Address; ?>" required />
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $Email; ?>" required />
                    </div>
                    <div class="form-group">
                        <label for="">Gender</label><br>
                        <input type="radio" name="sex" value="Male" <?php echo $gender == 'Male' ? 'checked' : ''; ?> required> Male
                        <br>
                        <input type="radio" name="sex" value="Female" <?php echo $gender == 'Female' ? 'checked' : ''; ?>> Female
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="txtNum" class="form-control" placeholder="Contact number" value="<?php echo $Num_Phone; ?>" />
                    </div>
                    <div class="form-group">
                        <input type="text" name="emerCont" class="form-control" placeholder="Emergency Contact" value="<?php echo $emergency; ?>" required />
                    </div>
                    <div class="form-group">
                        <label for="">Date of Birthday</label>
                        <input type="date" name="dob" class="form-control" value="<?php echo $dob; ?>" placeholder="Date of Birth" required />
                    </div>


                </div>


            </div>
            <br><br><br>
            <div class="container">
                <div class="form-group text-center">
                    <button name="btnSubmit" id="btnSubmit" class="btnContact">Submit</button>
                </div>
            </div>


            <?php
            if (!empty($successmsg)) {
                echo "<script>alert('$successmsg')</script>";
                if (strpos($successmsg, 'created successfully') !== false) {
                    echo "<script>window.location.href = 'view all patient.php'</script>";
                }
            }
            ?>
        </form>
    </div>
</body>

</html>