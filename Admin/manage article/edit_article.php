<?php
require_once '../../db conn.php';

session_start();

// Ensure article_id is set and valid




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = $_POST['id'];
    $title = $_POST['title'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    $visibility = $_POST['visibility'];
    $link = $_POST['link'];

    // Handle file upload
    $imageData = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        $imageType = $_FILES['image']['type'];
    } else {
        // If no new image uploaded, retain the old image
        $imageData = $row['image'];
    }

    // Update article in the database
    $sql = "UPDATE article SET title = ?, date = ?, image = ?, description = ?, visibility = ?, link = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $title, $date, $imageData, $description, $visibility, $link, $id);

    if ($stmt->execute()) {
        echo "Article updated successfully!";
    } else {
        echo "Error updating article: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    $article_id = $_GET['id'];

    // Prepare and execute query
    $sql = "SELECT * FROM article WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $article_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Check if article exists
    if (!$row) {
        die("Article not found.");
    }

    $title = $row["title"];
    $date = $row["date"];
    $image = $row["image"];
    $description = $row["description"];
    $visibility = $row["visibility"];
    $link = $row["link"];
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

    <title>Edit article</title>

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

            <li class="nav-item  ml-1">
                <a class="nav-link" href="view all doctors.php">
                    <i class="fa-solid fa-stethoscope"></i>
                    <span>View All Doctors</span></a>
            </li>

            <li class="nav-item ml-1">
                <a class="nav-link" href="view all patient.php">
                    <i class="fa-regular fa-user"></i>
                    <span>View All Patients</span></a>
            </li>

            <li class="nav-item ml-1">
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
                                    src="img/undraw_profile.svg" />
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

                <!-- Content -->
                <!-- <div class="container mt-5">
        <div class="row">
            <div class="col-12 text-right">
                <a href="article_form.php">
                    <button class="btn btn-primary mb-2">
                        <i class="fa fa-plus mr-1"></i> Add New Article
                    </button>
                </a>
            </div>
        </div>
    </div> -->

                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div
                        class="d-sm-flex align-items-center justify-content-center mb-4">
                        <h1 class="h3 mb-2 text-gray-900 font-weight-bolder">
                            Edit Article
                        </h1>
                    </div>


                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <tbody>
                                    <div class="container-fluid">
                                        <form method="post" action="edit_article.php" enctype="multipart/form-data">
                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($article_id); ?>">

                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="date">Date</label>
                                                <input type="text" class="form-control" id="date" name="date" value="<?php echo htmlspecialchars($date); ?>" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="image">Image</label>
                                                <br>
                                                <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="Article Image" class="article-image" style="width: 10%; height: auto;">'; ?>
                                                <br>
                                                <br>
                                                <input type="file" name="image" id="formFile" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($description); ?></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="visibility">Visibility</label>
                                                <input type="text" class="form-control" id="visibility" name="visibility" value="<?php echo htmlspecialchars($visibility); ?>" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="link">Link</label>
                                                <input type="text" class="form-control" id="link" name="link" value="<?php echo htmlspecialchars($link); ?>" required>
                                            </div>


                                            <div class="d-flex justify-content-center">
                                                <div class="mr-2">
                                                    <!-- Back Button -->
                                                    <?php
                                                    echo '<a href="manage_article.php?id=' . htmlspecialchars($row['id']) . '">
            <button type="button" class="btn btn-primary mb-2">
                <i class="fa-solid fa-chevron-left mr-1"></i> Back
            </button>
            </a>';
                                                    ?>
                                                </div>

                                                <!-- Add another button side by side -->
                                                <div class="form-group d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-primary">Update Info</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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
                            <a class="btn btn-primary" href="logout.php">Logout</a>
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

</body>

</html>