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
    $Num_Phone = $_POST['txtNum'];
    $emergency = $_POST['emerCont'];
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
                $successmsg = "New record created successfully";
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
                    class="nav-link collapsed"
                    href="settings.html"
                    data-toggle="collapse"
                    data-target="#collapseTwo"
                    ria-expanded="true"
                    aria-controls="collapseTwo">
                    <i class="fa-solid fa-gear"></i>
                    <span>Settings</span></a>
                <div
                    id="collapseTwo"
                    class="collapse"
                    aria-labelledby="headingTwo"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Settings</h6>
                        <a class="collapse-item" href="change info.html">Change Info</a>
                        <a class="collapse-item" href="settings.html"> Delete Account </a>
                    </div>
                </div>
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
                                <img
                                    class="img-profile rounded-circle"
                                    src="../img/undraw_profile.svg" />
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
                        <h1 class="h3 mb-0 text-gray-900 font-weight-bolder">
                            Add New Patient
                        </h1>

                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <tbody>
                                    <div class="container contact-form">
                                        <form method="post" action="./patient form.php" enctype="multipart/form-data">
                                            <h3>Patient Information</h3>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" name="txtName" class="form-control" placeholder="Patient Name" required />
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" id="icInput" name="ic_num" class="form-control" placeholder="IC Number" maxlength="14" required />
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" name="add" class="form-control" placeholder="Address" required />
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="email" name="email" class="form-control" placeholder="Email" required />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Gender</label><br>
                                                        <input type="radio" name="sex" value="Male" required> Male
                                                        <br>
                                                        <input type="radio" name="sex" value="Female"> Female
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" name="txtNum" class="form-control" placeholder="Contact number" />
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" name="emerCont" class="form-control" placeholder="Emergency Contact" required />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Date of Birthday</label>
                                                        <input type="date" name="dob" class="form-control" placeholder="Date of Birth" required />
                                                    </div>
                                                    <label for="imageUpload">Profile Images</label>
                                                    <div class="file-upload">
                                                        <input type="file" name="image" required>
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
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script>
        document.getElementById('icInput').addEventListener('input', function(e) {
            let icNumber = e.target.value.replace(/\D/g, ''); // Remove non-numeric characters
            if (icNumber.length > 6) {
                icNumber = icNumber.slice(0, 6) + '-' + icNumber.slice(6);
            }
            if (icNumber.length > 9) {
                icNumber = icNumber.slice(0, 9) + '-' + icNumber.slice(9);
            }
            e.target.value = icNumber;
        });
    </script>


</body>