<?php

require_once "../db conn.php";
session_start();

$doctor_id = $_SESSION['doctor_id'];

function fetchAllDoctorInfo($conn)
{
  global $doctor_id;
  $sql = "SELECT * FROM doctor WHERE doctor_id = $doctor_id";
  $result = mysqli_query($conn, $sql);

  // Initialize an array to store the results
  $doctorInfo = array();

  // Fetch each row and store it in the array
  while ($row = mysqli_fetch_assoc($result)) {
    $doctorInfo[] = $row;
  }

  // Return the array containing all patient information
  return $doctorInfo;
}

$allDoctorInfo = fetchAllDoctorInfo($conn);

foreach ($allDoctorInfo as $doctor) {
  $_SESSION['doctor_name'] = $doctor['doctor_name'];
  $_SESSION['doctor_photo'] = $doctor['doctor_photo'];
}


$doctor_name = $_SESSION['doctor_name'];



// Assuming you have a connection to the database in $conn
$doctor_id = $_SESSION['doctor_id']; // Assuming doctor_id is stored in the session

function fetchAllDoctorAppointments($conn, $doctor_id)
{
  // SQL query to fetch all appointments for a specific doctor
  $sql = "SELECT a.*, p.patient_name, p.patient_photo
            FROM appointment a
            JOIN patient p ON a.patient_id = p.patient_id
            WHERE a.doctor_id = $doctor_id";

  $result = mysqli_query($conn, $sql);

  // Initialize an array to store the results
  $appointmentInfo = array();

  // Fetch each row and store it in the array
  while ($row = mysqli_fetch_assoc($result)) {
    $appointmentInfo[] = $row;
  }

  // Return the array containing all appointment information
  return $appointmentInfo;
}

// Fetch all appointments for the doctor
$allDoctorAppointments = fetchAllDoctorAppointments($conn, $doctor_id);

