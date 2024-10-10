<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Sign Up Form by Colorlib</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Font Icon -->
    <link
        rel="stylesheet"
        href="./login page new/fonts/material-icon/css/material-design-iconic-font.min.css" />
    <link rel="stylesheet" href="./login page new/style.css" />
    <!-- Main css -->
    <link rel="stylesheet" href="./login page new/css/style.css  " />

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <style>
        /* Transition effects for form parts */
        #part1,
        #part2 {
            transition: opacity 0.5s ease, transform 0.5s ease;
            opacity: 0;
            transform: translateY(20px);
            display: none;
            /* Start with display none */
        }

        #part1.active,
        #part2.active {
            opacity: 1;
            transform: translateY(0);
            display: block;
            /* Show when active */
        }

        :root {
            --dark: #34495e;
            --light: #ffffff;
            --success: #0abf30;
            --error: #e24d4c;
            --warning: #e9bd0c;
            --info: #3498db;
        }

        .notifications {
            position: fixed;
            top: 30px;
            right: 20px;
        }

        .notifications :where(.toast, .column) {
            display: flex;
            align-items: center;
        }

        .notifications .toast {
            width: 400px;
            position: relative;
            overflow: hidden;
            list-style: none;
            border-radius: 4px;
            padding: 16px 17px;
            margin-bottom: 10px;
            background: var(--light);
            justify-content: space-between;
            animation: show_toast 0.3s ease forwards;
        }

        @keyframes show_toast {
            0% {
                transform: translateX(100%);
            }

            40% {
                transform: translateX(-5%);
            }

            80% {
                transform: translateX(0%);
            }

            100% {
                transform: translateX(-10px);
            }
        }

        .notifications .toast.hide {
            animation: hide_toast 0.3s ease forwards;
        }

        @keyframes hide_toast {
            0% {
                transform: translateX(-10px);
            }

            40% {
                transform: translateX(0%);
            }

            80% {
                transform: translateX(-5%);
            }

            100% {
                transform: translateX(calc(100% + 20px));
            }
        }

        .toast::before {
            position: absolute;
            content: "";
            height: 3px;
            width: 100%;
            bottom: 0px;
            left: 0px;
            animation: progress 5s linear forwards;
        }

        @keyframes progress {
            100% {
                width: 0%;
            }
        }

        .toast.success::before,
        .btn#success {
            background: var(--success);
        }

        .toast.error::before,
        .btn#error {
            background: var(--error);
        }

        .toast.warning::before,
        .btn#warning {
            background: var(--warning);
        }

        .toast.info::before,
        .btn#info {
            background: var(--info);
        }

        .toast .column i {
            font-size: 1.75rem;
        }

        .toast.success .column i {
            color: var(--success);
        }

        .toast.error .column i {
            color: var(--error);
        }

        .toast.warning .column i {
            color: var(--warning);
        }

        .toast.info .column i {
            color: var(--info);
        }

        .toast .column span {
            font-size: 1.07rem;
            margin-left: 12px;
        }

        .toast i:last-child {
            color: #aeb0d7;
            cursor: pointer;
        }

        .toast i:last-child:hover {
            color: var(--dark);
        }

        .buttons .btn {
            border: none;
            outline: none;
            cursor: pointer;
            margin: 0 5px;
            color: var(--light);
            font-size: 1.2rem;
            padding: 10px 20px;
            border-radius: 4px;
        }

        @media screen and (max-width: 530px) {
            .notifications {
                width: 95%;
            }

            .notifications .toast {
                width: 100%;
                font-size: 1rem;
                margin-left: 20px;
            }

            .buttons .btn {
                margin: 0 1px;
                font-size: 1.1rem;
                padding: 8px 15px;
            }
        }
    </style>
</head>

