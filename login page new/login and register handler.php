<?php
session_start();
require_once '../db conn.php';

global $conn;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["login_submit"])) {
        // Handle login section
        $username = $_POST["your_name"];
        $password = $_POST["your_pass"];

        $userData = loginhandler($username, $password);
        if ($userData) {
            // Store user data in session
            $_SESSION['user_role'] = $userData['role'];

            switch ($userData['role']) {
                case 'admin':
                    $_SESSION['admin_id'] = $userData['id'];
                    echo "<script>
                            alert('Successfully logged in!');
                            window.location.href = '../admin/homepage.php';
                          </script>";
                    break;

                case 'doctor':
                    $_SESSION['doctor_id'] = $userData['id'];
                    echo "<script>
                            alert('Successfully logged in!');
                            window.location.href = '../doctor page/homepage.php';
                          </script>";
                    break;

                case 'patient':
                    $_SESSION['patient_id'] = $userData['id'];
                    echo "<script>
                            window.location.href = '../patient page/index.php?message=success';
                          </script>";
                    break;
            }
        } else {
            echo "<script>
                    alert('Invalid Username or Password!');
                    window.location.href = '../login page new/index.html';
                  </script>";
        }
    } elseif (isset($_POST["signup_submit"])) {
        // Handle register section
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
            $patient_name = $_POST["name"];
            $email = $_POST["email"];
            $password = $_POST["pass"];
            $phone_number = $_POST["phone_number"];
            $emergency_number = $_POST["emergency_number"];
            $dob = $_POST["dob"];
            $gender = $_POST["gender"];
            $address = $_POST["address"];
            $ic_number = $_POST["ic_number"];
            $patient_photo = file_get_contents($_FILES['photo']['tmp_name']); // Get the binary data

            registerhandler($patient_name, $email, $password, $phone_number, $emergency_number, $dob, $gender, $address, $ic_number, $patient_photo);
        }
    }
}

// Function to check for special characters in the username
function specialChars($string)
{
    $specialChars = '!@#$%^&*()=+[{]};:\'",<>/?\\|';
    return strpbrk($string, $specialChars) !== false;
}

// Function to check for duplicate username or email in the database
function isDuplicate($email, $username)
{
    global $conn;

    // Check if email or username exists in the 'patient' table
    $sql = "SELECT * FROM patient WHERE email = ? OR patient_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return true;
    }

    // Check if email or username exists in the 'admin' table
    $sql = "SELECT * FROM admin WHERE email = ? OR admin_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return true;
    }

    // Check if email or username exists in the 'doctor' table
    $sql = "SELECT * FROM doctor WHERE email = ? OR doctor_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return true;
    }

    return false; // No duplicates found
}

// Function to handle registration
function registerhandler($username, $email, $password, $phone_number, $emergency_number, $dob, $gender, $address, $ic_number, $patient_photo)
{
    if (strlen($username) >= 6 && strlen($username) <= 30) {
        if (!specialChars($username)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if (strlen($password) >= 6 && strlen($password) <= 30) {
                    // Check for duplicate username or email
                    if (!isDuplicate($email, $username)) {
                        insertUser($username, $email, $password, $phone_number, $emergency_number, $dob, $gender, $address, $ic_number, $patient_photo);
                    } else {
                        // Redirect or stay on the page with error message
                        echo "<script>
                                alert('Username or Email is already in use.');
                                window.history.back(); // This keeps the user on the same page
                              </script>";
                    }
                } else {
                    echo "<script>
                            alert('Password must be between 6 and 10 characters.');
                            window.history.back();
                          </script>";
                }
            } else {
                echo "<script>
                        alert('Invalid Email format.');
                        window.history.back();
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Username can only contain letters, numbers, _ . - only.');
                    window.history.back();
                  </script>";
        }
    } else {
        echo "<script>
                alert('Username must be between 6 and 30 characters.');
                window.history.back();
              </script>";
    }
}

// Function to insert new user into the database with password hashing
function insertUser($patient_name, $email, $password, $phone_number, $emergency_number, $dob, $gender, $address, $ic_number, $patient_photo)
{
    global $conn;

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO patient (patient_name, email, password, `phone number`, emerg_num, d_o_b, gender, address, `ic number`, patient_photo)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssb", $patient_name, $email, $hashedPassword, $phone_number, $emergency_number, $dob, $gender, $address, $ic_number, $patient_photo);

    if ($stmt->execute()) {
        echo "<script>
                alert('Successfully registered!');
                window.location.href = '../login page new/index.html';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Function to handle login and password verification
function loginhandler($username, $password)
{
    global $conn;

    // Check admin table
    $sql = "SELECT * FROM admin WHERE admin_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['password'])) {
            return array('role' => 'admin', 'id' => $row['admin_id']);
        }
    }

    // Check doctor table
    $sql = "SELECT * FROM doctor WHERE doctor_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['password'])) {
            return array('role' => 'doctor', 'id' => $row['doctor_id']);
        }
    }

    // Check patient table
    $sql = "SELECT * FROM patient WHERE patient_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['password'])) {
            return array('role' => 'patient', 'id' => $row['patient_id']);
        }
    }

    return false; // No match found or invalid password
}
