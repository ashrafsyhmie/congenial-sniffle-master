<?php

session_start();

require_once("db conn.php");

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
            class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-900 font-weight-bolder">
              All Appointment
            </h1>
          </div>

          <!-- All Appointment table -->
          <!-- <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                List of All Appointments
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table
                  class="table table-striped table-border-0"
                  id="dataTable"
                  width="100%"
                  cellspacing="0">
                  <thead>
                    <td></td>
                    <td>Name</td>
                    <td>Date and Time</td>
                    <td></td>
                    <td></td>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Photo</td>
                      <td>
                        Doctor 1
                        <br />
                        Cardiologist
                      </td>
                      <td>
                        9:30 am
                        <br />
                        27/1/2025
                      </td>
                      <td>
                        <button
                          type="button"
                          class="btn btn-secondary"
                          data-toggle="modal"
                          data-target="#cancelAppModal">
                          Cancel
                        </button>
                      </td>
                      <td>
                        <button
                          type="button"
                          class="btn btn-primary"
                          data-toggle="modal"
                          data-target="#RescheduleAppModal">
                          Reschedule
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td>Photo</td>
                      <td>
                        Doctor 2
                        <br />
                        Psychiatrist
                      </td>
                      <td>
                        10:30 am
                        <br />
                        28/1/2025
                      </td>
                      <td>
                        <button
                          type="button"
                          class="btn btn-secondary"
                          data-toggle="modal"
                          data-target="#cancelAppModal">
                          Cancel
                        </button>
                      </td>
                      <td>
                        <button
                          type="button"
                          class="btn btn-primary"
                          data-toggle="modal"
                          data-target="#RescheduleAppModal">
                          Reschedule
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td>Photo</td>
                      <td>
                        Doctor 3
                        <br />
                        Neurosurgeon
                      </td>
                      <td>
                        11:30 am
                        <br />
                        29/1/2025
                      </td>
                      <td>
                        <button
                          type="button"
                          class="btn btn-secondary"
                          data-toggle="modal"
                          data-target="#cancelAppModal">
                          Cancel
                        </button>
                      </td>
                      <td>
                        <button
                          type="button"
                          class="btn btn-primary"
                          data-toggle="modal"
                          data-target="#RescheduleAppModal">
                          Reschedule
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div> -->

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                Upcoming Appointment
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table
                  class="table table-bordered"
                  id="dataTable"
                  width="100%"
                  cellspacing="0">
                  <thead>
                    <tr>
                      <th>Appointment ID</th>
                      <th>Photo</th>
                      <th>Name</th>
                      <th>Date </th>
                      <th>Time</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php







                    $sql = "SELECT * FROM appointment JOIN doctor on appointment.doctor_id=doctor.doctor_id  WHERE patient_id = $patient_id AND status = 'upcoming'";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {

                      //   $doctor_id = $row['doctor_id'];
                      //   $sql2 = "SELECT * FROM `doctor` WHERE `doctor_id` = '$doctor_id'";
                      //   $result2 = mysqli_query($connection, $sql2);
                      //   $row2 = mysqli_fetch_assoc($result2);

                      //   $doctor_name = $row2['doctor_name'];

                      echo "<tr>";
                      echo "<td>" . $row['appointment_id'] . "</td>";
                      echo '<td><img src="' . $row["doctor_photo"] . '" alt="Doctor Photo" width="50" height="50"></td>';
                      echo "<td>" . $row['doctor_name'] . "</td>";
                      echo "<td>" . $row['date'] . "</td>";
                      echo "<td>" . $row['timeslot'] .  "</td>";
                      echo "</tr>";
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

  <!-- Cancel Appointment Modal -->
  <div
    class="modal fade"
    id="cancelAppModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            Do You Want to Cancel Appointment?
          </h5>
          <button
            class="close"
            type="button"
            data-dismiss="modal"
            aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          Select "Yes" below if you want to cancel this appointment.
        </div>
        <div class="modal-footer">
          <button
            class="btn btn-secondary"
            type="button"
            data-dismiss="modal">
            No
          </button>
          <a class="btn btn-primary" href="#">Yes</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Reschedule Appointment Modal -->
  <div
    class="modal fade"
    id="RescheduleAppModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            Do You Want to reschedule this appointment?
          </h5>
          <button
            class="close"
            type="button"
            data-dismiss="modal"
            aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          Select "Yes" below if you want to reschedule this appointment.
        </div>
        <div class="modal-footer">
          <button
            class="btn btn-secondary"
            type="button"
            data-dismiss="modal">
            No
          </button>
          <a class="btn btn-primary" href="./appointment handler/calendar.php">Yes</a>
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
</body>

</html>