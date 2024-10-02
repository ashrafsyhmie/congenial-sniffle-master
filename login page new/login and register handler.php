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
                    window.location.href = ' ../admin/homepage.php';
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
                    //     echo "<script>
                    //     alert('Successfully logged in!');
                    //     window.location.href = ' ../patient page/index.php';
                    //   </script>";
                    echo "<script>
                        // showAlert();
                        window.location.href = '../patient page/index.php?message=success';
                    </script>";
                    break;
            }
        } else {
            echo "<script>
                    alert('Wrong Password!');
                    window.location.href = ' ../login page new/index.html';
                  </script>";
        }
    } elseif (isset($_POST["signup_submit"])) {
        // Handle register section
        $patient_name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["pass"];
        $phone_number = $_POST["phone_number"];
        $emergency_number = $_POST["emergency_number"];
        $dob = $_POST["dob"];
        $gender = $_POST["gender"];
        $address = $_POST["address"];
        $ic_number = $_POST["ic_number"];
        // $patient_photo = $_POST["photo"];


        registerhandler($patient_name, $email, $password, $phone_number, $emergency_number, $dob, $gender, $address, $ic_number);
    }
}

function specialChars($string)
{
    $specialChars = '!@#$%^&*()=+[{]};:\'",<>/?\\|';
    return strpbrk($string, $specialChars) !== false;
}

function registerhandler($username, $email, $password, $phone_number, $emergency_number, $dob, $gender, $address, $ic_number)
{
    if (strlen($username) >= 6 && strlen($username) <= 10) {
        if (!specialChars($username)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if (strlen($password) >= 6 && strlen($password) <= 10) {
                    insertUser($username, $email, $password, $phone_number, $emergency_number, $dob, $gender, $address, $ic_number);
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


// SQL function

function insertUser($patient_name, $email, $password,  $phone_number, $emergency_number, $dob, $gender, $address, $ic_number)
{
    global $conn;
    $sql = "INSERT INTO patient (patient_name, email, password, `phone number`, emerg_num, d_o_b, gender, address, `ic number`) 
    VALUES ('$patient_name', '$email', '$password', '$phone_number', '$emergency_number', '$dob', '$gender', '$address', '$ic_number')";
    if ($conn->query($sql) === TRUE) {


        echo "<script>
            alert('Successfully registered!');
            // window.location.href = 'http://localhost/congenial-sniffle-master/login%20page/login%20page.html';
                    window.location.href = ' ../login page new/index.html';

          </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function loginhandler($username, $password)
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
