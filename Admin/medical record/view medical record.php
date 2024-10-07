<?php


session_start();
$admin_id = $_SESSION['admin_id'];
$admin_name = $_SESSION['admin_name'];

// $appointment_id = $_GET['appointment_id'];
$appointment_id = 1;
require_once('../../db conn.php');

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
    $_SESSION['doctor_id'] = $appointment['doctor_id'];
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
    $_SESSION['doctor_name'] = $doctor['doctor_name'];
    $_SESSION['doctor_photo'] = $doctor['doctor_photo'];
}

$doctor_name = $_SESSION['doctor_name'];



// Fetch all appointment information
$sql = "SELECT * FROM appointment WHERE appointment_id = $appointment_id";
$result = mysqli_query($conn, $sql);
$appointment = mysqli_fetch_assoc($result);

// Fetch all patient information
$sql = "SELECT * FROM patient WHERE patient_id = $patient_id";
$result = mysqli_query($conn, $sql);
$patient = mysqli_fetch_assoc($result);


// Fetch medical record ID using appointment_id
$sql = "SELECT * FROM medical_record WHERE appointment_id = $appointment_id";
$result = mysqli_query($conn, $sql);
$medical_record = mysqli_fetch_assoc($result);
$medical_record_id = $medical_record['medical_record_id'];


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
$sql = "SELECT * FROM medical_conditions WHERE patient_id = $patient_id";
$condition_result = mysqli_query($conn, $sql);
$conditions = [
    'Eye Problem' => 'None',
    'Seizure' => 'None',
    'Epilepsy' => 'None',
    'Hearing Problem' => 'None',
    'Diabetes' => 'None',
    'Cardiovascular Disease' => 'None',
    'History of Strokes' => 'None',
    'Respiratory Problem' => 'None',
    'Kidney Problem' => 'None',
    'Stomach and Liver Problem' => 'None',
    'Pancreatic Problems' => 'None',
    'Anxiety and Depression' => 'None',
    'Other Mental Health Issue' => 'None',
    'Sleep Disorder' => 'None',
    'Neck or Back Problem' => 'None',
];
if (mysqli_num_rows($condition_result) > 0) {
    while ($row = mysqli_fetch_assoc($condition_result)) {
        $conditions[$row['condition_name']] = $row['condition_status'];
    }
}




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
                            href="../manage patient/patient_profile.php?id=<?php echo $patient_id ?>"
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
                            <p>Patient Name:</p>
                            <p><?php echo $patient['patient_name']  ?></p>
                        </td>
                        <td>
                            <p>Age:</p>
                            <p><?php

                                $dateOfBirth = $patient['d_o_b'];

                                // Create DateTime objects for the date of birth and the current date
                                $dob = new DateTime($dateOfBirth);
                                $now = new DateTime();

                                // Calculate the difference between the two dates
                                $age = $now->diff($dob)->y;

                                // Output the age
                                echo "Age: " . $age;
                                ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Phone Number:</p>
                            <p><?php echo $patient['phone number']  ?></p>
                        </td>
                        <td>
                            <p>Date of Birth:</p>
                            <p><?php echo $patient['d_o_b']  ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Email:</p>
                            <p><?php echo $patient['email']  ?></p>
                        </td>
                        <td>
                            <p>Gender:</p>
                            <p><?php echo $patient['gender']  ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p>Address:</p>
                            <p><?php echo $patient['address']  ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p>Emergency Contact Number:</p>
                            <p><?php echo $patient['emerg_num']  ?></p>
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
                    </tr>
                    <tr>
                        <td>
                            <?php echo $medical_record['notes']  ?>
                        </td>
                    </tr>
                </table>

            </div>
        </section>

        <!-- Medication -->


        <section>
            <div class="medication container mt-5">
                <table class="table" style="background-color: #fafbfc">
                    <h4 class="h4">Medication</h4>
                    <tr>
                        <th>Medication</th>
                        <th>Purpose</th>
                        <th>Dosage</th>
                        <th>Frequency</th>
                    </tr>
                    <?php
                    if ($medication_result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $medication_result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["medication_name"] . "</td>";
                            echo "<td>" . $row["purpose"] . "</td>";
                            echo "<td>" . $row["dosage"] . "</td>";
                            echo "<td>" . $row["frequency"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No medication found</td></tr>";
                    }
                    ?>
                </table>
                <?php

                ?>
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
                                    <p>Smoking History</p>
                                    <p><?php echo $row['smoking_history']; ?></p>
                                </td>
                                <td>
                                    <p>Alcohol Consumption</p>
                                    <p><?php echo $row['alcohol_consumption']; ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <p>Allergies History</p>
                                    <p><?php echo $row['allergies_history']; ?></p>
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
                            <th>I'm not sure</th>
                        </tr>

                        <tr>
                            <td>Eye Problem</td>
                            <td><input type="radio" name="eye_problem" value="None" <?php echo ($conditions['Eye Problem'] == 'None') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="eye_problem" value="Yes" <?php echo ($conditions['Eye Problem'] == 'Yes') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="eye_problem" value="I'm not sure" <?php echo ($conditions['Eye Problem'] == 'I\'m not sure') ? 'checked' : ''; ?> disabled></td>
                        </tr>
                        <tr>
                            <td>Seizure</td>
                            <td><input type="radio" name="seizure" value="None" <?php echo ($conditions['Seizure'] == 'None') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="seizure" value="Yes" <?php echo ($conditions['Seizure'] == 'Yes') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="seizure" value="I'm not sure" <?php echo ($conditions['Seizure'] == 'I\'m not sure') ? 'checked' : ''; ?> disabled></td>
                        </tr>
                        <tr>
                            <td>Epilepsy</td>
                            <td><input type="radio" name="epilepsy" value="None" <?php echo ($conditions['Epilepsy'] == 'None') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="epilepsy" value="Yes" <?php echo ($conditions['Epilepsy'] == 'Yes') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="epilepsy" value="I'm not sure" <?php echo ($conditions['Epilepsy'] == 'I\'m not sure') ? 'checked' : ''; ?> disabled></td>
                        </tr>
                        <tr>
                            <td>Hearing Problem</td>
                            <td><input type="radio" name="hearing_problem" value="None" <?php echo ($conditions['Hearing Problem'] == 'None') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="hearing_problem" value="Yes" <?php echo ($conditions['Hearing Problem'] == 'Yes') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="hearing_problem" value="I'm not sure" <?php echo ($conditions['Hearing Problem'] == 'I\'m not sure') ? 'checked' : ''; ?> disabled></td>
                        </tr>
                        <tr>
                            <td>Diabetes</td>
                            <td><input type="radio" name="diabetes" value="None" <?php echo ($conditions['Diabetes'] == 'None') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="diabetes" value="Yes" <?php echo ($conditions['Diabetes'] == 'Yes') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="diabetes" value="I'm not sure" <?php echo ($conditions['Diabetes'] == 'I\'m not sure') ? 'checked' : ''; ?> disabled></td>
                        </tr>
                        <tr>
                            <td>Cardiovascular Disease</td>
                            <td><input type="radio" name="cardiovascular_disease" value="None" <?php echo ($conditions['Cardiovascular Disease'] == 'None') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="cardiovascular_disease" value="Yes" <?php echo ($conditions['Cardiovascular Disease'] == 'Yes') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="cardiovascular_disease" value="I'm not sure" <?php echo ($conditions['Cardiovascular Disease'] == 'I\'m not sure') ? 'checked' : ''; ?> disabled></td>
                        </tr>
                        <tr>
                            <td>History of Strokes</td>
                            <td><input type="radio" name="history_of_strokes" value="None" <?php echo ($conditions['History of Strokes'] == 'None') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="history_of_strokes" value="Yes" <?php echo ($conditions['History of Strokes'] == 'Yes') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="history_of_strokes" value="I'm not sure" <?php echo ($conditions['History of Strokes'] == 'I\'m not sure') ? 'checked' : ''; ?> disabled></td>
                        </tr>
                        <tr>
                            <td>Respiratory Problem</td>
                            <td><input type="radio" name="respiratory_problem" value="None" <?php echo ($conditions['Respiratory Problem'] == 'None') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="respiratory_problem" value="Yes" <?php echo ($conditions['Respiratory Problem'] == 'Yes') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="respiratory_problem" value="I'm not sure" <?php echo ($conditions['Respiratory Problem'] == 'I\'m not sure') ? 'checked' : ''; ?> disabled></td>
                        </tr>
                        <tr>
                            <td>Kidney Problem</td>
                            <td><input type="radio" name="kidney_problem" value="None" <?php echo ($conditions['Kidney Problem'] == 'None') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="kidney_problem" value="Yes" <?php echo ($conditions['Kidney Problem'] == 'Yes') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="kidney_problem" value="I'm not sure" <?php echo ($conditions['Kidney Problem'] == 'I\'m not sure') ? 'checked' : ''; ?> disabled></td>
                        </tr>
                        <tr>
                            <td>Stomach and Liver Problem</td>
                            <td><input type="radio" name="stomach_liver_problem" value="None" <?php echo ($conditions['Stomach and Liver Problem'] == 'None') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="stomach_liver_problem" value="Yes" <?php echo ($conditions['Stomach and Liver Problem'] == 'Yes') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="stomach_liver_problem" value="I'm not sure" <?php echo ($conditions['Stomach and Liver Problem'] == 'I\'m not sure') ? 'checked' : ''; ?> disabled></td>
                        </tr>
                        <tr>
                            <td>Pancreatic Problems</td>
                            <td><input type="radio" name="pancreatic_problems" value="None" <?php echo ($conditions['Pancreatic Problems'] == 'None') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="pancreatic_problems" value="Yes" <?php echo ($conditions['Pancreatic Problems'] == 'Yes') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="pancreatic_problems" value="I'm not sure" <?php echo ($conditions['Pancreatic Problems'] == 'I\'m not sure') ? 'checked' : ''; ?> disabled></td>
                        </tr>
                        <tr>
                            <td>Anxiety and Depression</td>
                            <td><input type="radio" name="anxiety_depression" value="None" <?php echo ($conditions['Anxiety and Depression'] == 'None') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="anxiety_depression" value="Yes" <?php echo ($conditions['Anxiety and Depression'] == 'Yes') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="anxiety_depression" value="I'm not sure" <?php echo ($conditions['Anxiety and Depression'] == 'I\'m not sure') ? 'checked' : ''; ?> disabled></td>
                        </tr>
                        <tr>
                            <td>Other Mental Health Issue</td>
                            <td><input type="radio" name="mental_health_issue" value="None" <?php echo ($conditions['Other Mental Health Issue'] == 'None') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="mental_health_issue" value="Yes" <?php echo ($conditions['Other Mental Health Issue'] == 'Yes') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="mental_health_issue" value="I'm not sure" <?php echo ($conditions['Other Mental Health Issue'] == 'I\'m not sure') ? 'checked' : ''; ?> disabled></td>
                        </tr>
                        <tr>
                            <td>Sleep Disorder</td>
                            <td><input type="radio" name="sleep_disorder" value="None" <?php echo ($conditions['Sleep Disorder'] == 'None') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="sleep_disorder" value="Yes" <?php echo ($conditions['Sleep Disorder'] == 'Yes') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="sleep_disorder" value="I'm not sure" <?php echo ($conditions['Sleep Disorder'] == 'I\'m not sure') ? 'checked' : ''; ?> disabled></td>
                        </tr>
                        <tr>
                            <td>Neck or Back Problem</td>
                            <td><input type="radio" name="neck_back_problem" value="None" <?php echo ($conditions['Neck or Back Problem'] == 'None') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="neck_back_problem" value="Yes" <?php echo ($conditions['Neck or Back Problem'] == 'Yes') ? 'checked' : ''; ?> disabled></td>
                            <td><input type="radio" name="neck_back_problem" value="I'm not sure" <?php echo ($conditions['Neck or Back Problem'] == 'I\'m not sure') ? 'checked' : ''; ?> disabled></td>
                        </tr>
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
                                <p>Doctor Signature</p>
                                <p>Doctor Signature</p>
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
            <a href="../manage patient/patient_profile.php?patient_id=<?php echo $patient_id ?>">
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