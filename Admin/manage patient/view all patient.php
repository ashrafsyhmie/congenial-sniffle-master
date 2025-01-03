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

  /* Ensure the clear button looks like an 'x' icon */
  .btn-outline-secondary {
    border-color: transparent;
    color: #6c757d;
  }

  .btn-outline-secondary:hover {
    background-color: #f8f9fa;
    color: #495057;
  }

  .fas.fa-times {
    font-size: 16px;
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
                echo '<td><img src="data:image/jpeg;base64,' . base64_encode($_SESSION['admin_photo']) . '" alt="Admin photo" class="mini-photo "></td>'
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
              View All Patients
            </h1>

          </div>
          <div class="d-flex justify-content-between mb-3 ml-1">
            <!-- Search Bar -->
            <form action="" method="GET" class="d-flex">
              <div class="input-group" style="width: 650px;">
                <input type="text" name="search" class="form-control" placeholder="Search by Name or IC Number..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                <div class="input-group-append">
                  <button class="btn btn-primary mb-2" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
                    <a href="?" class="btn btn-primary mb-2">
                      <i class="fas fa-times"></i>
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            </form>



            <!-- Add New patient Button -->
            <a href="./patient form.php" class="btn btn-primary mb-2">
              <i class="fa fa-plus mr-1"></i> Add New Patient
            </a>
          </div>

          <?php
          // Database connection
          require_once "../../db conn.php";

          // Define the number of results per page
          $results_per_page = 4;

          // Get the current page number from the URL, default to 1 if not present
          $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
          if ($page < 1) {
            $page = 1;
          }

          // Calculate the starting limit for pagination
          $start_limit = ($page - 1) * $results_per_page;

          // Initialize variables for search term and specialization
          $search_term = '';
          $specialization = '';

          // Prepare SQL conditions based on user inputs
          $conditions = [];
          if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search_term = $conn->real_escape_string($_GET['search']);
            // Search in both 'doctor_name' and 'ic number' fields
            $conditions[] = "(patient_name LIKE '%$search_term%' OR `ic number` LIKE '%$search_term%')";
          }

          if (isset($_GET['specialization']) && !empty($_GET['specialization'])) {
            $specialization = $conn->real_escape_string($_GET['specialization']);
            $conditions[] = "specialization = '$specialization'";
          }

          // Construct the SQL query based on conditions
          $where_clause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';
          $sql = "SELECT * FROM patient $where_clause LIMIT $start_limit, $results_per_page";
          $total_sql = "SELECT COUNT(*) FROM patient $where_clause";

          // Fetch total number of records
          $result = $conn->query($total_sql);
          $total_rows = $result->fetch_row()[0];
          $total_pages = ceil($total_rows / $results_per_page);

          // Fetch the data for the current page
          $result = $conn->query($sql);

          // Display data or handle it as needed (e.g., in a table)

          // Continue with your data display logic below
          ?>


          <!-- All Patient table -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                All Patients
              </h6>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-border-0" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width: 17%;">Patient's Profile</th>
                      <th style="width: 17%;">Patient's Name</th>
                      <th style="width: 12%;">Actions</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['patient_photo']) . '" alt="Patient photo" class="patient-photo img-thumbnail"></td>';
                        echo "<td>" . htmlspecialchars($row['patient_name']) . "<br>" . htmlspecialchars($row['ic number']) . "</td>";
                        echo '<td>';
                        echo '<a href="patient_profile.php?id=' . htmlspecialchars($row['patient_id']) . '" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></a> ';
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

        <!-- Pagination -->
        <div class="pagination-container">
          <a href="?page=<?php echo max(1, $page - 1); ?>&search=<?php echo urlencode($search_term); ?>">&#8249; Previous</a>

          <!-- Display the current page and total pages -->
          <span class="page-info">Page <?php echo $page; ?> of <?php echo $total_pages; ?></span>

          <a href="?page=<?php echo min($total_pages, $page + 1); ?>&search=<?php echo urlencode($search_term); ?>">Next &#8250;</a>
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