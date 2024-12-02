<?php


require_once('../../db conn.php');
session_start();


$doctor_id = $_SESSION['doctor_id'];
$doctor_name = $_SESSION['doctor_name'];

$medical_record_id = $_GET['medical_record_id'];



function getMedicalRecordData($conn, $medical_record_id)
{
    $sql = "SELECT * FROM medical_record WHERE medical_record_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $medical_record_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

$MedicalRecordRow = getMedicalRecordData($conn, $medical_record_id);

$appointment_id = $MedicalRecordRow['appointment_id'];

// $appointment_id = $_GET['appointment_id'];
// $appointment_id = 1;

// Function to fetch all appointment information
function fetchAllAppointmentInfo($conn, $appointment_id)
{
    $sql = "SELECT * FROM appointment WHERE appointment_id = $appointment_id";
    $result = mysqli_query($conn, $sql);

    $appointmentInfo = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $appointmentInfo[] = $row;
    }

    return $appointmentInfo;
}

// Fetch all appointment information
$allAppointmentInfo = fetchAllAppointmentInfo($conn, $appointment_id);

foreach ($allAppointmentInfo as $appointment) {
    $_SESSION['patient_id'] = $appointment['patient_id'];
    $doctor_id = $appointment['doctor_id'];
}

$patient_id = $appointment['patient_id'];
$doctor_id = $appointment['doctor_id'];
// Function to fetch all information from the patient table
function fetchAllPatientInfo($conn, $patient_id)
{
    $sql = "SELECT * FROM patient WHERE patient_id = $patient_id";
    $result = mysqli_query($conn, $sql);

    $patientInfo = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $patientInfo[] = $row;
    }

    return $patientInfo;
}

// Fetch all patient information
$allPatientInfo = fetchAllPatientInfo($conn, $patient_id);

foreach ($allPatientInfo as $patient) {
    $_SESSION['patient_name'] = $patient['patient_name'];
    $_SESSION['patient_photo'] = $patient['patient_photo'];
}

$patient_name = $_SESSION['patient_name'];

$doctor_id = $appointment['doctor_id'];


function fetchAllDoctorInfo($conn, $doctor_id)
{
    $sql = "SELECT * FROM doctor WHERE doctor_id = $doctor_id";
    $result = mysqli_query($conn, $sql);

    $doctorInfo = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $doctorInfo[] = $row;
    }

    return $doctorInfo;
}

// Fetch all doctor information
$allDoctorInfo = fetchAllDoctorInfo($conn, $doctor_id);

foreach ($allDoctorInfo as $doctor) {
    $doctor_name = $doctor['doctor_name'];

}





// Fetch all appointment information
$sql = "SELECT * FROM appointment WHERE appointment_id = $appointment_id";
$result = mysqli_query($conn, $sql);
$appointment = mysqli_fetch_assoc($result);

// Fetch all patient information
$sql = "SELECT * FROM patient WHERE patient_id = $patient_id";
$result = mysqli_query($conn, $sql);
$patient = mysqli_fetch_assoc($result);


// Fetch Medical Record data using medical_record_id
$sql = "SELECT * FROM medical_record WHERE medical_record_id = $medical_record_id";
$medical_record_result = mysqli_query($conn, $sql);


// Fetch physical exam data using medical_record_id
$sql = "SELECT * FROM physical_exam WHERE medical_record_id = $medical_record_id";
$physical_exam_result = mysqli_query($conn, $sql);

// Fetch medications using medical_record_id
$sql = "SELECT * FROM medication WHERE medical_record_id = $medical_record_id";
$medication_result = mysqli_query($conn, $sql);

// Fetch diagnosis using medical_record_id
$sql = "SELECT * FROM diagnosis WHERE medical_record_id = $medical_record_id";
$diagnosis_result = mysqli_query($conn, $sql);

//Fetch lifestyle using patient_id
$sql = "SELECT * FROM patient_lifestyle WHERE patient_id = $patient_id";
$lifestyle_result = mysqli_query($conn, $sql);

//Fetch current medical condition using patient_id
$sql = "SELECT * FROM medical_conditions WHERE medical_record_id = $medical_record_id";
$condition_result = mysqli_query($conn, $sql);


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous" />
    <link
        rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>

