<?php

session_start();
require_once('../../db conn.php');


function getAppointmentData($conn, $appointment_id)
{
  $sql = "SELECT * FROM appointment WHERE appointment_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $appointment_id);
  $stmt->execute();
  return $stmt->get_result()->fetch_assoc();
}

$appointment_id = 1;
// $appointment_id = $_GET['appointment_id'];
// if (!isset($_GET['appointment_id'])) {
//   die("Appointment ID not provided.");
// }



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



// $_SESSION['patient_id'] = $_GET['patient_id'];
$_SESSION['patient_id'] = 1;
$patient_id = $_SESSION['patient_id'];




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

  <form id="content" method="post" action="./medical history handler.php">
    <!-- Header -->
    <header>
      <div class="container text-center bg-primary p-4 mb-5">
        <div class="row align-items-center">
          <div class="col-md-4">
            <a href="#" class="btn btn-light previous-btn">&#8249;</a>
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
              <input type="text" name="appointment_id" class="form-control">
              <label for="patient-name">Patient Name</label>
              <input type="text" name="patient-name" class="form-control" disabled value="
              <?php echo $patient_name; ?>" />
            </td>
            <td>
              <label for="patient-age">Age</label>
              <input type="text" name="patient-age" class="form-control" disabled value="
              <?php
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
              <input type="text" name="phone-number" class="form-control" disabled value="
              <?php echo $patient_phone; ?>" />
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
                  <input class="form-check-input" type="radio" name="gender" id="male" value="male" <?php if ($patient_gender == 'Male') echo 'checked'; ?> />
                  <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="gender" id="female" value="female" <?php if ($patient_gender == 'Female') echo 'checked'; ?> />
                  <label class="form-check-label" for="female">Female</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="gender" id="other" value="other" <?php if ($patient_gender == 'other') echo 'checked'; ?> />
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
        <label for="notes">Notes</label>
        <input type="text" name="notes" id="notes" class="form-control">
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
            <th>Test 123</th>
            <th>Dosage</th>
            <th>Frequency</th>
          </thead>


          <tr>
            <td><input type="text" name="medication_name[]" class="form-control" placeholder="Medication" value="Test Name" /></td>
            <td><input type="text" name="purpose[]" class="form-control" placeholder="Purpose" /></td>
            <td><input type="text" name="dosage[]" class="form-control" placeholder="Dosage" value="Test Dosage" /></td>
            <td><input type="text" name="frequency[]" class="form-control" placeholder="Frequency" value="Test Frequency" /></td>
          </tr>
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
                  <input type="text" name="allergies" class="form-control" id="allergies-input" style="display:none;" placeholder="Specify allergies">
                </div>
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
                <p>January 1, 2000</p>
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
              <th class="text-center">None</th>
              <th class="text-center">Yes</th>
              <th class="text-center">Im not sure</th>
            </tr>
            <tr>
              <td>Eye Problem</td>
              <td class="text-center"><input class="form-check-input" type="radio" name="eye-problem" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="eye-problem" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="eye-problem" /></td>
            </tr>
            <tr>
              <td>Seizure</td>
              <td class="text-center"><input class="form-check-input" type="radio" name="seizure" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="seizure" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="seizure" /></td>
            </tr>
            <tr>
              <td>Epilepsy</td>
              <td class="text-center"><input class="form-check-input" type="radio" name="epilepsy" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="epilepsy" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="epilepsy" /></td>
            </tr>
            <tr>
              <td>Hearing Problem</td>
              <td class="text-center"><input class="form-check-input" type="radio" name="hearing-problem" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="hearing-problem" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="hearing-problem" /></td>
            </tr>
            <tr>
              <td>Diabetes</td>
              <td class="text-center"><input class="form-check-input" type="radio" name="diabetes" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="diabetes" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="diabetes" /></td>

            </tr>
            <tr>
              <td>Cardiovascular Disease</td>
              <td class="text-center"><input class="form-check-input" type="radio" name="cardiovascular-disease" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="cardiovascular-disease" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="cardiovascular-disease" /></td>

            </tr>
            <tr>
              <td>History of Strokes</td>
              <td class="text-center"><input class="form-check-input" type="radio" name="strokes" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="strokes" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="strokes" /></td>

            </tr>
            <tr>
              <td>Respiratory Problem</td>
              <td class="text-center"><input class="form-check-input" type="radio" name="respiratory-problem" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="respiratory-problem" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="respiratory-problem" /></td>

            </tr>
            <tr>
              <td>Kidney Problem</td>
              <td class="text-center"><input class="form-check-input" type="radio" name="kidney-problem" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="kidney-problem" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="kidney-problem" /></td>

            </tr>
            <tr>
              <td>Stomach and Liver Problem</td>
              <td class="text-center"><input class="form-check-input" type="radio" name="stomach-liver-problem" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="stomach-liver-problem" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="stomach-liver-problem" /></td>

            </tr>
            <tr>
              <td>Pancreatic Problems</td>
              <td class="text-center"><input class="form-check-input" type="radio" name="pancreatic-problem" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="pancreatic-problem" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="pancreatic-problem" /></td>

            </tr>
            <tr>
              <td>Anxiety and Depression</td>
              <td class="text-center"><input class="form-check-input" type="radio" name="anxiety-depression" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="anxiety-depression" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="anxiety-depression" /></td>

            </tr>
            <tr>
              <td>Other Mental Health Issue</td>
              <td class="text-center"><input class="form-check-input" type="radio" name="other-mental-health" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="other-mental-health" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="other-mental-health" /></td>

            </tr>
            <tr>
              <td>Sleep Disorder</td>
              <td class="text-center"><input class="form-check-input" type="radio" name="sleep-disorder" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="sleep-disorder" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="sleep-disorder" /></td>

            </tr>
            <tr>
              <td>Neck or Back Problem</td>
              <td class="text-center"><input class="form-check-input" type="radio" name="neck-back-problem" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="neck-back-problem" /></td>
              <td class="text-center"><input class="form-check-input" type="radio" name="neck-back-problem" /></td>

            </tr>
            <tr></tr>
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
                <input type="doctor name" class="form-control" disabled value="<?php echo $doctor_name ?>">
              </td>
              <td>
                <p>Doctor Signature</p>
                <input type="doctor sign" class="form-control" readonly>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <p>Date Signed</p>
                <input type="doctor sign date" class="form-control" readonly>
              </td>
            </tr>
          </table>
        </div>
      </section>
    </div>

    <div class="container text-center">
      <input type="submit" value="Submit" class="btn btn-primary">
      <input type="reset" value="Reset" class="btn btn-primary">
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
          name: 'abc123',
          placeholder: 'abc123'
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