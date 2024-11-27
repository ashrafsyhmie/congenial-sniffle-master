<?php


session_start();
$admin_id = $_SESSION['admin_id'];
$admin_name = $_SESSION['admin_name'];

require_once "../../db conn.php";


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

  <title>View All Appointments</title>

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

      <li class="nav-item ml-1">
        <a class="nav-link" href="../manage doctor/view all doctors.php">
          <i class="fa-solid fa-stethoscope"></i>
          <span>View All Doctors</span></a>
      </li>

      <li class="nav-item ml-1">
        <a class="nav-link" href="../manage patient/view all patient.php ">
          <i class="fa-regular fa-user"></i>
          <span>View All Patients</span></a>
      </li>

      <li class="nav-item active ml-1">
        <a class="nav-link" href="./view all appointment.php">
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
          ?>

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-900 font-weight-bolder">
              View Appointment Record
            </h1>
            <!-- Add New patient Button -->
            <a href="./new appointment.php" class="btn btn-primary mb-2">
              <i class="fa fa-plus mr-1"></i> Add New Appointment
            </a>
          </div>

          <!-- All Appointment table -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
              <!-- Heading on the left -->
              <h6 class="m-0 font-weight-bold text-primary">Appointment Record</h6>

              <!-- Filter Form on the right -->
              <div class="filter-form">
                <form method="GET" action="" class="form-inline">
                  <label for="filter" class="mr-2">Show:</label>
                  <select name="filter" id="filter" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                    <option value="all" <?php if (isset($_GET['filter']) && $_GET['filter'] == 'all') echo 'selected'; ?>>All</option>
                    <option value="upcoming" <?php if (isset($_GET['filter']) && $_GET['filter'] == 'upcoming') echo 'selected'; ?>>Upcoming</option>
                    <option value="done" <?php if (isset($_GET['filter']) && $_GET['filter'] == 'done') echo 'selected'; ?>>Done</option>
                    <option value="cancelled" <?php if (isset($_GET['filter']) && $_GET['filter'] == 'cancelled') echo 'selected'; ?>>Cancelled</option>
                  </select>
                  <noscript><button type="submit" class="btn btn-primary btn-sm">Apply</button></noscript> <!-- fallback for non-JS -->
                </form>
              </div>
            </div>




            <div class="table-responsive">
              <table class="table table-striped table-border-0 text-center" id="dataTable" width="100%" cellspacing="0">
                <thead class="text-center">
                  <tr>
                    <th>App. ID</th>
                    <th>Doctor Name</th>
                    <th>Patient Name</th>
                    <th>Date & Time</th>
                    <th>Appointment Action</th>
                    <th>Medical Record Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  // Get the filter selection (default to 'all' if not set)
                  $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

                  // Prepare the SQL query with the filter applied
                  $sql = "SELECT 
    appointment.appointment_id,
    appointment.date,
    appointment.timeslot,
    appointment.status,
    patient.patient_id,
    patient.patient_name,
    patient.patient_photo,
    doctor.doctor_id,
    doctor.doctor_name,
    doctor.doctor_photo,
    medical_record.medical_record_id
FROM 
    appointment
JOIN 
    patient ON appointment.patient_id = patient.patient_id
JOIN 
    doctor ON appointment.doctor_id = doctor.doctor_id
LEFT JOIN 
    medical_record ON appointment.appointment_id = medical_record.appointment_id

