<?php

session_start();
require_once('../../db conn.php');

// $appointment_id = 107;
$medical_record_id = $_GET['medical_record_id'];
if (!isset($_GET['medical_record_id'])) {
    die("Appointment ID not provided.");
}




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


function getAppointmentData($conn, $appointment_id)
{
    $sql = "SELECT * FROM appointment WHERE appointment_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}





$Appointmentrow = getAppointmentData($conn, $appointment_id);

$doctor_id = $Appointmentrow['doctor_id'];

function getDoctorData($conn, $doctor_id)
{
    $sql = "SELECT * FROM doctor WHERE doctor_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

$DoctorRow = getDoctorData($conn, $doctor_id);

if (!$DoctorRow) {
    die("Doctor not found.");
}

$doctor_name = $DoctorRow['doctor_name'];
$mmc = $DoctorRow['mmc'];


$patient_id = $Appointmentrow['patient_id'];

function getPatientData($conn, $patient_id)
{
    $sql = "SELECT * FROM patient WHERE patient_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}



$PatientRow = getPatientData($conn, $patient_id);

if (!$PatientRow) {
    die("Patient not found.");
}

if ($PatientRow['patient_id'] != $patient_id) {
    die("Invalid patient ID.");
}

$patient_name = $PatientRow['patient_name'];
$patient_gender = $PatientRow['gender'];
$patient_email = $PatientRow['email'];
$patient_phone = $PatientRow['phone number'];
$patient_address = $PatientRow['address'];
$patient_em_contact = $PatientRow['emerg_num'];
$patient_dob = $PatientRow['d_o_b'];


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


// Fetch current medical condition using medical_record_id
$sql = "SELECT * FROM medical_conditions WHERE medical_record_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $medical_record_id);
$stmt->execute();
$medical_condition_result = $stmt->get_result();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
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

    <form id="content" method="post" action="./update medical history.php">
        <!-- Header -->
        <header>
            <div class="container text-center bg-primary p-4 mb-5">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <a href="../appointment record.php" class="btn btn-light previous-btn">&#8249;</a>
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

                            <input type="text" name="patient_id" class="form-control" value="<?php echo $patient_id; ?>" hidden>
                            <label for="patient-name">Patient Name</label>
                            <input type="text" name="patient-name" class="form-control" disabled value="<?php echo $patient_name; ?>" />
                        </td>
                        <td>
                            <label for="medical-record-id">Medical Record ID</label>
                            <input type="text" name="medical_record_id" class="form-control" readonly value="<?php echo $medical_record_id; ?>" />

                            <label for="patient-age">Age</label>
                            <input type="text" name="patient-age" class="form-control" disabled value="<?php
                                                                                                        // Create DateTime objects for the date of birth and the current date
                                                                                                        $dob = new DateTime($patient_dob);
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
                            <input type="text" name="phone-number" class="form-control" disabled value="<?php echo $patient_phone; ?>" />
                        </td>
                        <td>
                            <label for="dob">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" disabled value="<?php echo $patient_dob ?>" />

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" disabled value="<?php echo $patient_email ?>" />
                        </td>
                        <td>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" disabled <?php if ($patient_gender == 'Male') echo 'checked'; ?> />
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female" disabled <?php if ($patient_gender == 'Female') echo 'checked'; ?> />
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="other" value="other" disabled <?php if ($patient_gender == 'other') echo 'checked'; ?> />
                                    <label class="form-check-label" for="other">Other</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="patient-address">Address</label>
                            <input type="text" name="patient-address" class="form-control" disabled value="<?php echo $patient_address ?>" />
                        </td>
                        <td>
                            <label for="patient-em-contact">Emergency Contact Number</label>
                            <input type="text" name="patient-em-contact" class="form-control" disabled value="<?php echo $patient_em_contact ?>" />
                        </td>
                    </tr>
                </table>
            </div>
        </section>

        <!-- Notes -->
        <section>
            <div class="notes container mt-5">
                <h4>Notes</h4>

                <textarea name="notes" id="notes" class="form-control"><?php
                                                                        if ($medical_record['notes'] == NULL) {
                                                                            echo "No notes found";
                                                                        } else {
                                                                            echo $medical_record['notes'];
                                                                        }
                                                                        ?></textarea>
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
                        <div class="col-auto">
                            <button id="addRowBtnMed" class="btn btn-primary mr-2" name="insert_new_row">+</button>
                            <button id="removeRowBtnMed" class="btn btn-primary" name="delete_latest_row">-</button>
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
                                echo "<td><input type='text' name='medication_name[]' class='form-control' placeholder='Medication' value='" . htmlspecialchars($row["medication_name"]) . "' /></td>";
                                echo "<td><input type='text' name='purpose[]' class='form-control' placeholder='Purpose' value='" . htmlspecialchars($row["purpose"]) . "' /></td>";
                                echo "<td><input type='text' name='dosage[]' class='form-control' placeholder='Dosage' value='" . htmlspecialchars($row["dosage"]) . "' /></td>";
                                echo "<td><input type='text' name='frequency[]' class='form-control' placeholder='Frequency' value='" . htmlspecialchars($row["frequency"]) . "' /></td>";
                                echo "</tr>";
                            }
                        } else {
                        ?>
                            <tr>
                                <td><input type="text" name="medication_name[]" class="form-control" placeholder="Medication" /></td>
                                <td><input type="text" name="purpose[]" class="form-control" placeholder="Purpose" /></td>
                                <td><input type="text" name="dosage[]" class="form-control" placeholder="Dosage" /></td>
                                <td><input type="text" name="frequency[]" class="form-control" placeholder="Frequency" /></td>
                            </tr>
                        <?php
                        }
                        ?>

                    </tbody>
                </table>





            </div>
        </section>

        <br /><br />

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
                                    <label for="smoking">Smoking History</label>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="smoking" value="No" required
                                                <?php if ($row['smoking_history'] == 'No') echo 'checked'; ?> />
                                            <label class="form-check-label">No</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="smoking" value="Yes" required
                                                <?php if ($row['smoking_history'] === 'Yes') echo 'checked'; ?> />
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <label for="alcohol">Alcohol Consumption</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="alcohol" value="No" required
                                            <?php if ($row['alcohol_consumption'] == 'No') echo 'checked'; ?> />
                                        <label class="form-check-label">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="alcohol" value="Yes" required
                                            <?php if ($row['alcohol_consumption'] === 'Yes') echo 'checked'; ?> />
                                        <label class="form-check-label">Yes</label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <label for="allergies">Allergies History</label>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="allergies_choice" id="no" value="no" required
                                            <?php if ($row['allergies_history'] == NULL || $row['allergies_history'] === 'No') echo 'checked'; ?>
                                            onclick="toggleAllergiesInput(false)" />
                                        <label class="form-check-label" for="no">No</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="allergies_choice" id="yes" value="yes" required
                                            <?php if ($row['allergies_history'] !== NULL && $row['allergies_history'] !== 'No') echo 'checked'; ?>
                                            onclick="toggleAllergiesInput(true)" />
                                        <label class="form-check-label" for="yes">Yes ; Specify</label>
                                    </div>
                                    <br>

                                    <!-- Allergies input field -->
                                    <input style="width: 20%;" type="text" name="allergies" class="form-control" id="allergies-input" placeholder="Specify allergies"
                                        value="<?php echo ($row['allergies_history'] !== 'No') ? htmlspecialchars($row['allergies_history']) : ''; ?>"
                                        style="display: <?php echo ($row['allergies_history'] !== NULL && $row['allergies_history'] !== 'No') ? 'block' : 'none'; ?>;" />

                                    <script>
                                        function toggleAllergiesInput(show) {
                                            const allergiesInput = document.getElementById('allergies-input');
                                            if (show) {
                                                allergiesInput.style.display = 'block';
                                            } else {
                                                allergiesInput.style.display = 'none';
                                                allergiesInput.value = ''; // Clear the input when "No" is selected
                                            }
                                        }
                                    </script>

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
                    ?>

                        <table class="table" style="background-color: #fafbfc">
                            <tr>
                                <th>Temperature</th>
                                <th>Blood Pressure</th>
                                <th>Heart Rate</th>
                                <th>Respiratory Rate</th>
                            </tr>
                            <tr>
                                <td><input type='text' name='temperature' class='form-control' placeholder="Temperature" value="<?php echo $temperature; ?>" /></td>
                                <td><input type='text' name='blood pressure' class='form-control' placeholder="Blood Pressure" value="<?php echo $blood_pressure; ?>" /></td>
                                <td><input type='text' name='heart rate' class='form-control' placeholder="Heart Rate" value="<?php echo $heart_rate; ?>" /></td>
                                <td><input type='text' name='respiratory rate' class='form-control' placeholder="Respiratory Rate" value="<?php echo $respiratory_rate; ?>" /></td>
                            </tr>
                        </table>

                    <?php
                    } else {
                        echo "<p>No physical exam data found</p>";
                    }
                    ?>

                </div>
            </section>

        </div>



        <!-- Current Medical Condition -->
        <div class="page-break">
            <section>
                <div class="medical-condition container mt-5">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3>Current Medical Condition</h3>
                            <p>Kindly indicate if you have the following medical condition:</p>
                        </div>

                        <div class="col-auto">
                            <button id="addRowBtnCond" class="btn btn-primary mr-2" name="insert_new_row">+</button>
                            <button id="removeRowBtnCond" class="btn btn-primary" name="delete_latest_row">-</button>
                        </div>
                    </div>

                    <table id="conditionTable" class="table text-center" style="background-color: #fafbfc">
                        <tr>
                            <th>Medical Condition</th>
                            <th>None</th>
                            <th>Yes</th>
                            <th>Unsure</th>
                        </tr>

                        <?php
                        if (mysqli_num_rows($medical_condition_result) > 0) {
                            while ($row = mysqli_fetch_assoc($medical_condition_result)) {
                                $condition_id = $row['condition_id'];

                                echo "<tr>";
                                // Editable condition name input field
                                echo "<td><input type='text' name='condition_name[$condition_id]' value='" . htmlspecialchars($row['condition_name']) . "' class='form-control' /></td>";

                                // Radio buttons for selecting condition status
                                echo "<td><input class='form-check-input' type='radio' name='medical_condition_status[$condition_id]' value='None' " . ($row['condition_status'] == "None" ? "checked" : "") . " /></td>";
                                echo "<td><input class='form-check-input' type='radio' name='medical_condition_status[$condition_id]' value='Yes' " . ($row['condition_status'] == "Yes" ? "checked" : "") . " /></td>";
                                echo "<td><input class='form-check-input' type='radio' name='medical_condition_status[$condition_id]' value='Unsure' " . ($row['condition_status'] == "Unsure" ? "checked" : "") . " /></td>";

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

                    <table id="diagnosisTable" class="table" style="background-color: #fafbfc">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="h4">Diagnosis Examination</h4>

                            </div>
                            <div class="col-auto">
                                <button id="addRowBtnDiagnosis" class="btn btn-primary mr-2" name="insert_new_row">+</button>
                                <button id="removeRowBtnDiagnosis" class="btn btn-primary" name="delete_latest_row">-</button>

                            </div>
                        </div>
                        <br>
                        <thead>
                            <th>Procedure Name</th>
                            <th>Purpose</th>
                            <th>Result</th>
                        </thead>
                        <tr>
                            <?php
                            if (mysqli_num_rows($diagnosis_result) > 0) {
                                while ($row = mysqli_fetch_assoc($diagnosis_result)) { ?>
                                    <td><input type='text' name='procedure_name[]' class='form-control' placeholder="Procedure Name" value="<?php echo  $row["procedure_name"] ?>" /></td>
                                    <td><input type='text' name='diagnosis_purpose[]' class='form-control' placeholder="Purpose" value="<?php echo  $row["purpose"] ?>" /></td>
                                    <td><input type='text' name='diagnosis_result[]' class='form-control' placeholder="Result" value="<?php echo  $row["result"] ?>" /></td>
                        </tr>
                <?php

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
                                <input type="doctor name" class="form-control" disabled value="<?php echo $doctor_name ?>">
                            </td>
                            <td>
                                <p>Registration Number</p>
                                <input type="doctor name" class="form-control" disabled value="<?php echo $mmc ?>">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p>Date Signed</p>
                                <input type="doctor sign date" class="form-control" readonly value="<?php echo date('d M Y') ?>">
                            </td>
                        </tr>
                    </table>
                </div>
            </section>
        </div>

        <div class="container text-center" style="display: flex; justify-content: space-evenly; gap: 1px;">

            <input type="reset" value="Reset" class="btn btn-danger">
            <a href="../appointment record.php" class="btn btn-primary">Back</a>
            <input type="submit" value="Submit" class="btn btn-success">

        </div>




        <br><br>
    </form>



    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



    <!-- <script>
    $(document).ready(function() {
      // Add and remove event listeners for all table types
      addEventListeners('#addRowBtnMed', '#removeRowBtnMed', '#medicationTable', [{
          name: 'medication',
          placeholder: 'Medication'
        },
        {
          name: 'purpose',
          placeholder: 'Purpose'
        },
        {
          name: 'dosage',
          placeholder: 'Dosage'
        },
        {
          name: 'frequency',
          placeholder: 'Frequency'
        }
      ]);



      addEventListeners('#addRowBtnDiagnosis', '#removeRowBtnDiagnosis', '#diagnosisTable', [{
          name: 'procedure_name',
          placeholder: 'Procedure Name'
        },
        {
          name: 'purpose',
          placeholder: 'Purpose'
        },
        {
          name: 'result',
          placeholder: 'Result'
        }
      ]);
    });

    function addEventListeners(addBtnSelector, removeBtnSelector, tableSelector, columns) {
      $(addBtnSelector).click(function(event) {
        event.preventDefault();
        addRow(tableSelector, columns);
      });

      $(removeBtnSelector).click(function(event) {
        event.preventDefault();
        removeRow(tableSelector);
      });
    }

    function addRow(tableSelector, columns) {
      let markup = "<tr>";
      columns.forEach(column => {
        markup += `<td><input type='text' name='${column.name}' class='form-control' placeholder='${column.placeholder}' /></td>`;
      });
      markup += "</tr>";
      $(tableSelector + ' tbody').append(markup);
    }

    function removeRow(tableSelector) {
      var $tableBody = $(tableSelector + ' tbody');
      if ($tableBody.find('tr').length > 1) {
        $tableBody.find('tr:last').remove();
      }
    }
  </script> -->

    <script>
        $(document).ready(function() {
            // Add and remove event listeners for all table types
            addEventListeners('#addRowBtnMed', '#removeRowBtnMed', '#medicationTable', [{
                    name: 'medication_name',
                    placeholder: 'Medication'
                },
                {
                    name: 'purpose',
                    placeholder: 'Purpose'
                },

                {
                    name: 'dosage',
                    placeholder: 'Dosage'
                },
                {
                    name: 'frequency',
                    placeholder: 'Frequency'
                }
            ]);


            addEventListeners('#addRowBtnCond', '#removeRowBtnCond', '#conditionTable', [{
                    name: 'medical_condition',
                    placeholder: 'Medical Condition'
                },
                {
                    name: 'medical_condition_status[]',
                    value: 'no',
                    placeholder: 'No',
                    type: 'radio'
                },
                {
                    name: 'medical_condition_status[]',
                    value: 'unsure',
                    placeholder: 'Unsure',
                    type: 'radio'
                },
                {
                    name: 'medical_condition_status[]',
                    value: 'yes',
                    placeholder: 'Yes',
                    type: 'radio'
                }
            ]);

            addEventListeners('#addRowBtnDiagnosis', '#removeRowBtnDiagnosis', '#diagnosisTable', [{
                    name: 'procedure_name',
                    placeholder: 'Procedure Name'
                },
                {
                    name: 'diagnosis_purpose',
                    placeholder: 'Purpose'
                },
                {
                    name: 'diagnosis_result',
                    placeholder: 'Result'
                }
            ]);
        });

        function addEventListeners(addBtnSelector, removeBtnSelector, tableSelector, columns) {
            $(addBtnSelector).click(function(event) {
                event.preventDefault();
                addRow(tableSelector, columns);
            });

            $(removeBtnSelector).click(function(event) {
                event.preventDefault();
                removeRow(tableSelector);
            });
        }

        function addRow(tableSelector, columns) {
            let markup = "<tr>";
            let rowIndex = $(tableSelector + ' tbody tr').length + 1;
            columns.forEach((column) => {
                if (column.type === 'radio') {
                    // For radio buttons, generate a group of radio buttons with unique names per row
                    markup += `
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="condition_${rowIndex}_${column.name}" value="${column.placeholder.toLowerCase()}" id="${column.name + rowIndex}" />
                           
                        </div>
                    </td>
                `;
                } else {
                    // For text input fields
                    markup += `<td><input type="text" name="${column.name}[]" class="form-control" placeholder="${column.placeholder}" /></td>`;
                }
            });
            markup += "</tr>";
            $(tableSelector + ' tbody').append(markup);
        }

        function removeRow(tableSelector) {
            var $tableBody = $(tableSelector + ' tbody');
            if ($tableBody.find('tr').length > 1) {
                $tableBody.find('tr:last').remove();
            }
        }
    </script>

    <script>
        // JavaScript to show/hide allergies input field based on Yes/No selection
        document.getElementById('yes').addEventListener('click', function() {
            document.getElementById('allergies-input').style.display = 'block';
        });

        document.getElementById('no').addEventListener('click', function() {
            document.getElementById('allergies-input').style.display = 'none';
        });
    </script>


</body>

</html>