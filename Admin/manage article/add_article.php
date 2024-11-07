<?php

require_once "../../db conn.php";
session_start();

$_SESSION['admin_id'] = 1;

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
}
// Establish your MySQLi connection (assuming you have a separate file for this)

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnSubmit'])) {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $link = $_POST['link'];
    $visibility = $_POST['visibility'];

    // Handle file upload
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
    }

    // Prepare SQL query with placeholders
    $query = "INSERT INTO article (title, description, image, link, visibility) VALUES (?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($query);

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // Bind parameters
    $stmt->bind_param('sssss', $title, $description, $image, $link, $visibility);

    // Execute the statement
    if ($stmt->execute()) {
        header("Location: ./manage_article.php?message= New Article added successfully!&message_type=success");
    } else {
        echo "Error executing statement: " . htmlspecialchars($stmt->error);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
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

    <title>Home Page</title>

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

<body id="page-top">
    <style>
        .form-group {
            margin-bottom: 15px;
        }

        .custom-btn {
            border-radius: 10px;
            color: #161D6F;
            padding: 6px 15px;
            background-color: #D2E0FB;
            font-size: 16px;
            outline: none;
            cursor: pointer;
            margin: 0px;
            transition: background-color 0.3s, color 0.3s;
        }

        .custom-btn:hover,
        .custom-btn:focus {
            background-color: #2C57DD;
            /* Darker blue for hover/focus */
            color: #FFF;
        }

        input[type="radio"] {
            display: none;
            /* Hide the radio button itself */
        }

        input[type="radio"]:checked+label {
            background-color: #0056b3;
            /* Darker blue to indicate selection */
            color: #FFF;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="number"],
        #specialization {
            width: 90%;
        }

        .gender-buttons {
            background-color: #D2E0FB;
            border-radius: 8px;
            display: inline-block;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .upload-photo {
            display: flex;
            flex-direction: column;
            align-items: start;
            margin-top: 10px;
            margin-right: 20px;
        }

        .upload-label {
            display: flex;
            align-items: center;
            cursor: pointer;
            color: #161D6F;
            margin-left: 20px;
        }



        .upload-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 10px;
        }

        .upload-icon i {
            font-size: 17px;
            color: #2C57DD;
        }

        /* Hover effect */
        .upload-label:hover {
            color: #2C57DD;
        }

        .upload-label:hover .upload-icon {
            background-color: #D2E0FB;
        }

        .upload-label span {
            font-size: 15px;
        }

        .rounded-circle {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        #selectedImage {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            margin-top: 20px;
        }

        .container {
            background-color: #EEF7FF;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(44, 87, 221, 0.2);
            width: 1000px;
            margin-bottom: 30px;
        }

        .row {
            color: #2C57DD;
        }

        .form-control {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .custom-select {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
                href="../homepage.php">
                <div class="sidebar-brand-icon">
                    <img src="../img/svg/logo-only.svg" />
                </div>
                <div class="sidebar-brand-text mx-2">MedAssist</div>
            </a>

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active ml-1">
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

            <li class="nav-item ml-1">
                <a
                    class="nav-link"
                    href="../manage appointment/view all appointment.php ">
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
                    <div class="d-sm-flex align-items-center justify-content-center mb-4">
                        <h1 class="h3 mb-0 text-gray-900 font-weight-bolder">
                            Add New Article
                        </h1>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <tbody>
                                    <div class="container contact-form ">
                                        <form method="post" enctype="multipart/form-data" action="./add_article.php">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form action="add_article.php" method="POST" d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                                                        <div class="form-group">
                                                            <label for="title">Title</label>
                                                            <input type="text" name="title" id="title" class="form-control" placeholder="Title" required>
                                                        </div>
                                                        .
                                                        <div class="form-group">
                                                            <label for="content">Description</label>
                                                            <textarea name="description" id="description" class="form-control" rows="5" placeholder="Description" required></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Visibility:</label><br>
                                                            <div class="gender-buttons">
                                                                <input type="radio" id="show" name="visibility" value="show" hidden />
                                                                <label for="show" class="btn custom-btn">Show</label>

                                                                <input type="radio" id="hidden" name="visibility" value="hidden" hidden />
                                                                <label for="hidden" class="btn custom-btn">Hidden</label>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="title">Link</label>
                                                        <input type="text" name="link" id="link" class="form-control" placeholder="www.example.com" required>
                                                    </div>
                                                    <div class="upload-photo">
                                                        <div class="mb-4 d-flex justify-content-center" ;>
                                                            <img id="selectedImage" src="https://mdbootstrap.com/img/Photos/Others/placeholder.jpg"
                                                                alt="example placeholder" class="rounded-circle" />

                                                            <input type="file" name="image" id="image" onchange="displaySelectedImage(event, 'selectedImage')" hidden>
                                                            <label for="image" class="upload-label">
                                                                <div class="upload-icon">
                                                                    <i class="fa fa-camera"></i> <!-- Camera icon -->
                                                                </div><br>
                                                                <span style="color: #2C57DD;">Upload a photo</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                        </div>


                        <div class="d-flex justify-content-center">
                            <div class="mr-2">
                                <!-- Back Button -->
                                <a href="manage_article.php">
                                    <button type="button" class="btn btn-primary mb-2">
                                        <i class="fa-solid fa-chevron-left mr-1"></i> Back
                                    </button>
                                </a>
                            </div>
                            <div><button class="btn btn-primary mx-2" name="btnSubmit" id="btnSubmit">Submit</button></div>
                        </div>
                        </form>
                        <?php
                        if (!empty($successmsg)) {
                            echo "<script>alert('" . htmlspecialchars($successmsg) . "')</script>";
                            if (strpos($successmsg, 'created successfully') !== false) {
                                echo "<script>window.location.href = 'add_article.php'</script>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- Welcome Section -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->

    <!-- Footer -->

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
        function displaySelectedImage(event, elementId) {
            const selectedImage = document.getElementById(elementId);
            const fileInput = event.target;

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    selectedImage.src = e.target.result;
                };

                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    </script>
</body>

</html>