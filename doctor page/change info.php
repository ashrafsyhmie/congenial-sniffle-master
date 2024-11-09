<?php

session_start();
$doctor_id = $_SESSION['doctor_id'];
$doctor_name = $_SESSION['doctor_name'];
$errorMsg = "";
$successMsg = "";


require_once("../db conn.php");

function getDoctorData($conn, $doctor_id)
{
  $sql = "SELECT * FROM doctor WHERE doctor_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $doctor_id);
  $stmt->execute();
  return $stmt->get_result()->fetch_assoc();
}



$row = getDoctorData($conn, $doctor_id);

if (!$row) {
  die("Doctor not found.");
}

// Populate fields
$doctor_name = $row["doctor_name"];
$address = $row["address"];
$email = $row["email"];
$gender = $row["gender"];
$phone_number = $row["phone number"];
$dob = $row["d_o_b"];
$ic_number = $row["ic number"];
$imageData = $row["doctor_photo"];



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $doctor_name = $_POST['doctor_name'] ?? '';
  $address = $_POST['address'] ?? '';
  $email = $_POST['email'] ?? '';
  $gender = $_POST['gender'] ?? '';
  $phone_number = $_POST['phone_number'] ?? '';
  $dob = $_POST['dob'] ?? '';
  $ic_number = $_POST['ic_number'] ?? '';
  $imageData = $_FILES['image']['name'] ?? '';

  // Validate required fields
  if (!empty($doctor_name) && !empty($email)) {
    $sql = "UPDATE doctor SET doctor_name=?, `ic number`=?, address=?, email=?, `phone number`=?, gender=?, d_o_b=?, doctor_photo=? WHERE doctor_id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssi", $doctor_name, $ic_number, $address, $email, $phone_number, $gender, $dob, $imageData, $doctor_id);

    if ($stmt->execute()) {
      $successmsg = "Doctor information updated successfully.";
    } else {
      $errorMsg = "Error updating doctor information: " . $stmt->error;
    }
  } else {
    $errorMsg = "Please fill out all required fields.";
  }

  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $imageType = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

    // Validate image type and size
    if (in_array($imageType, ['jpg', 'jpeg', 'png']) && $_FILES['image']['size'] < 5000000) { // Limit size to 5MB
      $imageData = file_get_contents($_FILES['image']['tmp_name']);

      // Prepare SQL query to update doctor information
      $sql = "UPDATE doctor SET doctor_photo = ? WHERE doctor_id = $doctor_id";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $imageData);

      // Execute the query
      if ($stmt->execute()) {
        $successMsg = "Doctor information updated successfully.";
      } else {
        $errorMsg = "Error updating doctor information: " . $conn->error;
      }
    } else {
      $errorMsg = "Invalid image file type or size.";
    }
  } elseif (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    $errorMsg = "Error uploading image.";
  }
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

  <title>Title</title>

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
        <a class="nav-link" href="homepage.php">
          <i class="fa-solid fa-house"></i>
          <span>Home</span></a>
      </li>

      <li class="nav-item ml-1">
        <a class="nav-link" href="appointment record.php">
          <i class="fa-solid fa-calendar"></i>
          <span>View Appointment</span></a>
      </li>

      <li class="nav-item ml-1">
        <a class="nav-link" href="view all patient.php">
          <i class="fa-solid fa-bookmark"></i>
          <span>View All Patient</span></a>
      </li>

      <li class="nav-item active ml-1">
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
            <a class="collapse-item active" href="change info.php">Change Info</a>
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
                <span class="mr-3 d-none d-lg-inline text-gray-600 small"><?php echo $doctor_name; ?></span>
                <?php
                echo '<td><img src="data:image/jpeg;base64,' . base64_encode($_SESSION['doctor_photo']) . '" alt="Doctor photo" class="mini-photo"></td>'
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
          <div
            class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-900 font-weight-bolder">
              Change Information
            </h1>
          </div>

          <!-- Content Row -->
          <form method="post" action="./change info.php" enctype="multipart/form-data">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <tbody>
                    <div class="container-fluid">
                      <?php if ($successMsg): ?>
                        <div class="alert alert-success" role="alert">
                          <?php echo $successMsg; ?>
                        </div>
                      <?php endif; ?>

                      <?php if ($errorMsg): ?>
                        <div class="alert alert-danger" role="alert">
                          <?php echo $errorMsg; ?>
                        </div>
                      <?php endif; ?>


                      <input type="hidden" name="doctor_id" value="<?php echo htmlspecialchars($doctor_id); ?>">

                      <div class="form-group">
                        <label for="doctor_name">Doctor Name</label>
                        <input type="text" class="form-control" id="doctor_name" name="doctor_name" value="<?php echo htmlspecialchars($doctor_name); ?>" required>
                      </div>

                      <div class="form-group">
                        <label for="ic_number">IC Number</label>
                        <input type="text" class="form-control" id="icInput" name="ic_number" value="<?php echo htmlspecialchars($ic_number); ?>" maxlength="14" required>
                      </div>

                      <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required>
                      </div>

                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                      </div>

                      <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender" required>
                          <option value="Male" <?php echo $gender == 'Male' ? 'selected' : ''; ?>>Male</option>
                          <option value="Female" <?php echo $gender == 'Female' ? 'selected' : ''; ?>>Female</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" class="form-control" id="number" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" maxlength="13" required>
                      </div>

                      <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob" value="<?php echo htmlspecialchars($dob); ?>" required>
                      </div>

                      <div class="form-group">
                        <label for="image">Profile Image</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                      </div>

                      <div class="form-group d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Update Info</button>
                      </div>


                    </div>
                  </tbody>
                </table>
              </div>
            </div>
          </form>
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

  <script>
    document.getElementById('icInput').addEventListener('input', function(e) {
      let icNumber = e.target.value.replace(/\D/g, ''); // Remove non-numeric characters
      if (icNumber.length > 6) {
        icNumber = icNumber.slice(0, 6) + '-' + icNumber.slice(6);
      }
      if (icNumber.length > 9) {
        icNumber = icNumber.slice(0, 9) + '-' + icNumber.slice(9);
      }
      e.target.value = icNumber; // Update the input field with the formatted value
    });
  </script>
  <script>
    document.getElementById('number').addEventListener('input', function(e) {
      let value = e.target.value.replace(/\D/g, ''); // Remove non-numeric characters

      // Insert hyphens at the correct positions
      if (value.length > 3) value = value.slice(0, 3) + '-' + value.slice(3);
      if (value.length > 7) value = value.slice(0, 7) + '-' + value.slice(7);

      e.target.value = value;
    });
    document.getElementById('emergency').addEventListener('input', function(e) {
      let value = e.target.value.replace(/\D/g, ''); // Remove non-numeric characters

      // Insert hyphens at the correct positions
      if (value.length > 3) value = value.slice(0, 3) + '-' + value.slice(3);
      if (value.length > 7) value = value.slice(0, 7) + '-' + value.slice(7);

      e.target.value = value;
    });
  </script>
</body>

</html>