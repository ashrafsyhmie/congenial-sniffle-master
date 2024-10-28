<?php

require_once('../../db conn.php');
session_start();

$admin_id = $_SESSION['admin_id'];
$admin_name = $_SESSION['admin_name'];

$appointment_id = $_GET['appointment_id'];

// Function to fetch information by ID
function fetchInfoById($conn, $table, $id_column, $id_value)
{
    $stmt = $conn->prepare("SELECT * FROM $table WHERE $id_column = ?");
    $stmt->bind_param("i", $id_value);
    $stmt->execute();
    $result = $stmt->get_result();
    $info = $result->fetch_assoc();
    $stmt->close();

    return $info ? $info : [];
}

// Fetch appointment information
$appointment = fetchInfoById($conn, 'appointment', 'appointment_id', $appointment_id);

if (!empty($appointment)) {
    $_SESSION['patient_id'] = $appointment['patient_id'];
    $_SESSION['doctor_id'] = $appointment['doctor_id'];

    $patient_id = $appointment['patient_id'];
    $doctor_id = $appointment['doctor_id'];

    // Fetch patient information
    $patient = fetchInfoById($conn, 'patient', 'patient_id', $patient_id);
    if (!empty($patient)) {
        $_SESSION['patient_name'] = $patient['patient_name'];
        $_SESSION['patient_photo'] = $patient['patient_photo'];
    }

    // Fetch doctor information
    $doctor = fetchInfoById($conn, 'doctor', 'doctor_id', $doctor_id);
    if (!empty($doctor)) {
        $_SESSION['doctor_name'] = $doctor['doctor_name'];
        $_SESSION['doctor_photo'] = $doctor['doctor_photo'];
    }





    // Fetch current medical conditions
    $stmt = $conn->prepare("SELECT * FROM medical_conditions WHERE medical_record_id = ?");
    $stmt->bind_param("i", $medical_record_id);
    $stmt->execute();
    $condition_result = $stmt->get_result();

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

    if ($condition_result->num_rows > 0) {
        while ($row = $condition_result->fetch_assoc()) {
            $conditions[$row['condition_name']] = $row['condition_status'];
        }
    }
    $stmt->close();
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

        <form action="./insert new medical history.php" method="post">

            <!-- Patient Personal Information -->

            <section>
                <div class="patient-information container mt-2">
                    <h4 class="h4">Patient Information</h4>
                    <table class="table" style="background-color: #fafbfc">
                        <tr>
                            <td>
                                <label for="appointment_id">Appointment ID</label>
                                <input type="text" name="appointment_id" class="form-control" readonly value="<?php echo $appointment_id; ?>">
                                <label for="patient-name">Patient Name</label>
                                <input type="text" name="patient-name" class="form-control" disabled value="<?php echo $patient['patient_name'] ?>" />
                            </td>
                            <td>


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
                        </tr>
                        <tr>
                            <td>
                                <textarea name="notes" id="notes" class="form-control"></textarea>
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


                        <tr>
                            <td><input type="text" name="medication_name[]" class="form-control" placeholder="Medication" /></td>
                            <td><input type="text" name="purpose[]" class="form-control" placeholder="Purpose" /></td>
                            <td><input type="text" name="dosage[]" class="form-control" placeholder="Dosage" /></td>
                            <td><input type="text" name="frequency[]" class="form-control" placeholder="Frequency" /></td>
                        </tr>
                    </table>





                </div>
            </section>

            <!-- Patient Lifestyle -->
            <div class="page-break">
                <section>
                    <div class="patient-lifestyle container mt-5">
                        <h4 class="h4">Patient Lifestyle</h4>
                        <table class="table" style="background-color: #fafbfc">
                            <tr>
                                <td>
                                    <label for="smoking">Smoking History</label>
                                    <div class="form-group">

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="smoking" value="No" />
                                            <label class="form-check-label" for="no">No</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="smoking" value="Yes" />
                                            <label class="form-check-label">Yes</label>
                                        </div>

                                    </div>
                                </td>
                                <td>
                                    <label for="alcohol">Alcohol Consumption</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="alcohol" value="No" />
                                        <label class="form-check-label">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="alcohol" value="Yes" />
                                        <label class="form-check-label">Yes</label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <label for="allergies">Allergence History</label>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="allergies" id="no" value="no" />
                                        <label class="form-check-label" for="no">No</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="allergies" id="yes" value="yes" />
                                        <label class="form-check-label" for="yes">Yes; Specify</label>

                                        <!-- Specify allergies text input -->
                                        <input type="text" name="allergies_specify" class="form-control" id="allergies-input" style="display:none;" placeholder="Specify allergies">
                                    </div>

                                    <script>
                                        // Get the radio buttons and the text input field
                                        const yesRadio = document.getElementById("yes");
                                        const noRadio = document.getElementById("no");
                                        const allergiesInput = document.getElementById("allergies-input");

                                        // Add event listeners to toggle the visibility of the text input
                                        yesRadio.addEventListener("change", () => {
                                            allergiesInput.style.display = "block"; // Show text input if "Yes" is selected
                                        });

                                        noRadio.addEventListener("change", () => {
                                            allergiesInput.style.display = "none"; // Hide text input if "No" is selected
                                            allergiesInput.value = ""; // Clear the input field when hidden
                                        });
                                    </script>

                                </td>
                            </tr>
                        </table>
                    </div>
                </section>
            </div>

            <!-- Physical Exam  -->
            <div class="page-break">
                <section>
                    <div class="physical-exam container mt-5">
                        <table class="table" id="physicalExamTable" style="background-color: #fafbfc">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="h4">Physical Exam Date</h4>

                                    <p><?php echo date('d F Y') ?></p>
                                </div>
                            </div>

                            <thead>
                                <th>Temperature</th>
                                <th>Blood Pressure</th>
                                <th>Heart Rate</th>
                                <th>Respiratory Rate</th>
                            </thead>
                            <tr>
                                <td><input type='text' name='temperature' class='form-control' placeholder="Temperature" /></td>
                                <td><input type='text' name='blood pressure' class='form-control' placeholder="Blood Pressure" /></td>
                                <td><input type='text' name='heart rate' class='form-control' placeholder="Heart Rate" /></td>
                                <td><input type='text' name='respiratory rate' class='form-control' placeholder="Respiratory Rate" /></td>
                            </tr>
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

                            <?php
                            foreach ($conditions as $condition_name => $condition_status) {
                                echo "<tr>";
                                echo "<td>{$condition_name}</td>";
                                echo "<td><input type='radio' name='" . strtolower(str_replace(' ', '_', $condition_name)) . "' value='None' " . ($condition_status == 'None' ? 'checked' : '') . " ></td>";
                                echo "<td><input type='radio' name='" . strtolower(str_replace(' ', '_', $condition_name)) . "' value='Yes' " . ($condition_status == 'Yes' ? 'checked' : '') . " ></td>";
                                // echo "<td><input type='radio' name='" . strtolower(str_replace(' ', '_', $condition_name)) . "' value='I\'m not sure' " . ($condition_status == "I'm not sure" ? 'checked' : '') . " ></td>";
                                echo "<td><input type='radio' name='" . strtolower(str_replace(' ', '_', $condition_name)) . "' value=\"I'm not sure\" " . ($condition_status == "I'm not sure" ? 'checked' : '') . " ></td>";

                                echo "</tr>";
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
                                <td><input type='text' name='procedure_name[]' class='form-control' placeholder="Procedure Name" /></td>
                                <td><input type='text' name='diagnosis_purpose[]' class='form-control' placeholder="Purpose" /></td>
                                <td><input type='text' name='diagnosis_result[]' class='form-control' placeholder="Result" /></td>
                            </tr>
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
                                    <input type="doctor name" class="form-control" disabled value="<?php echo $doctor['doctor_name'] ?>">
                                </td>
                                <td>
                                    <p>Doctor Signature</p>
                                    <input type="doctor sign" class="form-control" readonly>
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

            <div class="container text-center">
                <a href="../manage patient/patient_profile.php?id=<?php echo $patient_id ?>">
                    <button class="btn btn-primary previous-btn">Back</button>
                </a>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
            columns.forEach((column, index) => {
                markup += `<td><input type='text' name='${column.name}[]' class='form-control' placeholder='${column.placeholder}' /></td>`;
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