";

                  // Apply the filter to the SQL query
                  if ($filter == 'upcoming') {
                    $sql .= " WHERE appointment.status = 'upcoming'";
                  } elseif ($filter == 'done') {
                    $sql .= " WHERE appointment.status = 'done'";
                  } elseif ($filter == 'cancelled') {
                    $sql .= " WHERE appointment.status = 'cancelled'";
                  }

                  $sql .= " ORDER BY appointment.appointment_id ASC";

                  $result = $conn->query($sql);

                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                      echo "<tr>";
                      echo "<td>" . htmlspecialchars($row['appointment_id']) . "</td>";
                      echo '<td class="text-center">
                                    <div class="doctor-info">
                                        <img src="data:image/jpeg;base64,' . base64_encode($row['doctor_photo']) . '" alt="Doctor photo" class="doctor-photo">
                                        <div class="doctor-name">' . htmlspecialchars($row['doctor_name']) . '</div>
                                    </div>
                                  </td>';
                      echo '<td class="text-center">
                                  <div class="patient-info">
                                      <img src="data:image/jpeg;base64,' . base64_encode($row['patient_photo']) . '" alt="Patient photo" class="patient-photo">
                                      <div class="patient-details">' . htmlspecialchars($row['patient_name']) . '</div>
                                  </div>
                                </td>';

                      echo "<td>" . htmlspecialchars($row['date']) . "<br>" . htmlspecialchars($row['timeslot']) . "<br><br>";

                      // Appointment status
                      if ($row['status'] == 'done') {
                        echo '<span class="status-done">Done</span></td>';
                        echo '<td class="text-center">Appointment has been done. <br>Appointment ID: ' . $row['appointment_id'] . '</td>';
                      } elseif ($row['status'] == 'cancelled') {
                        echo "<span class='status-canceled'>Cancelled</span></td>";
                        echo '<td class="text-center">Appointment has been cancelled. <br>Appointment ID: ' . $row['appointment_id'] . '</td>';
                      } elseif ($row['status'] == 'upcoming') {
                        echo "<span class='status-upcoming'>Upcoming</span></td>";
                        echo '<td class="text-center">
                                        <a href="#" class="btn btn-info btn-md mr-3" data-toggle="modal" data-target="#rescheduleAppModal' .  $row['appointment_id'] . '">
                                            <i class="fa-regular fa-calendar"></i>
                                        </a>
                                        <a href="#" class="btn btn-danger btn-md" data-toggle="modal" data-target="#cancelAppModal' .  $row['appointment_id'] . '">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                        <br><br> Appointment ID: ' . $row['appointment_id'] . '
                                    </td>';
                      }

                      // Medical record action buttons
                      if (isset($row['medical_record_id'])) {
                        echo "<td class='text-center'>
                                        <a href='../medical record/edit medical record.php?medical_record_id=" . $row['medical_record_id'] . "' class='btn btn-success btn-md mr-3'>
                                            <i class='fa fa-edit'></i>
                                        </a>
                                        <a href='../medical record/view medical record.php?medical_record_id=" . $row['medical_record_id'] . "' class='btn btn-primary btn-md'>
                                            <i class='fa-solid fa-eye'></i>
                                        </a><br><br> Medical Record ID: " . $row['medical_record_id'] . "
                                      </td>";
                      } elseif ($row['status'] == 'done') {
                        echo "<td class='text-center'>
                                        <a href='../medical record/medical history form.php?appointment_id=" . $row['appointment_id'] . "' class='btn btn-primary btn-md mr-3'>
                                            <i class='fa fa-plus mr-1'></i> Add Record
                                        </a>
                                      </td>";
                      } else {
                        echo "<td class='text-center'>No medical record</td>";
                      }

                      echo "</tr>";

                  ?>

                      <!-- Cancel appointment modal -->
                      <div class="modal fade" id="cancelAppModal<?php echo $row['appointment_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                              <form action="../manage appointment/cancel appointment.php" method="POST">
                                <input type="hidden" name="appointment_id" value="<?php echo $row['appointment_id']; ?>">
                                <button type="submit" class="btn btn-primary">Yes</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Reschedule modal -->
                      <div class="modal fade" id="rescheduleAppModal<?php echo $row['appointment_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                              <form action="../manage appointment/reschedule handler/calendar.php" method="GET">
                                <input type="hidden" name="appointment_id" value="<?php echo $row['appointment_id']; ?>">
                                <button type="submit" class="btn btn-primary">Yes</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                  <?php
                    }
                  } else {
                    echo "<tr><td colspan='6'>No appointments found.</td></tr>";
                  }

                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>

      <

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