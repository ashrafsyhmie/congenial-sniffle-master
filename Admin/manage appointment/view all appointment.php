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
  <style>
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
          class="nav-link collapsed"
          href="../settings.html"
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
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-900 font-weight-bolder">
              View Appointment Record
            </h1>
            <!-- Add New patient Button -->
            <a href="appointment form.php" class="btn btn-primary mb-2">
              <i class="fa fa-plus mr-1"></i> Add New Appointment
            </a>
          </div>

          <!-- All Appointment table -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                Appointment Record
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
                    <td>Appointment ID</td>
                    <td></td>
                    <td>Doctor Name</td>
                    <td></td>
                    <td>Patient Name</td>
                    <td>Date</td>
                    <td>Time</td>
                    <td>Status</td>

                  </thead>

                  <tbody>
                    <?php

                    $sql = "SELECT * FROM appointment JOIN patient ON appointment.patient_id = patient.patient_id JOIN doctor ON appointment.doctor_id = doctor.doctor_id";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['appointment_id']) . "</td>";
                        echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['doctor_photo']) . '" alt="Patient photo" class="patient-photo"></td>';
                        echo  "<td>" . htmlspecialchars($row['doctor_name']) . "</td>";
                        echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['patient_photo']) . '" alt="Patient photo" class="patient-photo"></td>';
                        echo "<td>" . htmlspecialchars($row['patient_name']) . "<br>" . htmlspecialchars($row['ic number']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['timeslot']) . "</td>";
                        echo '<td>';
                        echo '<a href="patient_profile.php?id=' . htmlspecialchars($row['patient_id']) . '" class="btn btn-primary btn-sm">View</a> ';
                        echo '<a href="delete.php?id=' . htmlspecialchars($row['patient_id']) . '" class="btn btn-danger btn-sm btn-delete" onclick="return confirm(\'Are you sure you want to delete this patient?\');">';
                        echo '<i class="fa fa-trash"></i>';
                        echo '</a>';
                        echo '</td>';
                        echo "</tr>";
                      }
                    } else {
                      echo "<tr><td colspan='4'>No patient found.</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- Pagination Controls -->
        <div class="pagination-container">
          <a href="#" class="previous round">&#8249;</a>
          <span class="page-number">1</span>
          <a href="#" class="next round">&#8250;</a>
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
    document.addEventListener('DOMContentLoaded', function() {
      const rowsPerPage = 5; //number of row per page (kalau nak tukar kat sini tau)
      const table = document.querySelector('#dataTable');
      const rows = table.querySelectorAll('tbody tr');
      const totalRows = rows.length;
      const totalPages = Math.ceil(totalRows / rowsPerPage);
      let currentPage = 1;

      function showPage(page) {
        const start = (page - 1) * rowsPerPage;
        const end = page * rowsPerPage;

        rows.forEach((row, index) => {
          row.style.display = (index >= start && index < end) ? '' : 'none';
        });

        document.querySelector('.page-number').textContent = page;
      }

      function setupPagination() {
        document.querySelector('.previous').addEventListener('click', () => {
          if (currentPage > 1) {
            currentPage--;
            showPage(currentPage);
          }
        });

        document.querySelector('.next').addEventListener('click', () => {
          if (currentPage < totalPages) {
            currentPage++;
            showPage(currentPage);
          }
        });
      }

      showPage(currentPage);
      setupPagination();
    });
  </script>
</body>

</html>