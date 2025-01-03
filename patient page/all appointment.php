<?php

session_start();

require_once("../db conn.php");

$patient_id = $_SESSION['patient_id'];
$patient_name = $_SESSION['patient_name'];

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

  <title>All Appointment</title>

  <!-- Custom fonts for this template-->

  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />

  <link
    href="../vendor/fontawesome-free/css/all.min.css"
    rel="stylesheet"
    type="text/css" />
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet" />

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet" />
</head>

<body id="page-top">
  <style>
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

    .doctor-photo {
      width: 95px;
      /* set the width */
      height: 95px;
      /* set the height */
      object-fit: cover;
      /* to maintain the aspect ratio and cover the area */
      border-radius: 50%;
      /* for a circular shape */
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)
    }

    td {
      text-align: center;
    }

    th {
      text-align: center;
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
        href="index.php">
        <div class="sidebar-brand-icon">
          <img src="../img/svg/logo-only.svg" />
        </div>
        <div class="sidebar-brand-text mx-2">MedAssist</div>
      </a>

      <!-- Nav Item - Dashboard -->
      <li class="nav-item ml-1">
        <a class="nav-link" href="index.php">
          <i class="fa-solid fa-house"></i>
          <span>Home</span></a>
      </li>

      <li class="nav-item ml-1">
        <a class="nav-link" href="new appointment.php">
          <i class="fa-solid fa-plus"></i>
          <span>New Appointment</span></a>
      </li>

      <li class="nav-item active ml-1">
        <a class="nav-link" href="all appointment.php">
          <i class="fa-solid fa-bookmark"></i>
          <span>My Appointment</span></a>
      </li>

      <li class="nav-item ml-1">
        <a class="nav-link" href="medical history.php">
          <i class="fa-solid fa-clock-rotate-left"></i>
          <span>Medical History</span></a>
      </li>

      <li class="nav-item ml-1">
        <a
          class="nav-link collapsed"
          href="settings.php"
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
            <a class="collapse-item" href="change info.php">Change Info</a>
            <div
              class="collapse-item"
              data-toggle="modal"
              data-target="#DeleteAccModal">
              Delete Account
            </div>
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
                <span class="mr-3 d-none d-lg-inline text-gray-600 small"><?php echo $patient_name; ?></span>
                <?php
                echo '<td><img src="data:image/jpeg;base64,' . base64_encode($_SESSION['patient_photo']) . '" alt="Doctor photo" class="mini-photo"></td>'
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
          <div
            class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-900 font-weight-bolder">
              All Appointment
            </h1>
          </div>


          <?php


          // Check if patient_id is set in the session
          $patient_id = isset($_SESSION['patient_id']) ? $_SESSION['patient_id'] : null;

          if (!$patient_id) {
            echo "Patient ID is missing.";
            exit; // Stop execution if patient_id is not found
          }

          // Get the filter selection (default to 'all' if not set)
          $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

          // Prepare the SQL query
          $sql = "SELECT * FROM appointment 
        JOIN doctor ON appointment.doctor_id = doctor.doctor_id 
        WHERE patient_id = $patient_id";

          if ($filter == 'upcoming') {
            $sql .= " AND appointment.status = 'upcoming'";
          } elseif ($filter == 'done') {
            $sql .= " AND appointment.status = 'done'";
          } elseif ($filter == 'cancelled') {
            $sql .= " AND appointment.status = 'cancelled'";
          }

          $result = mysqli_query($conn, $sql);

          ?>

          <div class="card shadow mb-4">
            <div class="card-header d-flex align-items-center justify-content-between py-3">
              <h6 class="m-0 font-weight-bold text-primary">Appointments</h6>

              <!-- Filter Form -->
              <form method="GET" action="" class="form-inline">
                <label for="filter" class="mr-2">Show:</label>
                <select name="filter" id="filter" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                  <option value="all" <?php if ($filter == 'all') echo 'selected'; ?>>All</option>
                  <option value="upcoming" <?php if ($filter == 'upcoming') echo 'selected'; ?>>Upcoming</option>
                  <option value="done" <?php if ($filter == 'done') echo 'selected'; ?>>Done</option>
                  <option value="cancelled" <?php if ($filter == 'cancelled') echo 'selected'; ?>>Cancelled</option>
                </select>
                <noscript><button type="submit" class="btn btn-primary btn-sm">Apply</button></noscript> <!-- fallback for non-JS -->
              </form>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Appointment ID</th>
                      <th>Photo</th>
                      <th>Name</th>
                      <th>Date</th>
                      <th>Time</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_assoc($result)) {
                        $appointment_id = $row['appointment_id'];
                        echo "<tr>";
                        echo "<td>" . $row['appointment_id'] . "</td>";
                        echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['doctor_photo']) . '" alt="Doctor photo" class="doctor-photo"></td>';
                        echo "<td>" . $row['doctor_name'] . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "<td>" . $row['timeslot'] . "</td>";

                        // Check appointment status and display accordingly
                        if ($row['status'] == 'done') {
                          echo '<td><span class="status-done">Done</span></td>';
                        } elseif ($row['status'] == 'cancelled') {
                          echo "<td><span class='status-canceled'>Cancelled</span></td>";
                        } elseif ($row['status'] == 'upcoming') {
                          echo "<td><span class='status-upcoming'>Upcoming</span></td>";
                        }

                        echo "<td>";
                        if ($row['status'] == 'cancelled') {
                          echo "<p>Your appointment is cancelled.</p>";
                        } elseif ($row['status'] == 'done') {
                          echo "<p>Your appointment is done.</p>";
                        } else {
                          echo '<a href="#" class="btn btn-info mr-3 btn-md" data-toggle="modal" data-target="#rescheduleAppModal' . $appointment_id . '">
                                        <i class="fa-regular fa-calendar"></i>
                                      </a>';
                          echo '<a href="#" class="btn btn-danger btn-md" data-toggle="modal" data-target="#cancelAppModal' . $appointment_id . '">
                                        <i class="fa-solid fa-trash"></i>
                                      </a>';
                        }
                        echo "</td>";
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
                                <form action="./cancel appointment.php" method="POST">
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
                                <form action="./reschedule handler/calendar.php" method="GET">
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
                      echo "<tr><td colspan='7'>No appointments found.</td></tr>";
                    }
                    ?>
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
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          Select "Logout" below if you are ready to end your current session.
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <!-- Form for logout -->
          <form action="./logout_modal.php" method="post">
            <button type="submit" class="btn btn-primary">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>



  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="../vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="../js/demo/chart-area-demo.js"></script>
  <script src="../js/demo/chart-pie-demo.js"></script>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</body>

</html>