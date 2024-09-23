<?php

session_start();
$admin_id = $_SESSION['admin_id'];
$admin_name = $_SESSION['admin_name'];

require_once "../../db conn.php";

// Initialize variables
$id = "";
$Pt_name = "";
$Address = "";
$Email = "";
$gender = "";
$Num_Phone = "";
$emergency = "";
$dob = "";
$ic = "";
$specialization = "";
$imageData = "";

$successmsg = "";
$errorMsg = "";



// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: /Admin/Admin/view all doctors.php");
        exit;
    }

    $id = $_GET['id'];

    // Prepare and execute query
    $sql = "SELECT * FROM doctor WHERE doctor_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Check if doctor exists
    if (!$row) {
        header("Location: /Admin/Admin/view all doctors.php");
        exit;
    }

    $Pt_name = $row["doctor_name"];
    $Address = $row["address"];
    $Email = $row["email"];
    $gender = $row["gender"];
    $Num_Phone = $row["phone number"];
    $dob = $row["d_o_b"];
    $ic = $row['ic number'];
    $specialization = $row['specialization'];
    $imageData = $row['doctor_photo'];
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $Pt_name = $_POST['txtName'];
    $Address = $_POST['add'];
    $Email = $_POST['email'];
    $gender = $_POST['sex'];
    $Num_Phone = $_POST['txtNum'];
    $dob = $_POST['dob'];
    $specialization = $_POST['specialization'];
    $ic = $_POST['ic_num'];



    // Handle file upload
    $imageData = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageType = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        if ($imageType === 'jpg' || $imageType === 'jpeg' || $imageType === 'png') {
            $imageData = file_get_contents($_FILES['image']['tmp_name']);
        } else {
            $errorMsg = "Invalid image file type.";
        }
    } elseif (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $errorMsg = "Error uploading image.";
    }

    // Prepare and execute update query
    $sql = "UPDATE doctor SET 
            name = ?, 
            ic_number = ?, 
            address = ?, 
            email = ?, 
            cont_number = ?, 
            gender = ?, 
            specialization = ?, 
            d_o_b = ?, 
            image = ? 
        WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssi", $Pt_name, $ic, $Address, $Email, $Num_Phone, $gender, $specialization, $dob, $imageData, $id);

    // Execute the query
    if ($stmt->execute()) {
        $successmsg = "Doctor information updated successfully.";
    } else {
        $errorMsg = "Error updating Doctor information: " . $conn->error;
    }

    // Close the statement after use
    $stmt->close();
}

// Close connection
$conn->close();
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

    <title>Edit Doctor</title>

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

            <li class="nav-item active ml-1">
                <a class="nav-link" href="./view all doctors.php ">
                    <i class="fa-solid fa-stethoscope"></i>
                    <span>View All Doctors</span></a>
            </li>

            <li class="nav-item  ml-1">
                <a class="nav-link" href="../manage patient/view all patient.php ">
                    <i class="fa-regular fa-user"></i>
                    <span>View All Patients</span></a>
            </li>

            <li class="nav-item ml-1">
                <a class="nav-link" href="../manage appointment/view all appointment.php ">
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
                    <div
                        class="d-sm-flex align-items-center justify-content-center mb-4">
                        <h1 class="h3 mb-0 text-gray-900 font-weight-bolder">
                            Edit Doctor Information
                        </h1>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <tbody>
                                    <div class="container-fluid">
                                        <?php if ($successmsg): ?>
                                            <div class="alert alert-success" role="alert">
                                                <?php echo $successmsg; ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($errorMsg): ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?php echo $errorMsg; ?>
                                            </div>
                                        <?php endif; ?>

                                        <form method="post" action="edit doc.php" enctype="multipart/form-data">
                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

                                            <div class="form-group">
                                                <label for="txtName">Doctor Name</label>
                                                <input type="text" class="form-control" id="txtName" name="txtName" value="<?php echo htmlspecialchars($Pt_name); ?>" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="ic_num">IC</label>
                                                <input type="text" class="form-control" id="icInput" name="ic_num" value="<?php echo htmlspecialchars($ic); ?>" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="add">Address</label>
                                                <input type="text" class="form-control" id="add" name="add" value="<?php echo htmlspecialchars($Address); ?>" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($Email); ?>" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="sex">Gender</label>
                                                <select class="form-control" id="sex" name="sex" required>
                                                    <option value="Male" <?php echo $gender == 'Male' ? 'selected' : ''; ?>>Male</option>
                                                    <option value="Female" <?php echo $gender == 'Female' ? 'selected' : ''; ?>>Female</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtNum">Phone Number</label>
                                                <input type="text" class="form-control" id="txtNum" name="txtNum" value="<?php echo htmlspecialchars($Num_Phone); ?>" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="dob">Date of Birth</label>
                                                <input type="date" class="form-control" id="dob" name="dob" value="<?php echo htmlspecialchars($dob); ?>" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="specialization">Specialization</label>
                                                <select name="specialization" class="custom-select">
                                                    <option value="specialization">--Select Specialization--</option>
                                                    <option value="Pediatrician" <?php if ($specialization == 'Pediatrician') echo 'selected'; ?>>Pediatrician</option>
                                                    <option value="Dermatologist" <?php if ($specialization == 'Dermatologist') echo 'selected'; ?>>Dermatologist</option>
                                                    <option value="Cardiologist" <?php if ($specialization == 'Cardiologist') echo 'selected'; ?>>Cardiologist</option>
                                                    <option value="Immunologist" <?php if ($specialization == 'Immunologist') echo 'selected'; ?>>Immunologist</option>
                                                    <option value="Orthopedic Surgeon" <?php if ($specialization == 'Orthopedic Surgeon') echo 'selected'; ?>>Orthopedic Surgeon</option>
                                                    <option value="Neurologist" <?php if ($specialization == 'Neurologist') echo 'selected'; ?>>Neurologist</option>
                                                    <option value="Psychiatry" <?php if ($specialization == 'Psychiatry') echo 'selected'; ?>>Psychiatry</option>
                                                </select>
                                            </div>

                                            <div class="file-upload">
                                                <input type="file" name="image" id="image" value="<?php echo htmlspecialchars($imageData); ?>">
                                            </div>
                                        </form>

                                        <form action="doctor_profile.php" method="post">
                                            <div class="d-flex justify-content-center">
                                                <div class="mr-2">
                                                    <?php
                                                    echo '<a href="doctor_profile.php?id=' . htmlspecialchars($row['doctor_id']) . '">
    <button type="button" class="btn btn-primary mb-2">
        <i class="fa-solid fa-chevron-left mr-1"></i> Back
    </button>
</a>';
                                                    ?>
                                                </div>
                                                <div>
                                                    <button type="submit" class="btn btn-primary">Update Info</button>
                                                </div>
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
            e.target.value = icNumber; // Update the input field with the formatted value
        });
    </script>

</body>

</html>