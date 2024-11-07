<?php

require_once "../db conn.php";
session_start();


$admin_id = $_SESSION['admin_id'];

function fetchAllAdminInfo($conn)
{

  global $admin_id;
  $sql = "SELECT * FROM admin WHERE admin_id = $admin_id";
  $result = mysqli_query($conn, $sql);

  // Initialize an array to store the results
  $adminInfo = array();

  // Fetch each row and store it in the array
  while ($row = mysqli_fetch_assoc($result)) {
    $adminInfo[] = $row;
  }

  // Return the array containing all patient information
  return $adminInfo;
}

$allAdminInfo = fetchAllAdminInfo($conn);

foreach ($allAdminInfo as $admin) {
  $_SESSION['admin_name'] = $admin['admin_name'];
  $_SESSION['admin_photo'] = $admin['admin_photo'];
}

$admin_name = $_SESSION['admin_name'];
$admin_photo = $_SESSION['admin_photo'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>

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
    .card-article {

      background: #fff;
      display: inline-block;
      border: 1px solid #ddd;
    }

    .image-article {

      float: left;
      background: #000;
      height: 100%;

    }

    .content-article {
      float: left;
      height: 140px;
      width: 73%;
      overflow: hidden;
      padding: 5px;

    }

    .content h4 {
      margin: 5px 0;
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
        href="./homepage.php">
        <div class="sidebar-brand-icon">
          <img src="./img/svg/logo-only.svg" />
        </div>
        <div class="sidebar-brand-text mx-2">MedAssist</div>
      </a>

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active ml-1">
        <a class="nav-link" href="homepage.php">
          <i class="fa-solid fa-house"></i>
          <span>Home</span></a>
      </li>

      <li class="nav-item ml-1">
        <a class="nav-link" href="./manage doctor/view all doctors.php">
          <i class="fa-solid fa-stethoscope"></i>
          <span>View All Doctors</span></a>
      </li>

      <li class="nav-item ml-1">
        <a class="nav-link" href="./manage patient/view all patient.php ">
          <i class="fa-regular fa-user"></i>
          <span>View All Patients</span></a>
      </li>

      <li class="nav-item ml-1">
        <a class="nav-link" href="./manage appointment/view all appointment.php">
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
                <span class="mr-3 d-none d-lg-inline text-gray-600 small"><?php echo $admin['admin_name']  ?></span>
                <?php
                echo '<td><img src="data:image/jpeg;base64,' . base64_encode($admin['admin_photo']) . '" alt="Admin photo" class="mini-photo"></td>'
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
          <!-- Page Heading and Button in the same row -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-900 font-weight-bolder">Home Page</h1>

            <!-- Button aligned to the right -->
            <a href="./manage article/manage_article.php" class="btn btn-primary mb-2">
              <i class="fa fa-plus mr-1"></i> Manage Article
            </a>
          </div>
          <div
            class="welcome-section p-4 ml-1 mb-5 border-2 rounded-lg justify-content-center"
            style="background-image: url(./img/background.png)">
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <h1 class="h4 text-gray-900 font-weight-bolder">Welcome!</h1>
            <?php echo "<p class='text-gray-900 font-weight-normal'>Hi, " . $admin['admin_name'] . " </p>" ?>
          </div>
        </div>

        <!-- Welcome Section -->




        <!-- Content Column -->



        <div class="container article-container">
          <?php
          // Assuming connection to the database is established in $conn

          // Fetch only visible articles
          $query = "SELECT * FROM article WHERE visibility = 'show'";
          $result = $conn->query($query);

          if ($result && $result->num_rows > 0) {
            while ($article = $result->fetch_assoc()) {
              // Base64 encode the image from the database
              $imageSrc = 'data:image/jpeg;base64,' . base64_encode($article['image']);
          ?>
              <div class="square">
                <!-- Dynamic image from the database -->
                <img src="<?= htmlspecialchars($imageSrc); ?>" class="mask m-3">
                <!-- Dynamic title from the database -->
                <div class="h1"><?= htmlspecialchars($article['title']); ?></div>
                <!-- Dynamic description from the database -->
                <p><?= htmlspecialchars($article['description']); ?></p>
                <!-- Dynamic link from the database -->
                <div>
                  <div class="button-container">
                    <a href="<?= htmlspecialchars($article['link']); ?>" target="_blank" class="button">Read More</a>
                  </div>

                </div>

              </div>
          <?php
            }
          } else {
            echo '<p>No articles found.</p>';
          }

          $result->free();
          $conn->close();
          ?>
        </div>

        <style>
          @import url('https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@300;400&display=swap');

          .article-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 30px;
          }

          .article-container .square {
            width: 300px;
            /* Reduced width for better landscape fit */
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            position: relative;
          }

          .article-container .square:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
          }

          /* Image container for A4 portrait and landscape images */
          .article-container .mask {
            width: 280px;
            height: 160px;
            /* Reduced height */
            object-fit: cover;
            /* Changed to 'contain' to ensure full visibility */
            border-radius: 10px;
            background-color: #f0f0f0;
            /* Adding a background to fill space if image doesn't fit exactly */
          }

          .article-container .h1 {
            font-family: 'Merriweather', serif;
            font-size: 20px;
            font-weight: 700;
            color: #333;
            margin-top: 15px;
            padding: 0 20px;
          }

          .article-container p {
            padding: 15px 20px;
            font-family: 'Open Sans', sans-serif;
            font-size: 14px;
            color: #777;
            line-height: 1.6;
          }

          .article-container .button-container {
            display: flex;
            justify-content: center;
            /* Centers the button horizontally */
            margin: 15px 0;
          }

          .article-container .button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            font-size: 14px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
          }

          .article-container .button:hover {
            background-color: #0056b3;
          }


          @media (max-width: 768px) {
            .article-container {
              padding: 20px;
            }

            .article-container .square {
              width: 100%;
            }

            .article-container .mask {
              height: 150px;
            }

            .article-container .h1 {
              font-size: 18px;
            }

            .article-container p {
              font-size: 13px;
            }
          }
        </style>

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
</body>

</html>