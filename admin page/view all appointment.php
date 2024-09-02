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
    href="../vendor/fontawesome-free/css/all.min.css"
    rel="stylesheet"
    type="text/css" />
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet" />

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet" />
  <style>
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
        href="index.html">
        <div class="sidebar-brand-icon">
          <img src="../img/svg/logo-only.svg" />
        </div>
        <div class="sidebar-brand-text mx-2">MedAssist</div>
      </a>

      <!-- Nav Item - Dashboard -->
      <li class="nav-item ml-1">
        <a class="nav-link" href="homepage.html">
          <i class="fa-solid fa-house"></i>
          <span>Home</span></a>
      </li>

      <li class="nav-item ml-1">
        <a class="nav-link" href="view all doctors.php">
          <i class="fa-solid fa-stethoscope"></i>
          <span>View All Doctors</span></a>
      </li>

      <li class="nav-item ml-1">
        <a class="nav-link" href="view all patient.php">
          <i class="fa-regular fa-user"></i>
          <span>View All Patients</span></a>
      </li>

      <li class="nav-item active ml-1">
        <a class="nav-link" href="view all appointment.php">
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

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="alertsDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div
                class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">Alerts Center</h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 12, 2019</div>
                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                    $290.29 has been deposited into your account!
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for
                    your account.
                  </div>
                </a>
                <a
                  class="dropdown-item text-center small text-gray-500"
                  href="#">Show All Alerts</a>
              </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="messagesDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
              </a>
              <!-- Dropdown - Messages -->
              <div
                class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">Message Center</h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img
                      class="rounded-circle"
                      src="../img/undraw_profile_1.svg"
                      alt="..." />
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">
                      Hi there! I am wondering if you can help me with a
                      problem I've been having.
                    </div>
                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img
                      class="rounded-circle"
                      src="../img/undraw_profile_2.svg"
                      alt="..." />
                    <div class="status-indicator"></div>
                  </div>
                  <div>
                    <div class="text-truncate">
                      I have the photos that you ordered last month, how would
                      you like them sent to you?
                    </div>
                    <div class="small text-gray-500">Jae Chun · 1d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img
                      class="rounded-circle"
                      src="../img/undraw_profile_3.svg"
                      alt="..." />
                    <div class="status-indicator bg-warning"></div>
                  </div>
                  <div>
                    <div class="text-truncate">
                      Last month's report looks great, I am very happy with
                      the progress so far, keep up the good work!
                    </div>
                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                  </div>
                </a>

                <a
                  class="dropdown-item text-center small text-gray-500"
                  href="#">Read More Messages</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

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
                <span class="mr-3 d-none d-lg-inline text-gray-600 small">User Name</span>
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
                    <td>Doctor</td>
                    <td>Patient Name</td>
                    <td>Date</td>
                    <td>Time</td>
                    <td>Status</td>

                  </thead>

                  <tbody>
                    <tr>
                      <td>01</td>
                      <td>Dr. Ashraf</td>
                      <td>Patient 1</td>
                      <td>13.10.2090</td>
                      <td>13:10</td>
                      <td><span class="status-done">Done</span></td>
                    </tr>
                    <tr>
                      <td>02</td>
                      <td>Dr. Fayya</td>
                      <td>Patient 2</td>
                      <td>12.10.2090</td>
                      <td>14:10</td>
                      <td><span class="status-done">Done</span></td>
                    </tr>
                    <tr>
                      <td>03</td>
                      <td>Dr. Harith</td>
                      <td>Patient 3</td>
                      <td>13.2.2090</td>
                      <td>13:10</td>
                      <td><span class="status-upcoming">Upcoming</span></td>
                    </tr>
                    <tr>
                      <td>04</td>
                      <td>Dr. Tasha</td>
                      <td>Patient 4</td>
                      <td>13.5.2090</td>
                      <td>13:30</td>
                      <td><span class="status-canceled">Canceled</span></td>
                    </tr>
                    <tr>
                      <td>05</td>
                      <td>Dr. Fayya</td>
                      <td>Patient 5</td>
                      <td>12.10.2090</td>
                      <td>14:10</td>
                      <td><span class="status-done">Done</span></td>
                    </tr>
                    <tr>
                      <td>06</td>
                      <td>Dr. Harith</td>
                      <td>Patient 6</td>
                      <td>13.2.2090</td>
                      <td>13:10</td>
                      <td><span class="status-upcoming">Upcoming</span></td>
                    </tr>
                    <tr>
                      <td>07</td>
                      <td>Dr. Tasha</td>
                      <td>Patient 7</td>
                      <td>13.5.2090</td>
                      <td>13:30</td>
                      <td><span class="status-canceled">Canceled</span></td>
                    </tr>
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
          <a class="btn btn-primary" href="../login page/login page.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="../vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="../js/demo/chart-area-demo.js"></script>
  <script src="../js/demo/chart-pie-demo.js"></script>

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