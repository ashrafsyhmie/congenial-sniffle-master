<?php

session_start();
$admin_id = $_SESSION['admin_id'];
$admin_name = $_SESSION['admin_name'];

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

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet" />
</head>
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
                <a class="nav-link" href="../manage doctor/view all doctors.php ">
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

                    <?php
                    // Display success or error message
                    if (isset($_GET['message'])) {
                        $messageType = $_GET['message_type'] == 'success' ? 'alert-success' : 'alert-danger';
                        echo '<div class="alert ' . $messageType . '">';
                        echo '<strong>' . htmlspecialchars($_GET['message']) . '</strong>';
                        echo '</div>';
                    }

                    // Database connection
                    require_once "../../db conn.php";
                    // Fetch the patient ID from the URL
                    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

                    // SQL Query to fetch the specific patient's data using the patient ID
                    $sql = "SELECT * FROM patient WHERE patient_id = $id";
                    $result = $conn->query($sql);

                    // Check if the query was successful
                    if ($result === false) {
                        die("Error executing query: " . $conn->error);
                    }

                    // Fetch the specific patient data
                    if ($result->num_rows > 0) {
                        $patient = $result->fetch_assoc();
                    } else {
                        $patient = null;
                    }
                    ?>

                    <!-- Display Patient Profile -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Patient Profile
                            </h6>
                        </div>

                        <div class="card-body">
                            <table class="table table-striped table-border-0" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="width: 30%;">Patient Photo</th>
                                        <th style="width: 30%;">Information</th>
                                        <th style="width: 30%;">Address & Contact</th>
                                        <th style="width: 25%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <!-- First Column: Patient Photo -->
                                        <td>
                                            <div class="form-group">
                                                <img src="data:image/jpeg;base64,<?php echo base64_encode($patient['patient_photo']); ?>" alt="Patient photo" class="patient-photo" style="max-width: 100%; height: auto;">
                                            </div>
                                        </td>

                                        <!-- Second Column: Basic Information -->
                                        <td>
                                            <div class="form-group">
                                                <div>Name: <?php echo htmlspecialchars($patient['patient_name']); ?></div>
                                            </div>
                                            <div class="form-group">
                                                <div>IC: <?php echo htmlspecialchars($patient['ic number']); ?></div>
                                            </div>
                                            <div class="form-group">
                                                <div>Gender: <?php echo htmlspecialchars($patient['gender']); ?></div>
                                            </div>
                                            <div class="form-group">
                                                <div>Date of Birth: <?php echo htmlspecialchars($patient['d_o_b']); ?></div>
                                            </div>
                                        </td>

                                        <!-- Third Column: Address and Contact Information -->
                                        <td>
                                            <div class="form-group">
                                                <div>Address: <?php echo htmlspecialchars($patient['address']); ?></div>
                                            </div>
                                            <div class="form-group">
                                                <div>Contact Number: <?php echo htmlspecialchars($patient['phone number']); ?></div>
                                            </div>
                                            <div class="form-group">
                                                <div>Emergency Number: <?php echo htmlspecialchars($patient['emerg_num']); ?></div>
                                            </div>
                                        </td>

                                        <!-- Fourth Column: Edit Button -->
                                        <td>
                                            <div class="form-group">
                                                <a href="edit.php?id=<?php echo htmlspecialchars($patient['patient_id']); ?>" class="btn btn-success btn-sm">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="send email patient.php?id=<?php echo htmlspecialchars($patient['patient_id']); ?>" class="btn btn-primary btn-sm">
                                                    <i class="fa-regular fa-envelope"></i>
                                                </a>
                                            </div>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Display Patient appointment -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                All Appointments </h6>
                        </div>

                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Dr. Photo</th>
                                            <th>Name</th>
                                            <th>Date</th>
                                            <th>Appointment Action</th>
                                            <th>Medical Record Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $patient_id = $_GET['id'];

                                        $sql = "SELECT appointment.*, patient.patient_name, doctor.doctor_name, doctor.doctor_photo, medical_record.medical_record_id 
                                        FROM appointment 
                                        JOIN patient ON appointment.patient_id = patient.patient_id 
                                        JOIN doctor ON appointment.doctor_id = doctor.doctor_id
                                        LEFT JOIN medical_record ON appointment.appointment_id = medical_record.appointment_id
                                        WHERE appointment.patient_id = $patient_id";

                                        $result = mysqli_query($conn, $sql);

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $appointment_id = $row['appointment_id'];

                                            // Display appointment data
                                            echo "<tr class='text-center'>";

                                            echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['doctor_photo']) . '" alt="Doctor photo" class="patient-photo"></td>';
                                            echo "<td>" . $row['doctor_name'] . "</td>";
                                            echo "<td class='text-center'>" . $row['date'] . '<br>' . $row['timeslot'] . '<br><br>';


                                            // Appointment status
                                            if ($row['status'] == 'done') {
                                                echo '<span class="status-done">Done</span></td>';
                                                echo '<td class="text-center">Appointment ID: ' . $row['appointment_id'] . '</td>';
                                            } elseif ($row['status'] == 'cancelled') {
                                                echo "<span class='status-canceled'>Cancelled</span></td>";
                                                echo '<td class="text-center">Appointment ID: ' . $row['appointment_id'] . '</td>';
                                            } elseif ($row['status'] == 'upcoming') {
                                                echo "<span class='status-upcoming'>Upcoming</span></td>";
                                                echo '<td class="text-center">
                                                        <a href="#" class="btn btn-info btn-md mr-3" data-toggle="modal" data-target="#rescheduleAppModal' .  $row['appointment_id'] . '">
                                                            <i class="fa-regular fa-calendar"></i>
                                                        </a>
                                                        <!-- Each appointment has its own Cancel button and modal -->
                                                        <a href="#" class="btn btn-danger btn-md"  data-toggle="modal" data-target="#cancelAppModal' .  $row['appointment_id'] . '">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                        <p></p>
                                                        <p>Appointment ID: ' . $row['appointment_id'] . ' </p>
                                                    </td>';
                                            }

                                            // Appointment action buttons

                                            if (isset($row['medical_record_id'])) {
                                                // Medical record action buttons
                                                echo "<td class='text-center'><a href='../medical record/edit medical record.php?medical_record_id=" . $row['medical_record_id'] . "'class='btn btn-success btn-md mr-3'> 
                                                         <i class='fa fa-edit'></i></a>";
                                                echo "<a href='../medical record/view medical record.php?medical_record_id=" . $row['medical_record_id'] . "'  class='btn btn-primary btn-md'><i class='fa-solid fa-eye'></i></a><p></p> Medical Record ID: " . $row['medical_record_id'] . "</td>";
                                            } elseif ($row['status'] == 'done') {
                                                echo "<td class='text-center'><a style = 'width: 100px;' href='../medical record/medical history form.php?appointment_id=" . $row['appointment_id'] . "' class='btn btn-primary btn-md mr-3'> 
                                                            <i class='fa fa-plus mr-1'></i></a></td>";
                                            } else {
                                                echo "<td class='text-center' width=20%>No medical record</td>";
                                            }
                                            echo "</tr>";
                                        ?>

                                            <!-- Cancel appointment modal -->
                                            <div class="modal fade" id="cancelAppModal<?php echo $appointment_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Do You Want to Cancel Appointment?</h5>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Select "Yes" below if you want to cancel this appointment.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                                                            <!-- Form with appointment_id -->
                                                            <form action="../manage appointment/cancel appointment.php" method="POST">
                                                                <input type="hidden" name="appointment_id" value="<?php echo $row['appointment_id']; ?>">
                                                                <button type="submit" class="btn btn-primary">Yes</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Reschedule modal -->
                                            <div class="modal fade" id="rescheduleAppModal<?php echo $appointment_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Reschedule Appointment</h5>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Do you want to reschedule this appointment?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                            <!-- Reschedule form -->
                                                            <form action="../manage appointment/reschedule handler/calendar.php" method="GET">
                                                                <input type="hidden" name="appointment_id" value="<?php echo $row['appointment_id']; ?>">
                                                                <button type="submit" class="btn btn-primary">Yes</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Close the connection -->
                                            <?php
                                        };
                                        $conn->close(); ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>


                    </div>



                </div>

                <div class="d-flex justify-content-center">
                    <div class="mr-2">
                        <a href="view all patient.php">
                            <button type="button" class="btn btn-primary mb-2">
                                <i class="fa-solid fa-chevron-left mr-1"></i> Back
                            </button>
                        </a>


                    </div>
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