<?php


session_start();
$admin_id = $_SESSION['admin_id'];
$admin_name = $_SESSION['admin_name'];


require_once "../../db conn.php";

$successmsg = "";

$Pt_name = "";
$Address = "";
$Email = "";
$gender = "";
$Num_Phone = "";
$emergency = "";
$dob = "";
$ic = "";

// Check if the form is submitted
if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['btnSubmit'])) {
    // Retrieve POST data with checks
    $Pt_name = $_POST['txtName'];
    $Address = $_POST['add'];
    $Email = $_POST['email'];
    $gender = $_POST['sex'];
    $Num_Phone = $_POST['number'];
    $emergency = $_POST['emergency_number'];
    $dob = $_POST['dob'];
    $ic = $_POST['ic_num'];

    // Check if image file is provided and there is no error
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        // Read the image file data
        $imageData = file_get_contents($_FILES['image']['tmp_name']);

        // Prepare the SQL statement with placeholders
        $stmt = $conn->prepare("INSERT INTO patient (patient_name, `ic number`, address, email, gender, `phone number`, emerg_num, d_o_b, patient_photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt) {
            // Bind the parameters (use 'b' for blob image data)
            $stmt->bind_param("sssssssss", $Pt_name, $ic, $Address, $Email, $gender, $Num_Phone, $emergency, $dob, $imageData);

            // Execute the statement
            if ($stmt->execute()) {
                header("Location: ./view all patient.php?message= New Patient added successfully!&message_type=success");
            } else {
                $successmsg = "Error executing statement: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            $successmsg = "Error preparing the statement: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Add Patient</title>

    <!-- Custom fonts for this template-->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />

    <link
        href="../../vendor/fontawesome-free/css/all.min.css"
        rel="stylesheet"
        type="text/css" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet" />
</head>

<body id="page-top">
    <style>
        .form-group {
            margin-bottom: 15px;
        }

        .custom-btn {
            border-radius: 10px;
            color: #161D6F;
            padding: 6px 15px;
            background-color: #D2E0FB;
            font-size: 16px;
            outline: none;
            cursor: pointer;
            margin: 0px;
            transition: background-color 0.3s, color 0.3s;
        }

        .custom-btn:hover,
        .custom-btn:focus {
            background-color: #2C57DD;
            /* Darker blue for hover/focus */
            color: #FFF;
        }

        input[type="radio"] {
            display: none;
            /* Hide the radio button itself */
        }

        input[type="radio"]:checked+label {
            background-color: #0056b3;
            /* Darker blue to indicate selection */
            color: #FFF;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="number"],
        #specialization {
            width: 90%;
        }

        .gender-buttons {
            background-color: #D2E0FB;
            border-radius: 8px;
            display: inline-block;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .upload-photo {
            display: flex;
            flex-direction: column;
            align-items: start;
            margin-top: 10px;
            margin-right: 20px;
        }

        .upload-label {
            display: flex;
            align-items: center;
            cursor: pointer;
            color: #161D6F;
            margin-left: 20px;
        }



        .upload-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 10px;
        }

        .upload-icon i {
            font-size: 17px;
            color: #2C57DD;
        }

        /* Hover effect */
        .upload-label:hover {
            color: #2C57DD;
        }

        .upload-label:hover .upload-icon {
            background-color: #D2E0FB;
        }

        .upload-label span {
            font-size: 15px;
        }

        .rounded-circle {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        #selectedImage {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            margin-top: 20px;
        }

        .container {
            background-color: #EEF7FF;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(44, 87, 221, 0.2);
            width: 1000px;
            margin-bottom: 30px;
        }

        .row {
            color: #2C57DD;
        }

        .form-control {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .custom-select {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .mini-photo {
            width: 45px;
            /* set the width */
            height: 45px;
            /* set the height */
            object-fit: cover;
            /* to maintain the aspect ratio and cover the area */
            border-radius: 50%;
            /* for a circular shape */
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)
        }
    </style>
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul
            class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
            id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a
                class="sidebar-brand d-flex align-items-center justify-content-center"
                href="../homepage.php">
                <div class="sidebar-brand-icon">
                    <img src="../img/svg/logo-only.svg" />
                </div>
                <div class="sidebar-brand-text mx-2">MedAssist</div>
            </a>

            <!-- Nav Item - Dashboard -->
            <li class="nav-item ml-1">
                <a class="nav-link" href="../homepage.php">
                    <i class="fa-solid fa-house"></i>
                    <span>Home</span></a>
            </li>

            <li class="nav-item  ml-1">
                <a class="nav-link" href="../manage doctor/view all doctors.php">
                    <i class="fa-solid fa-stethoscope"></i>
                    <span>View All Doctors</span></a>
            </li>

            <li class="nav-item active ml-1">
                <a class="nav-link" href="./view all patient.php">
                    <i class="fa-regular fa-user"></i>
                    <span>View All Patients</span></a>
            </li>

            <li class="nav-item ml-1">
                <a class="nav-link" href="../manage appointment/view all appointment.php">
                    <i class="fa-solid fa-bookmark"></i>
                    <span>View All Appointment</span></a>
            </li>

            <li class="nav-item ml-1">
                <a
                    class="nav-link"
                    href="#"
                    data-toggle="modal"
                    data-target="#logoutModal">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Sign Out</span></a>
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button
                    class="rounded-circle border-0 mt-5"
                    id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav
                    class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button
                        id="sidebarToggleTop"
                        class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a
                                class="nav-link dropdown-toggle"
                                href="#"
                                id="searchDropdown"
                                role="button"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div
                                class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control bg-light border-0 small"
                                            placeholder="Search for..."
                                            aria-label="Search"
                                            aria-describedby="basic-addon2" />
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a
                                class="nav-link dropdown-toggle"
                                href="#"
                                id="userDropdown"
                                role="button"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                <span class="mr-3 d-none d-lg-inline text-gray-600 small"><?php echo $admin_name  ?></span>
                                <?php
                                echo '<td><img src="data:image/jpeg;base64,' . base64_encode($_SESSION['admin_photo']) . '" alt="Admin photo" class="mini-photo"></td>'
                                ?>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div
                                class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a
                                    class="dropdown-item"
                                    href="#"
                                    data-toggle="modal"
                                    data-target="#logoutModal">
                                    <i
                                        class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-center mb-4">
                        <h1 class="h2 mb-0 text-gray-900 font-weight-bolder">
                            Insert New Patient
                        </h1>
                    </div>
                    <h4 class="d-sm-flex align-items-center justify-content-center mb-4">
                        Fill in the details below.
                    </h4>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <tbody>
                                    <div class="container contact-form">
                                        <form method="post" action="./patient form.php" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Full Name</label>
                                                        <input type="text" name="txtName" class="form-control" placeholder="Patient Name" required />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">IC Number</label>
                                                        <input type="text" id="icInput" name="ic_num" class="form-control" placeholder="IC Number" maxlength="14" required />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Address</label>
                                                        <input type="text" name="add" class="form-control" placeholder="Address" required />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Email Address</label>
                                                        <input type="email" name="email" class="form-control" placeholder="Email" required />
                                                    </div>
                                                    <div class="upload-photo">
                                                        <div class="mb-4 d-flex justify-content-center" ;>
                                                            <img id="selectedImage" src="https://mdbootstrap.com/img/Photos/Others/placeholder.jpg"
                                                                alt="example placeholder" class="rounded-circle" />

                                                            <input type="file" name="image" id="image" onchange="displaySelectedImage(event, 'selectedImage')" hidden>
                                                            <label for="image" class="upload-label">
                                                                <div class="upload-icon">
                                                                    <i class="fa fa-camera"></i> <!-- Camera icon -->
                                                                </div><br>
                                                                <span style="color: #2C57DD;">Upload a photo</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Contact Number</label>
                                                        <input type="text" name="number" class="form-control" id="number" placeholder="Contact number" required maxlength="13" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Emergency Number</label>
                                                        <input type="text" name="emergency_number" class="form-control" id="emergency_number" placeholder="Contact number" required maxlength="13" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Date of Birthday</label>
                                                        <input type="date" name="dob" class="form-control" placeholder="Date of Birth" required />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Gender:</label><br>
                                                        <div class="gender-buttons">
                                                            <input type="radio" id="genderMale" name="sex" value="Male" hidden />
                                                            <label for="genderMale" class="btn custom-btn">Male</label>

                                                            <input type="radio" id="genderFemale" name="sex" value="Female" hidden />
                                                            <label for="genderFemale" class="btn custom-btn">Female</label>
                                                        </div>
                                                    </div>
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

                                            <div class="d-flex justify-content-center">
                                                <div class="mr-2">
                                                    <!-- Back Button -->
                                                    <a href="view all patient.php">
                                                        <button type="button" class="btn btn-primary mb-2">
                                                            <i class="fa-solid fa-chevron-left mr-1"></i> Back
                                                        </button>
                                                    </a>
                                                </div>
                                                <div><button class="btn btn-primary mx-2" name="btnSubmit" id="btnSubmit">Submit</button></div>
                                            </div>
                                        </form>
                                    </div>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white"></footer>
        <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div
        class="modal fade"
        id="logoutModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button
                        class="close"
                        type="button"
                        data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Select "Logout" below if you are ready to end your current session.
                </div>
                <div class="modal-footer">
                    <button
                        class="btn btn-secondary"
                        type="button"
                        data-dismiss="modal">
                        Cancel
                    </button>
                    <form action="../logout_modal.php" method="post">
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>


    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../js/demo/chart-area-demo.js"></script>
    <script src="../../js/demo/chart-pie-demo.js"></script>
    <script>
        document.querySelectorAll('.gender-buttons label').forEach(function(label) {
            label.addEventListener('click', function() {
                // Remove active state from all labels
                document.querySelectorAll('.gender-buttons label').forEach(function(lbl) {
                    lbl.classList.remove('active');
                });
                // Add active state to the clicked label
                this.classList.add('active');
            });
        });
    </script>

    <script>
        document.getElementById('icInput').addEventListener('input', function(e) {
            let icNumber = e.target.value.replace(/\D/g, ''); // Remove non-numeric characters
            if (icNumber.length > 6) {
                icNumber = icNumber.slice(0, 6) + '-' + icNumber.slice(6);
            }
            if (icNumber.length > 9) {
                icNumber = icNumber.slice(0, 9) + '-' + icNumber.slice(9);
            }
            e.target.value = icNumber; // Update the input field with the formatted value
        });
    </script>

    <script>
        function displaySelectedImage(event, elementId) {
            const selectedImage = document.getElementById(elementId);
            const fileInput = event.target;

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    selectedImage.src = e.target.result;
                };

                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    </script>

    <script>
        document.getElementById('number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove non-numeric characters

            // Insert hyphens at the correct positions
            if (value.length > 3) value = value.slice(0, 3) + '-' + value.slice(3);
            if (value.length > 7) value = value.slice(0, 7) + '-' + value.slice(7);

            e.target.value = value;
        });
        document.getElementById('emergency_number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove non-numeric characters

            // Insert hyphens at the correct positions
            if (value.length > 3) value = value.slice(0, 3) + '-' + value.slice(3);
            if (value.length > 7) value = value.slice(0, 7) + '-' + value.slice(7);

            e.target.value = value;
        });
    </script>


</body>