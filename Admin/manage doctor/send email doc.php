<?php
require_once "../../db conn.php";
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$doctor_id = isset($_GET['id']) ? $_GET['id'] : '';

function fetchAllAdminInfo($conn)
{
    global $admin_id;
    $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_id = ?");
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $adminInfo = array();

    while ($row = $result->fetch_assoc()) {
        $adminInfo[] = $row;
    }

    $stmt->close();
    return $adminInfo;
}

$allAdminInfo = fetchAllAdminInfo($conn);

foreach ($allAdminInfo as $admin) {
    $_SESSION['admin_name'] = $admin['admin_name'];
    $_SESSION['admin_photo'] = $admin['admin_photo'];
}

$admin_name = htmlspecialchars($_SESSION['admin_name']);
$admin_photo = $_SESSION['admin_photo'];

function fetchAllDoctorInfo($conn)
{
    global $doctor_id;
    $stmt = $conn->prepare("SELECT * FROM doctor WHERE doctor_id = ?");
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $doctorInfo = array();

    while ($row = $result->fetch_assoc()) {
        $doctorInfo[] = $row;
    }

    $stmt->close();
    return $doctorInfo;
}

$allDoctorInfo = fetchAllDoctorInfo($conn);

foreach ($allDoctorInfo as $doctor) {
    $_SESSION['doctor_name'] = htmlspecialchars($doctor['doctor_name']);
    $_SESSION['doctor_photo'] = $doctor['doctor_photo'];
    $_SESSION['doctor_email'] = htmlspecialchars($doctor['email']);
}

// Continue with the HTML structure...
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

    <title>View All Patient</title>

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

    <!-- <link rel="stylesheet" href="./style.css"> -->

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet" />

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

        .email-composer {

            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 10px 0 5px;
            color: #555;
        }

        input,
        textarea {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            margin-bottom: 15px;
            width: 100%;
        }



        textarea {
            height: 150px;
            resize: none;
        }

        .actions {
            display: flex;
            justify-content: space-between;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .send-btn {
            background-color: #28a745;
            color: #fff;
        }

        .discard-btn {
            background-color: #dc3545;
            color: #fff;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            max-width: 400px;
            margin: auto;
        }

        .close-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .patient-photo {
            width: 98px;
            /* set the width */
            height: 98px;
            /* set the height */
            object-fit: cover;
            /* to maintain the aspect ratio and cover the area */
            border-radius: 50%;
            /* for a circular shape */
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)
        }

        .doctor-photo {
            width: 98px;
            /* set the width */
            height: 98px;
            /* set the height */
            object-fit: cover;
            /* to maintain the aspect ratio and cover the area */
            border-radius: 50%;
            /* for a circular shape */
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)
        }


        .pagination-container {
            text-align: center;
            margin-top: 15px;
        }

        .pagination-container a {
            color: #007bff;
            font-size: 15px;
            padding: 8px 10px;
            text-decoration: none;
            border-radius: 4px;
            border: 1px solid #007bff;
            margin: 0 5px;
        }

        .pagination-container a:hover {
            background-color: #007bff;
            color: white;
        }

        .page-number {
            font-size: 15px;
            padding: 8px 16px;
            border-radius: 4px;
            border: 1px solid #007bff;
            margin: 0 5px;
        }

        .status-done {
            background-color: green;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            display: inline-block;
        }

        .status-canceled {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            display: inline-block;
        }

        .status-upcoming {
            background-color: orange;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            display: inline-block;
        }
    </style>
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
                <a class="nav-link" href="../manage doctor/view all doctors.php">
                    <i class="fa-solid fa-stethoscope"></i>
                    <span>View All Doctors</span></a>
            </li>

            <li class="nav-item  ml-1">
                <a class="nav-link" href="../manage patient/view all patient.php ">
                    <i class="fa-regular fa-user"></i>
                    <span>View All Patients</span></a>
            </li>

            <li class="nav-item  ml-1">
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
                                echo '<td><img src="data:image/jpeg;base64,' . base64_encode($admin['admin_photo']) . '" alt="Admin photo" class="mini-photo"></td>'
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-900 font-weight-bolder">
                            Send Email to Doctor
                        </h1>

                    </div>
                    <div class="email-composer">
                        <h2>Compose Email</h2>
                        <form action="./email handler.php" method="post">
                            <label for="to">To</label>
                            <input type="text" id="recipients" name="recipients" placeholder="Recipient email" value="<?php echo $doctor['doctor_name'] ?>" readonly class="form-control" />
                            <input type="email" hidden name="recipients_email" value="<?php echo $doctor['email'] ?>">
                            <input type="text" hidden name="doctor_id" value="<?php echo $doctor_id ?>">

                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" placeholder="Email subject" required />

                            <label for="body">Message</label>
                            <textarea id="body" name="body" placeholder="Write your message..." required></textarea>

                            <div class="actions">

                                <button type="reset" class="btn btn-danger">
                                    <i class="fa-solid fa-xmark"></i>
                                    Discard</button>
                                <a href="../manage doctor/doctor_profile.php?id=<?php echo $doctor_id ?>">
                                    <button type="button" class="btn btn-primary">
                                        Back
                                    </button>
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    Send</button>
                            </div>
                        </form>
                    </div>

                    <!-- Custom Modal Popup -->
                    <div id="emailSentModal" class="modal">
                        <div class="modal-content">
                            <h3>Email Sent!</h3>
                            <p>Your email has been sent successfully.</p>
                            <button id="closeModal" class="close-btn">Close</button>
                        </div>
                    </div>
                </div>



                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

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
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('status') === 'sent') {
                // Show the modal when email is sent
                document.getElementById('emailSentModal').style.display = 'flex';
            }

            // Close the modal when the user clicks the button
            document.getElementById('closeModal').onclick = function() {
                document.getElementById('emailSentModal').style.display = 'none';
            };
        };
    </script>
</body>

</html>