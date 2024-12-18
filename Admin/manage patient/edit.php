<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../../db conn.php';

// Initialize variables
$id = $Pt_name = $Address = $Email = $gender = $Num_Phone = $emergency = $dob = $ic = $successmsg = $errorMsg = "";

// Function to fetch patient data
function getPatientData($conn, $id)
{
    $sql = "SELECT * FROM patient WHERE patient_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// GET Request - Fetch patient data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'] ?? '';

    if (empty($id)) {
        header("Location: /Admin/Admin/patient_profile.php");
        exit;
    }

    $row = getPatientData($conn, $id);

    if (!$row) {
        header("Location: /Admin/Admin/patient_profile.php");
        exit;
    }

    // Populate fields
    $Pt_name = $row["patient_name"];
    $Address = $row["address"];
    $Email = $row["email"];
    $gender = $row["gender"];
    $Num_Phone = $row["phone number"];
    $emergency = $row["emerg_num"];
    $dob = $row["d_o_b"];
    $ic = $row["ic number"];
    $image = $row["patient_photo"];
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $Pt_name = $_POST['txtName'];
    $Address = $_POST['add'];
    $Email = $_POST['email'];
    $gender = $_POST['sex'];
    $Num_Phone = $_POST['number'];
    $dob = $_POST['dob'];
    $emergency = $_POST['emergency_number'];
    $ic = $_POST['ic_num'];

    // Handle file upload

    if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] == UPLOAD_ERR_OK) {
        $imageData = file_get_contents($_FILES['imageUpload']['tmp_name']);
    }
    //  else {
    //     $imageData = $image;
    // }

    // Prepare and execute update query
    $sql = "UPDATE patient SET 
            patient_name = ?, 
            `ic number` = ?, 
            address = ?, 
            email = ?, 
            `phone number` = ?, 
            gender = ?, 
            emerg_num = ?, 
            d_o_b = ?, 
            patient_photo = ? 
        WHERE patient_id = ?";

    // $sql = "UPDATE patient SET image = ? where patient_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssi", $Pt_name, $ic, $Address, $Email, $Num_Phone, $gender, $emergency, $dob, $imageData, $id);

    // $stmt->bind_param("si", $imageData, $id);
    // Execute the query
    if ($stmt->execute()) {
        $successmsg = "Patient information updated successfully.";
    } else {
        $errorMsg = "Error updating patient information: " . $conn->error;
    }

    // Close the statement after use
    $stmt->close();
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

    <title>Edit Patient</title>

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
                <a class="nav-link" href="../manage doctor/view all doctors.php ">
                    <i class="fa-solid fa-stethoscope"></i>
                    <span>View All Doctors</span></a>
            </li>

            <li class="nav-item active ml-1">
                <a class="nav-link" href="../manage patient/view all patient.php ">
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
                                <span class="mr-3 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['admin_name']  ?></span>
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
                    <div
                        class="d-sm-flex align-items-center justify-content-center mb-4">
                        <h1 class="h3 mb-2 text-gray-900 font-weight-bolder">
                            Edit Patient Information
                        </h1>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <tbody>
                                    <div class="container-fluid">
                                        <?php if (!empty($successmsg)): ?>
                                            <div class="alert alert-success" role="alert">
                                                <?php echo $successmsg; ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($errorMsg)): ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?php echo $errorMsg; ?>
                                            </div>
                                        <?php endif; ?>

                                        <form method="post" action="./edit.php" enctype="multipart/form-data">
                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

                                            <div class="form-group">
                                                <label for="txtName">Patient Name</label>
                                                <input type="text" class="form-control" id="txtName" name="txtName" value="<?php echo htmlspecialchars($Pt_name); ?>">
                                            </div>


                                            <div class="form-group">
                                                <label for="">IC Number</label>
                                                <br>
                                                <small>Format: XXXXXX-XX-XXXX</small>
                                                <input type="text" id="icInput" name="ic_num" class="form-control" placeholder="IC Number" maxlength="14" value="<?php echo htmlspecialchars($ic); ?>" required />
                                            </div>

                                            <div class="form-group">
                                                <label for="add">Address</label>
                                                <input type="text" class="form-control" id="add" name="add" value="<?php echo htmlspecialchars($Address); ?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($Email); ?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="sex">Gender</label>
                                                <select class="form-control" id="sex" name="sex">
                                                    <option value="Male" <?php echo $gender == 'Male' ? 'selected' : ''; ?>>Male</option>
                                                    <option value="Female" <?php echo $gender == 'Female' ? 'selected' : ''; ?>>Female</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Contact Number</label>
                                                <br>
                                                <small>Format: XXXXXX-XX-XXXX</small>
                                                <input type="text" name="number" class="form-control" id="number" placeholder="Contact number" value="<?php echo htmlspecialchars($Num_Phone); ?>" required maxlength="13" />
                                            </div>

                                            <div class="form-group">
                                                <label for="">Emergency Number</label>
                                                <br>
                                                <small>Format: XXXXXX-XX-XXXX</small>
                                                <input type="text" name="emergency_number" class="form-control" id="emergency_number" placeholder="Emergency number" value="<?php echo htmlspecialchars($emergency); ?>" required maxlength="13" />
                                            </div>

                                            <div class="form-group">
                                                <label for="dob">Date of Birth</label>
                                                <input type="date" class="form-control" id="dob" name="dob" value="<?php echo htmlspecialchars($dob); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="image">Image</label>
                                                <br>
                                                <?php
                                                if (!empty($imageData)) {
                                                    echo '<img src="data:image/jpeg;base64,' . base64_encode($imageData) . '" alt="Image" class="article-image">';
                                                } else {
                                                    echo '<img src="placeholder-image.jpg" alt="Image" class="article-image">'; // Use a placeholder image if no image is available
                                                }
                                                ?>
                                                <input type="file" name="imageUpload" id="imageUpload">
                                            </div>

                                            <div class="d-flex justify-content-center">
                                                <div class="mr-2">
                                                    <?php
                                                    //                                                     echo '<a href="patient_profile.php?id=' . htmlspecialchars($row['patient_id']) . '">
                                                    //     <button type="button" class="btn btn-primary mb-2">
                                                    //         <i class="fa-solid fa-chevron-left mr-1"></i> Back
                                                    //     </button>
                                                    // </a>';
                                                    ?>
                                                </div>
                                                <div>
                                                    <a href="./view all patient.php" class="btn btn-primary">Back</a>
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

</body>

</html>