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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>View All Doctors</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet" />
</head>

<style>
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
            <li class="nav-item  ml-1">
                <a class="nav-link" href="../homepage.php">
                    <i class="fa-solid fa-house"></i>
                    <span>Home</span></a>
            </li>

            <li class="nav-item active ml-1">
                <a class="nav-link" href="./view all doctors.php">
                    <i class="fa-solid fa-stethoscope"></i>
                    <span>View All Doctors</span></a>
            </li>

            <li class="nav-item ml-1">
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
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
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
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $admin_name  ?></span>
                                <?php
                                echo '<td><img src="data:image/jpeg;base64,' . base64_encode($_SESSION['admin_photo']) . '" alt="Admin photo" class="mini-photo"></td>'
                                ?>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
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
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
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
                    // Database connection
                    require_once "../../db conn.php";

                    // Fetch the patient ID from the URL
                    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

                    // SQL Query to fetch the specific patient's data using the patient ID
                    $sql = "SELECT * FROM doctor WHERE doctor_id = $id";
                    $result = $conn->query($sql);

                    // Check if the query was successful
                    if ($result === false) {
                        die("Error executing query: " . $conn->error);
                    }

                    // Fetch the specific patient data
                    if ($result->num_rows > 0) {
                        $doctor = $result->fetch_assoc();
                    } else {
                        $doctor = null;
                    }
                    ?>

                    <!-- All Doctor table -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Doctor Profile
                            </h6>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-border-0" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="width: 30%;">Doctor Photo</th>
                                            <th style="width: 30%;">Information</th>
                                            <th style="width: 30%;">Address & Contact</th>
                                            <th style="width: 25%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <!-- First Column: doctor Photo -->
                                            <td>
                                                <div class="form-group">
                                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($doctor['doctor_photo']); ?>" alt="Doctor photo" class="doctor-photo">
                                                </div>
                                                <div class="form-group">
                                                    <div><?php echo htmlspecialchars($doctor['specialization']); ?></div>
                                                </div>
                                            </td>

                                            <!-- Second Column: Basic Information -->
                                            <td>
                                                <div class="form-group">
                                                    <div>Name: <?php echo htmlspecialchars($doctor['doctor_name']); ?></div>
                                                </div>
                                                <div class="form-group">
                                                    <div>IC: <?php echo htmlspecialchars($doctor['ic number']); ?></div>
                                                </div>
                                                <div class="form-group">
                                                    <div>Gender: <?php echo htmlspecialchars($doctor['gender']); ?></div>
                                                </div>
                                                <div class="form-group">
                                                    <div>Date of Birth: <?php echo htmlspecialchars($doctor['d_o_b']); ?></div>
                                                </div>
                                            </td>

                                            <!-- Third Column: Address and Contact Information -->
                                            <td>
                                                <div class="form-group">
                                                    <div>Address: <?php echo htmlspecialchars($doctor['address']); ?></div>
                                                </div>
                                                <div class="form-group">
                                                    <div>Contact Number: <?php echo htmlspecialchars($doctor['phone number']); ?></div>
                                                </div>
                                            </td>

                                            <!-- Fourth Column: Edit Button -->
                                            <td>
                                                <div class="form-group">
                                                    <a href="edit doc.php?id=<?php echo htmlspecialchars($doctor['doctor_id']); ?>" class="btn btn-success btn-sm">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="send email doc.php?id=<?php echo htmlspecialchars($doctor['doctor_id']); ?>" class="btn btn-primary btn-sm">
                                                        <i class="fa-regular fa-envelope"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Display Patient Profile -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                All Appointments </h6>
                        </div>

                        <div class="card-body">

                            <div class="table-responsive">
                                <table
                                    class="table table-bordered text-center"
                                    id="dataTable"
                                    width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Appointment ID</th>
                                            <th>Photo</th>
                                            <th>Name</th>
                                            <th>Date & Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $doctor_id = $_GET['id'];

                                        $sql = "SELECT * FROM appointment 
                                    JOIN doctor ON appointment.doctor_id = doctor.doctor_id 
                                    WHERE doctor.doctor_id = $doctor_id";

                                        //  AND status = 'upcoming'
                                        $result = mysqli_query($conn, $sql);

                                        while ($row = mysqli_fetch_assoc($result)) {

                                            //   $doctor_id = $row['doctor_id'];
                                            //   $sql2 = "SELECT * FROM `doctor` WHERE `doctor_id` = '$doctor_id'";
                                            //   $result2 = mysqli_query($connection, $sql2);
                                            //   $row2 = mysqli_fetch_assoc($result2);

                                            //   $doctor_name = $row2['doctor_name'];

                                            echo "<tr>";
                                            echo "<td>" . $row['appointment_id'] . "</td>";
                                            echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['doctor_photo']) . '" alt="Doctor photo" class = "doctor-photo"></td>';

                                            echo "<td>" . $row['doctor_name'] . "</td>";
                                            echo "<td>" . $row['date'] . "<br>";
                                            echo   $row['timeslot'] . "<br><br>";



                                            if ($row['status'] == 'done') {
                                                echo '<span class="status-done">Done</span></td>';
                                            } elseif ($row['status'] == 'cancelled') {
                                                echo "<span class='status-canceled'>Cancelled</span></td>";
                                            } elseif ($row['status'] == 'upcoming') {
                                                echo "<span class='status-upcoming'>Upcoming</span></td>";
                                            }
                                            echo "</tr>";
                                        }



                                        ?>
                                    </tbody>
                                </table>
                            </div>


                        </div>

                    </div>
                </div>
                <!-- End of Doctor Table -->
                <form action="doctor_profile.php" method="post">
                    <div class="d-flex justify-content-center">
                        <div class="mr-2">
                            <!-- Back Button -->
                            <?php

                            if (!empty($doctor)) {
                                echo '<a href="view all doctors.php?id=' . htmlspecialchars($doctor['doctor_id']) . '">
            <button type="button" class="btn btn-primary mb-2">
                <i class="fa-solid fa-chevron-left mr-1"></i> Back
            </button>
            </a>';
                            }
                            ?>
                        </div>
                    </div>
                </form>
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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form action="../logout_modal.php" method="post">
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteDocModal" tabindex="-1" role="dialog" aria-labelledby="deleteDocModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteDocModalLabel">Confirm Delete</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to delete this doctor's account? This action cannot be undone.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a id="deleteConfirmButton" class="btn btn-danger" href="#">Delete</a>
                </div>
            </div>
        </div>
    </div>

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
        document.addEventListener('DOMContentLoaded', function() {
            // Get the modal element
            var deleteDocModal = document.getElementById('deleteDocModal');
            var deleteConfirmButton = document.getElementById('deleteConfirmButton');

            // Set up the event listener for the delete button
            document.querySelectorAll('.btn-delete').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    var deleteUrl = this.getAttribute('href');
                    deleteConfirmButton.setAttribute('href', deleteUrl);
                    $(deleteDocModal).modal('show');
                });
            });
        });
    </script>


</body>

</html>