// Output the fetched information
foreach ($allDoctorAppointments as $appointment) {
  // Store appointment and patient details in session if needed
  $_SESSION['patient_name'] = $appointment['patient_name'];
  $_SESSION['patient_photo'] = $appointment['patient_photo'];
  $_SESSION['appointment_date'] = $appointment['date']; // Example field
  $_SESSION['appointment_time'] = $appointment['timeslot']; // Example field

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

    .photo {
      width: 90px;
      /* set the width */
      height: 90px;
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
  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <ul
      class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
      id="accordionSidebar">
      <!-- Sidebar - Brand -->
      <a
        class="sidebar-brand d-flex align-items-center justify-content-center"
        href="./homepage.php">
        <div class="sidebar-brand-icon">
          <img src="../img/svg/logo-only.svg" />
        </div>
        <div class="sidebar-brand-text mx-2">MedAssist</div>
      </a>

      <!-- Nav Item - Dashboard -->
      <li class="nav-item  ml-1">
        <a class="nav-link" href="./homepage.php">
          <i class="fa-solid fa-house"></i>
          <span>Home</span></a>
      </li>

      <li class="nav-item active ml-1">
        <a class="nav-link" href="appointment record.php">
          <i class="fa-solid fa-calendar"></i>
          <span>View Appointment</span></a>
      </li>

      <li class="nav-item  ml-1">
        <a class="nav-link" href="view all patient.php">
          <i class="fa-solid fa-bookmark"></i>
          <span>View All Patient</span></a>
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
            <a class="collapse-item" href="change info.php">Change Info</a>
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
                <span class="mr-3 d-none d-lg-inline text-gray-600 small"><?php echo $doctor['doctor_name']  ?></span>
                <?php
                echo '<td><img src="data:image/jpeg;base64,' . base64_encode($doctor['doctor_photo']) . '" alt="Doctor photo" class="mini-photo"></td>'
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
          </div>

          <!-- All Appointment table -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
              <h6 class="m-0 font-weight-bold text-primary">Appointment Record</h6>
              <div class="filter-form">
                <form method="GET" action="" class="form-inline">
                  <label for="filter" class="mr-2">Show:</label>
                  <select name="filter" id="filter" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                    <option value="all" <?php if (isset($_GET['filter']) && $_GET['filter'] == 'all') echo 'selected'; ?>>All</option>
                    <option value="upcoming" <?php if (isset($_GET['filter']) && $_GET['filter'] == 'upcoming') echo 'selected'; ?>>Upcoming</option>
                    <option value="done" <?php if (isset($_GET['filter']) && $_GET['filter'] == 'done') echo 'selected'; ?>>Done</option>
                    <option value="cancelled" <?php if (isset($_GET['filter']) && $_GET['filter'] == 'cancelled') echo 'selected'; ?>>Cancelled</option>
                  </select>
                  <noscript><button type="submit" class="btn btn-primary btn-sm">Apply</button></noscript>
                </form>
              </div>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-border-0 text-center" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <td>App. ID</td>
                      <td></td>
                      <td>Patient Name</td>
                      <td>Date</td>
                      <td>Time</td>
                      <td>Medical Record Action</td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Get the filter selection (default to 'all' if not set)
                    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

                    // Prepare the SQL query with the filter applied
                    $sql = "SELECT 
                      appointment.appointment_id,
                      appointment.status,
                      appointment.date,
                      appointment.timeslot,
                      patient.patient_name,
                      patient.patient_photo,
                      medical_record.medical_record_id
                    FROM appointment
                    JOIN patient ON appointment.patient_id = patient.patient_id
                    JOIN doctor ON appointment.doctor_id = doctor.doctor_id
                    LEFT JOIN medical_record ON appointment.appointment_id = medical_record.appointment_id";

                    // Apply the filter
                    if ($filter == 'upcoming') {
                      $sql .= " WHERE appointment.status = 'upcoming'";
                    } elseif ($filter == 'done') {
                      $sql .= " WHERE appointment.status = 'done'";
                    } elseif ($filter == 'cancelled') {
                      $sql .= " WHERE appointment.status = 'cancelled'";
                    }

                    $sql .= " ORDER BY appointment.appointment_id ASC";

                    $result = mysqli_query($conn, $sql);

                    // Check if there are rows
                    if (mysqli_num_rows($result) > 0) {
                      // Fetch and display rows
                      while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                          <td><?= htmlspecialchars($row['appointment_id']); ?></td>
                          <td><img src="data:image/jpeg;base64,<?= base64_encode($row['patient_photo']); ?>" alt="Patient photo" class="photo"></td>
                          <td><?= htmlspecialchars($row['patient_name']); ?></td>
                          <td><?= htmlspecialchars($row['date']); ?></td>
                          <td><?= htmlspecialchars($row['timeslot']) . "<br><br>";
                              if ($row['status'] == 'done') {
                                echo '<span class="status-done">Done</span>';
                              } elseif ($row['status'] == 'cancelled') {
                                echo "<span class='status-canceled'>Cancelled</span>";
                              } elseif ($row['status'] == 'upcoming') {
                                echo "<span class='status-upcoming'>Upcoming</span>";
                              } ?></td>
                          <td>
                            <?php if ($row['status'] == 'done' && isset($row['medical_record_id'])): ?>
                              <!-- Show Edit button if there's a medical record ID -->
                              <button class="btn btn-success btn-md mr-3" data-bs-toggle="modal" data-bs-target="#passwordModal"
                                data-medical-record-id="<?= $row['medical_record_id']; ?>">
                                <i class="fa fa-edit"></i>
                              </button>
                              <a href="./medical record/view medical record.php?medical_record_id=<?= $row['medical_record_id']; ?>" class="btn btn-primary btn-md">
                                <i class="fa-solid fa-eye"></i>
                              </a>
                              <!-- Medical Record ID Display -->
                              <br><br> Medical Record ID: <?= htmlspecialchars($row['medical_record_id']); ?>
                              <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="passwordModalLabel">Enter Password to Edit Medical Record</h5>
                                      <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <form id="passwordForm" method="POST" action="validate_password.php">
                                        <div class="mb-3 text-start">
                                          <label for="password" class="form-label">Password</label>
                                          <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" required>
                                            <button type="button" class="btn btn-outline-secondary" id="togglePassword" aria-label="Toggle Password">
                                              <i class="fa fa-eye"></i>
                                            </button>
                                          </div>
                                        </div>
                                        <input type="hidden" name="medical_record_id" id="medical_record_id" value="<?php echo $row['medical_record_id']; ?>">
                                    </div>
                                    <div class="modal-footer">
                                      <!-- Cancel Button -->
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                      <!-- Submit Button -->
                                      <button type="submit" class="btn btn-primary">Submit</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <script>
                                // Toggle password visibility
                                document.getElementById('togglePassword').addEventListener('click', function() {
                                  var passwordField = document.getElementById('password');
                                  var passwordIcon = this.querySelector('i');

                                  if (passwordField.type === 'password') {
                                    passwordField.type = 'text';
                                    passwordIcon.classList.remove('fa-eye');
                                    passwordIcon.classList.add('fa-eye-slash');
                                  } else {
                                    passwordField.type = 'password';
                                    passwordIcon.classList.remove('fa-eye-slash');
                                    passwordIcon.classList.add('fa-eye');
                                  }
                                });
                              </script>

                            <?php elseif ($row['status'] == 'done' && !isset($row['medical_record_id'])): ?>
                              <!-- Show Add button if status is done but no medical record ID -->
                              <a href="./medical record/medical history form.php?appointment_id=<?= $row['appointment_id']; ?>" class="btn btn-primary btn-md">
                                <i class="fa fa-plus mr-1"></i> Add Record
                              </a>
                            <?php else: ?>
                              <!-- Show 'No medical record' if status is not 'done' -->
                              No medical record
                            <?php endif; ?>
                          </td>
                        </tr>
                      <?php
                      }
                    } else {
                      // Display a message if no records found
                      ?>
                      <tr>
                        <td colspan="6" class="text-center">No <?= htmlspecialchars($filter); ?> appointments found.</td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>

                  <!-- Edit Password Modal -->


                  <script>
                    // When the modal is shown, set the appointment ID in the hidden input field
                    $('#passwordModal').on('show.bs.modal', function(event) {
                      var button = $(event.relatedTarget); // Button that triggered the modal
                      var medicalRecordId = button.data('medical-record-id'); // Extract the appointment ID from data-* attributes

                      var modal = $(this);
                      modal.find('#appointment_id').val(medicalRecordId); // Set the value of the hidden input for appointment_id
                    });
                  </script>



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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>




</body>

</html>