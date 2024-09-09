<?php

session_start();
require_once '../patient page/db conn.php';

global $conn;



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["login_submit"])) {
        // Handle login section
        $username = $_POST["username"];
        $password = $_POST["password"];

        $userData = loginhandler($username, $password);
        if ($userData) {
            // Store user data in session
            $_SESSION['user_role'] = $userData['role'];


            switch ($userData['role']) {
                case 'admin':
                    $_SESSION['admin_id'] = $userData['id'];
                    echo "<script>
                    alert('Successfully logged in!');
                    window.location.href = ' http://localhost/congenial-sniffle-master/admin%20page/homepage.html';
                  </script>";

                    break;
                case 'doctor':
                    $_SESSION['doctor_id'] = $userData['id'];
                    echo "<script>
                    alert('Successfully logged in!');
                    window.location.href = ' http://localhost/congenial-sniffle-master/doctor%20page/homepage.html';
                  </script>";

                    break;
                case 'patient':
                    $_SESSION['patient_id'] = $userData['id'];
                    echo "<script>
                    alert('Successfully logged in!');
                    window.location.href = ' http://localhost/congenial-sniffle-master/patient%20page/index.php';
                  </script>";

                    break;
            }
        } else {
            echo "Login Failed";
        }
    } elseif (isset($_POST["register_submit"])) {
        // Handle register section
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        registerhandler($username, $email, $password);
    }
}

function specialChars($string)
{
    $specialChars = '!@#$%^&*()=+[{]};:\'",<>/?\\|';
    return strpbrk($string, $specialChars) !== false;
}

function registerhandler($username, $email, $password)
{
    if (strlen($username) >= 6 && strlen($username) <= 10) {
        if (!specialChars($username)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if (strlen($password) >= 6 && strlen($password) <= 10) {
                    insertUser($username, $email, $password);
                } else {
                    echo "Password must be between 6 and 10 characters <br>";
                }
            } else {
                echo "Email is invalid <br>";
            }
        } else {
            echo "Username can only contain letters, numbers, and _ . - only <br>";
        }
    } else {
        echo "Username must be between 6 and 10 characters <br>";
    }
}

function loginhandler($username, $password)
{
    $userData = checkLoginInfo($username, $password);
    return $userData;
}

// SQL function

function insertUser($username, $email, $password)
{
    global $conn;
    $sql = "INSERT INTO patient (patient_name, email, password) VALUES ('$username', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {


        echo "<script>
            alert('Successfully registered!');
            window.location.href = 'http://localhost/congenial-sniffle-master/login%20page/login%20page.html';
          </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function checkLoginInfo($username, $password)
{
    global $conn;

    // Check admin table
    $sql = "SELECT * FROM admin WHERE admin_name = '$username' AND password = '$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return array('role' => 'admin', 'id' => $row['admin_id']);
    }

    // Check doctor table
    $sql = "SELECT * FROM doctor WHERE doctor_name = '$username' AND password = '$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return array('role' => 'doctor', 'id' => $row['doctor_id']);
    }

    // Check patient table
    $sql = "SELECT * FROM patient WHERE patient_name = '$username' AND password = '$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return array('role' => 'patient', 'id' => $row['patient_id']);
    }

    return false; // No match found
}