<body>
    <div class="main">
        <!-- Sign up form -->
        <section class="signup" id="signup-section">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form
                            method="POST"
                            class="register-form"
                            id="register-form"
                            action="./index.php"
                            enctype="multipart/form-data">
                            <!-- Part 1 -->
                            <div id="part1" class="active">
                                <div class="form-group">
                                    <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        placeholder="Your Name"
                                        required />
                                </div>
                                <div class="form-group">
                                    <label for="email"><i class="zmdi zmdi-email"></i></label>
                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        placeholder="Your Email"
                                        required />
                                </div>
                                <!-- <div class="form-group">
                    <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                    <input
                      type="password"
                      name="pass"
                      id="pass"
                      placeholder="Password"
                      required
                    />
                  </div> -->
                                <div class="form-group">
                                    <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                    <input
                                        type="password"
                                        name="pass"
                                        id="pass"
                                        placeholder="Password"
                                        required />
                                    <button type="button" id="togglePasswordSignUp">
                                        <i class="zmdi zmdi-eye" id="eyeIconSignUp"></i>
                                    </button>
                                </div>
                                <div id="password-strength">
                                    <span class="strength-bar" id="strength-bar"></span>
                                    <span id="strength-message"></span>
                                </div>
                                <div class="form-group">
                                    <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                    <input
                                        type="password"
                                        name="re_pass"
                                        id="re_pass"
                                        placeholder="Repeat your password"
                                        required />
                                </div>
                                <!-- <div class="form-group">
                    <input
                      type="checkbox"
                      name="agree-term"
                      id="agree-term"
                      class="agree-term"
                      required
                    />
                    <label for="agree-term" class="label-agree-term">
                      <span><span></span></span>I agree all statements in
                      <a href="#" class="term-service">Terms of service</a>
                    </label>
                  </div> -->
                                <div class="form-group form-button">
                                    <button
                                        type="button"
                                        name="signin"
                                        id="nextToPart2"
                                        class="btn btn-primary btn-small">
                                        Next
                                    </button>
                                </div>
                            </div>
                            <!-- Part 2 -->
                            <div id="part2">
                                <div class="form-group">
                                    <label for="phone_number"><i class="zmdi zmdi-phone"></i></label>
                                    <input
                                        type="tel"
                                        name="phone_number"
                                        id="phone_number"
                                        placeholder="Phone Number"
                                        required />
                                </div>
                                <div class="form-group">
                                    <label for="emergency_number"><i class="zmdi zmdi-phone"></i></label>
                                    <input
                                        type="tel"
                                        name="emergency_number"
                                        id="emergency_number"
                                        placeholder="Emergency Number"
                                        required />
                                </div>
                                <div class="form-group">
                                    <label for="dob"><i class="zmdi zmdi-calendar"></i></label>
                                    <input type="date" name="dob" id="dob" required />
                                </div>
                                <div class="form-group">
                                    <label for="gender"><i class="zmdi zmdi-gender"></i></label>
                                    <select name="gender" id="gender" required>
                                        <option value="" disabled selected>Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="address"><i class="zmdi zmdi-home"></i></label>
                                    <input
                                        type="text"
                                        name="address"
                                        id="address"
                                        placeholder="Address"
                                        required />
                                </div>
                                <div class="form-group">
                                    <label for="ic_number"><i class="zmdi zmdi-card"></i></label>
                                    <input
                                        type="text"
                                        name="ic_number"
                                        id="ic_number"
                                        placeholder="IC Number"
                                        required />
                                </div>
                                <div class="form-group">
                                    <label for="photo"><i class="zmdi zmdi-image"></i></label>
                                    <input
                                        type="file"
                                        name="photo"
                                        id="photo"
                                        accept="image/*"
                                        required />
                                </div>

                                <div class="form-group form-button">
                                    <button
                                        type="button"
                                        name="backToPart1"
                                        id="backToPart1"
                                        class="btn btn-primary btn-small">
                                        Back
                                    </button>
                                    <button
                                        type="submit"
                                        name="signup_submit"
                                        id="signup"
                                        class="btn btn-primary btn-small">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure>
                            <img src="./login page new/images/sign-up.jpg" alt="sign up image" />
                        </figure>
                        <a href="#" class="signup-image-link" id="go-to-signin">I am already a member</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sign in Form -->
        <section class="sign-in" id="signin-section">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure>
                            <img
                                src="./login page new/images/Logo.png"
                                class="medassist_logo"
                                alt="Medassist Logo" />
                        </figure>
                        <figure>
                            <img src="./login page new/images/sign-in.jpg" alt="sign up image" />
                        </figure>
                        <a href="#" id="go-to-signup" class="signup-image-link">Create an account</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Sign In</h2>
                        <form
                            method="POST"
                            class="register-form"
                            id="login-form"
                            action="./index.php">
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input
                                    type="text"
                                    name="your_name"
                                    id="your_name"
                                    placeholder="Your Name" />
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input
                                    type="password"
                                    name="your_pass"
                                    id="your_pass"
                                    placeholder="Password" />
                                <button type="button" id="togglePasswordSignIn">
                                    <i class="zmdi zmdi-eye" id="eyeIconSignIn"></i>
                                </button>
                            </div>
                            <div class="form-group">
                                <input
                                    type="checkbox"
                                    name="remember-me"
                                    id="remember-me"
                                    class="agree-term" />
                                <label for="remember-me" class="label-agree-term">
                                    <span><span></span></span>Remember me
                                </label>
                            </div>
                            <div class="form-group form-button">
                                <!-- <button
                    type="submit"
                    name="login_submit"
                    id="signin"
                    class="btn btn-primary btn-small"
                  >
                    Log In
                  </button> -->
                                <input type="submit" name="login_submit" id="signin" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- <ul class="notifications"></ul>
        <div class="buttons">
            <button class="btn" id="success">Success</button>
            <button class="btn" id="error">Error</button>
            <button class="btn" id="warning">Warning</button>
            <button class="btn" id="info">Info</button>
        </div> -->
    </div>

    <!-- JS -->
    <script src="./vendor/jquery/jquery.min.js"></script>


    <script>
        // Get the links and sections
        const goToSignUp = document.getElementById("go-to-signup");
        const goToSignin = document.getElementById("go-to-signin");
        const signupSection = document.getElementById("signup-section");
        const signinSection = document.getElementById("signin-section");

        // Switch to sign up section
        goToSignUp.addEventListener("click", function() {
            signupSection.style.display = "block";
            signinSection.style.display = "none";
        });

        // Switch to sign in section
        goToSignin.addEventListener("click", function() {
            signupSection.style.display = "none";
            signinSection.style.display = "block";
        });

        // Handle password visibility toggle for Sign In
        const togglePasswordSignIn = document.getElementById(
            "togglePasswordSignIn"
        );
        const passwordFieldSignIn = document.getElementById("your_pass");
        const eyeIconSignIn = document.getElementById("eyeIconSignIn");

        togglePasswordSignIn.addEventListener("click", function() {
            const type =
                passwordFieldSignIn.getAttribute("type") === "password" ?
                "text" :
                "password";
            passwordFieldSignIn.setAttribute("type", type);
            eyeIconSignIn.classList.toggle("zmdi-eye");
            eyeIconSignIn.classList.toggle("zmdi-eye-off");
        });

        // Handle password visibility toggle for Sign Up
        const togglePasswordSignUp = document.getElementById(
            "togglePasswordSignUp"
        );
        const passwordFieldSignUp = document.getElementById("pass");
        const eyeIconSignUp = document.getElementById("eyeIconSignUp");

        togglePasswordSignUp.addEventListener("click", function() {
            const type =
                passwordFieldSignUp.getAttribute("type") === "password" ?
                "text" :
                "password";
            passwordFieldSignUp.setAttribute("type", type);
            eyeIconSignUp.classList.toggle("zmdi-eye");
            eyeIconSignUp.classList.toggle("zmdi-eye-off");
        });

        // Handle navigation between registration parts
        const nextToPart2 = document.getElementById("nextToPart2");
        const backToPart1 = document.getElementById("backToPart1");
        const part1 = document.getElementById("part1");
        const part2 = document.getElementById("part2");

        nextToPart2.addEventListener("click", function() {
            part1.classList.remove("active");
            part2.classList.add("active");
        });

        backToPart1.addEventListener("click", function() {
            part2.classList.remove("active");
            part1.classList.add("active");
        });

        // Initially display part1
        part1.classList.add("active");
    </script>
    <script>
        const passwordInput = document.getElementById("pass");
        const repeatPassword = document.getElementById("re_pass");
        const strengthBar = document.getElementById("strength-bar");
        const strengthMessage = document.getElementById("strength-message");
        const repeatPasswordMessage = document.createElement(
            "password-match-message"
        ); // Message for repeat password validation
        repeatPassword.parentNode.appendChild(repeatPasswordMessage); // Append message to the form

        passwordInput.addEventListener("input", validatePassword);
        repeatPassword.addEventListener("input", validatePassword);

        function validatePassword() {
            const password = passwordInput.value;
            const repeatPass = repeatPassword.value;
            const strength = checkPasswordStrength(password);

            // Reset bar
            strengthBar.className = "strength-bar";

            // Update strength bar and message
            if (password.length < 6) {
                strengthMessage.innerHTML =
                    "Password must be at least 6 characters long";
                strengthMessage.style.color = "#ff4b47";
                return; // Exit function if the password is too short
            }

            if (strength <= 1) {
                strengthBar.style.width = "50%";
                strengthBar.classList.remove("medium", "strong");
                strengthBar.classList.add("weak");
                strengthMessage.textContent = "Weak";
            } else if (strength == 2) {
                strengthBar.style.width = "75%";
                strengthBar.classList.remove("weak", "strong");
                strengthBar.classList.add("medium");
                strengthMessage.textContent = "Medium";
            } else if (strength >= 3) {
                strengthBar.style.width = "100%";
                strengthBar.classList.remove("weak", "medium");
                strengthBar.classList.add("strong");
                strengthMessage.textContent = "Strong";
            } else {
                strengthBar.style.width = "0";
            }

            // Validate if repeat password matches the original password
            if (repeatPass && password !== repeatPass) {
                repeatPasswordMessage.innerHTML =
                    "Repeat Password must be the same as Password";
                repeatPasswordMessage.style.color = "red";
            } else {
                repeatPasswordMessage.innerHTML = ""; // Clear message if passwords match
            }
        }

        function checkPasswordStrength(password) {
            let strength = 0;

            // Check password length
            if (password.length >= 8) strength++;

            // Check for lowercase, uppercase, digits, and special characters
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/\d/.test(password)) strength++;
            if (/[@$!%*?&#]/.test(password)) strength++;

            return strength;
        }
    </script>

    <script>
        const notifications = document.querySelector(".notifications"),
            buttons = document.querySelectorAll(".buttons .btn");

        // Object containing details for different types of toasts
        const toastDetails = {
            timer: 5000,
            success: {
                icon: "fa-circle-check",
                text: "Success: This is a success toast.",
            },
            error: {
                icon: "fa-circle-xmark",
                text: "Error: This is an error toast.",
            },
            warning: {
                icon: "fa-triangle-exclamation",
                text: "Warning: This is a warning toast.",
            },
            info: {
                icon: "fa-circle-info",
                text: "Info: This is an information toast.",
            },
        };

        function launchToast(params) {

        }

        const removeToast = (toast) => {
            toast.classList.add("hide");
            if (toast.timeoutId) clearTimeout(toast.timeoutId); // Clearing the timeout for the toast
            setTimeout(() => toast.remove(), 500); // Removing the toast after 500ms
        };

        const createToast = (id) => {
            // Getting the icon and text for the toast based on the id passed
            const {
                icon,
                text
            } = toastDetails[id];
            const toast = document.createElement("li"); // Creating a new 'li' element for the toast
            toast.className = `toast ${id}`; // Setting the classes for the toast
            // Setting the inner HTML for the toast
            toast.innerHTML = `<div class="column">
                         <i class="fa-solid ${icon}"></i>
                         <span>${text}</span>
                      </div>
                      <i class="fa-solid fa-xmark" onclick="removeToast(this.parentElement)"></i>`;
            notifications.appendChild(toast); // Append the toast to the notification ul
            // Setting a timeout to remove the toast after the specified duration
            toast.timeoutId = setTimeout(
                () => removeToast(toast),
                toastDetails.timer
            );
        };

        // Adding a click event listener to each button to create a toast when clicked
        buttons.forEach((btn) => {
            btn.addEventListener("click", () => createToast(btn.id));
        });
    </script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"
        integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
</body>

</html>

<?php

require_once './db conn.php';

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
                            window.location.href = './admin/homepage.php';
                          </script>";
                    break;

                case 'doctor':
                    $_SESSION['doctor_id'] = $userData['id'];
                    echo "<script>
                            alert('Successfully logged in!');
                            window.location.href = './doctor page/homepage.php';
                          </script>";
                    break;

                case 'patient':
                    $_SESSION['patient_id'] = $userData['id'];
                    echo "<script>
                            alert('Successfully logged in!');
                            window.location.href = './patient page/index.php';
                          </script>";
                    break;
            }
        } else if ($username == "" || $password == "") {
            echo "<script>
                            alert('Username or Password cannot be empty!');
                            window.location.href = './index.php';
                          </script>";
        } else {
            echo "<script>
                            alert('Invalid Username or Password!');
                            window.location.href = './index.php';
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