<body>
    <style>
        a {
            border-radius: 10px;
            text-decoration: none;
            display: inline-block;
            padding: 8px 16px;
        }

        a:hover {
            background-color: #9fa6b2;
            color: white;
            text-decoration: none;
        }

        .previous {
            background-color: #f1f1f1;
            color: black;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>

    <div id="content">
        <!-- Header -->
        <header>
            <div class="container text-center bg-primary p-4 mb-5">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <a
                            href="../appointment record.php"
                            class="btn btn-light previous-btn">&#8249;</a>


                    </div>
                    <div class="col-md-4">
                        <h3 class="text-white">Patient Medical Record</h3>
                    </div>
                </div>
            </div>
        </header>

        <!-- Patient Personal Information -->

        <section>
            <div class="patient-information container mt-2">
                <h4 class="h4">Patient Information</h4>
                <table class="table" style="background-color: #fafbfc">
                    <tr>
                        <td>
                            <label for="appointment_id">Appointment ID</label>
                            <input type="text" name="appointment_id" class="form-control" disabled value="<?php echo $appointment_id; ?>">
                            <label for="patient-name">Patient Name</label>
                            <input type="text" name="patient-name" class="form-control" disabled value="<?php echo $patient_name; ?>" />
                        </td>
                        <td>
                            <label for="medical-record-id">Medical Record ID</label>
                            <input type="text" name="medical-record-id" class="form-control" disabled value="<?php echo $medical_record_id; ?>" />

                            <label for="patient-age">Age</label>
                            <input type="text" name="patient-age" class="form-control" disabled value="<?php
                                                                                                        // Create DateTime objects for the date of birth and the current date
                                                                                                        $dob = new DateTime($patient['d_o_b']);
                                                                                                        $now = new DateTime();

                                                                                                        // Calculate the difference between the two dates
                                                                                                        $age = $now->diff($dob)->y;

                                                                                                        // Output the age
                                                                                                        echo $age; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="phone-number">Phone Number</label>
                            <input type="text" name="phone-number" class="form-control" disabled value="<?php echo $patient['phone number']; ?>" />
                        </td>
                        <td>
                            <label for="dob">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" disabled value="<?php echo $patient['d_o_b'] ?>" />

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" disabled value="<?php echo $patient['email'] ?>" />
                        </td>
                        <td>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" disabled <?php if ($patient['gender'] == 'Male') echo 'checked'; ?> />
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female" disabled <?php if ($patient['gender'] == 'Female') echo 'checked'; ?> />
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="other" value="other" disabled <?php if ($patient['gender'] == 'other') echo 'checked'; ?> />
                                    <label class="form-check-label" for="other">Other</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="patient-address">Address</label>
                            <input type="text" name="patient-address" class="form-control" disabled value="<?php echo $patient['address'] ?>" />
                        </td>
                        <td>
                            <label for="patient-em-contact">Emergency Contact Number</label>
                            <input type="text" name="patient-em-contact" class="form-control" disabled value="<?php echo $patient['emerg_num'] ?>" />
                        </td>
                    </tr>
                </table>
            </div>
        </section>

        <!-- Notes -->
        <section>
            <div class="notes container mt-5">
                <table class="table" style="background-color: #fafbfc">
                    <h4 class="h4">Notes</h4>
                    <tr>
                        <th>Appointment Notes</th>
                        <?php if ($medical_record_result && mysqli_num_rows($medical_record_result) > 0) {
                            $medical_record = mysqli_fetch_assoc($medical_record_result); ?>
                    </tr>
                    <tr>
                        <td>
                        <?php
                            // Display the notes
                            if ($medical_record['notes'] == NULL) {
                                echo "No notes found";
                            } else {
                                echo htmlspecialchars($medical_record['notes']); // Use htmlspecialchars to prevent XSS
                            }
                        } else {
                            echo "Medical record not found";
                        }
                        ?>
                        </td>
                    </tr>
                </table>

            </div>
        </section>

        <!-- Medication -->
        <section>
            <div class="medication container mt-5">
                <table id="medicationTable" class="table" style="background-color: #fafbfc">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="h4">Medication</h4>
                        </div>

                    </div>
                    <br>
                    <thead>
                        <th>Medication</th>
                        <th>Purpose</th>
                        <th>Dosage</th>
                        <th>Frequency</th>
                    </thead>

                    <tbody>
                        <?php
                        if ($medication_result->num_rows > 0) {
                            // Output data of each row
                            while ($row = $medication_result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td><p>" . htmlspecialchars($row["medication_name"]) . "</p></td>";
                                echo "<td><p>" . htmlspecialchars($row["purpose"]) . "</p></td>";
                                echo "<td><p>" . htmlspecialchars($row["dosage"]) . "</p></td>";
                                echo "<td><p>" . htmlspecialchars($row["frequency"]) . "</p></td>";
                                echo "</tr>";
                            }
                        } else {
                        ?>
                            <tr>
                                <td colspan="4">
                                    <p>No medication data found</p>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>


                    </tbody>
                </table>





            </div>
        </section>



        <!-- Patient Lifestyle -->
        <div class="page-break">
            <section>
                <div class="patient-lifestyle container mt-5">
                    <h4 class="h4">Patient Lifestyle</h4>
                    <table class="table" style="background-color: #fafbfc">
                        <?php if (mysqli_num_rows($lifestyle_result) > 0) {
                            $row = mysqli_fetch_assoc($lifestyle_result);
                        ?>
                            <tr>
                                <td>
                                    <b>Smoking History</b>
                                    <p></p>

                                    <p><?php
                                        if ($row['smoking_history'] == NULL) {
                                            echo "No smoking history found";
                                        } else {
                                            echo $row['smoking_history'];
                                        }
                                        ?></p>
                                </td>
                                <td>
                                    <b>Alcohol Consumption</b>
                                    <p></p>
                                    <p>
                                        <?php
                                        if ($row['alcohol_consumption'] == NULL) {
                                            echo "No alcohol consumption found";
                                        } else {
                                            echo $row['alcohol_consumption'];
                                        }
                                        ?>

                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <b>Allergies History</b>
                                    <p></p>
                                    <p>
                                        <?php
                                        if ($row['allergies_history'] == NULL) {
                                            echo "No allergies history found";
                                        } else {
                                            echo $row['allergies_history'];
                                        }
                                        ?>

                                    </p>
                                </td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td colspan="2">
                                    <p>No lifestyle data found for this patient</p>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </section>
        </div>

        <!-- Physical Exam  -->
        <div class="page-break">
            <section>
                <div class="physical-exam container mt-5">
                    <h3>Physical Exam Date</h3>
                    <?php
                    if (mysqli_num_rows($physical_exam_result) > 0) {
                        // Fetch the data
                        $row = mysqli_fetch_assoc($physical_exam_result);
                        $exam_date = $row["exam_date"];
                        $temperature = $row["temperature"];
                        $blood_pressure = $row["blood_pressure"];
                        $heart_rate = $row["heart_rate"];
                        $respiratory_rate = $row["respiratory_rate"];

                        // Display date
                        echo "<p>" . $exam_date . "</p>";
                    } else {
                        echo "<p>No physical exam data found</p>";
                    }
                    ?>

                    <table class="table" style="background-color: #fafbfc">
                        <tr>
                            <th>Temperature</th>
                            <th>Blood Pressure</th>
                            <th>Heart Rate</th>
                            <th>Respiratory Rate</th>
                        </tr>
                        <?php
                        if (mysqli_num_rows($physical_exam_result) > 0) {
                            // Display table data
                            echo "<tr>";
                            echo "<td>" . $temperature . "</td>";
                            echo "<td>" . $blood_pressure . "</td>";
                            echo "<td>" . $heart_rate . "</td>";
                            echo "<td>" . $respiratory_rate . "</td>";
                            echo "</tr>";
                        } else {
                            echo "<tr><td colspan='4'>No physical exam data found</td></tr>";
                        }
                        ?>
                    </table>

                </div>
            </section>
        </div>

        <!-- Current Medical Condition -->
        <div class="page-break">
            <section>
                <div class="medical-condition container mt-5">
                    <h3>Current Medical Condition</h3>
                    <p>Kindly indicate if you have the following medical condition:</p>

                    <table class="table" style="background-color: #fafbfc">
                        <tr>
                            <th>Medical Condition</th>
                            <th>None</th>
                            <th>Yes</th>
                            <th>Unsure</th>
                        </tr>

                        <?php
                        if (mysqli_num_rows($condition_result) > 0) {
                            while ($row = mysqli_fetch_assoc($condition_result)) {
                                echo "<tr>";
                                echo "<td>" . $row["condition_name"] . "</td>";
                                if ($row["condition_status"] == "None") {
                                    echo "<td>&#10003;</td>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                } else if ($row["condition_status"] == "Yes") {
                                    echo "<td></td>";
                                    echo "<td>&#10003;</td>";
                                    echo "<td></td>";
                                } else {
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    echo "<td>&#10003;</td>";
                                }
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No medical condition data found</td></tr>";
                        }
                        ?>
                    </table>
                </div>
            </section>
        </div>

        <!-- Diagnosis -->
        <div class="page-break">
            <section>
                <div class="diagnosis container mt-5">
                    <h3>Diagnosis Examination</h3>
                    <table class="table" style="background-color: #fafbfc">
                        <tr>
                            <th>Procedure Name</th>
                            <th>Purpose</th>
                            <th>Result</th>
                        </tr>
                        <?php
                        if (mysqli_num_rows($diagnosis_result) > 0) {
                            while ($row = mysqli_fetch_assoc($diagnosis_result)) {
                                echo "<tr>";
                                echo "<td>" . $row["procedure_name"] . "</td>";
                                echo "<td>" . $row["purpose"] . "</td>";
                                echo "<td>" . $row["result"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No physical exam data found</td></tr>";
                        }
                        ?>
                    </table>
                </div>
            </section>
        </div>

        <!-- Doctor Signature -->
        <div class="page-break">
            <section>
                <div class="doctor-sign container mt-5">
                    <h4 class="h4">Doctor Section</h4>
                    <table class="table" style="background-color: #fafbfc">
                        <tr>
                            <td>
                                <p>Doctor Name</p>
                                <p><?php echo $doctor['doctor_name']  ?></p>
                            </td>
                            <td>
                                <p>Registration Number</p>
                                <p><?php echo $doctor['mmc']  ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p>Appointment Date & Time</p>
                                <p><?php echo $appointment['date']  ?></p>
                                <p><?php echo $appointment['timeslot']  ?></p>
                            </td>
                        </tr>
                    </table>
                </div>
            </section>
        </div>

        <div class="container text-center">
            <a href="../appointment record.php">
                <button class="btn btn-primary previous-btn">Back</button>
            </a>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>