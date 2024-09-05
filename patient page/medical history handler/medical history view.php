<?php

session_start();
$patient_id = $_SESSION['patient_id'];
$patient_name = $_SESSION['patient_name'];

require_once('../db conn.php');

$appointment_id = $_GET['appointment_id'];

// Function to fetch all information from the patient table
function fetchAllPatientInfo($conn)
{

  global $patient_id;
  $sql = "SELECT * FROM patient WHERE patient_id = $patient_id";
  $result = mysqli_query($conn, $sql);

  // Initialize an array to store the results
  $patientInfo = array();

  // Fetch each row and store it in the array
  while ($row = mysqli_fetch_assoc($result)) {
    $patientInfo[] = $row;
  }

  // Return the array containing all patient information
  return $patientInfo;
}



// Fetch all patient information
$allPatientInfo = fetchAllPatientInfo($conn);



// Output the fetched information


foreach ($allPatientInfo as $patient) {


  $_SESSION['patient_name'] = $patient['patient_name'];
  $_SESSION['patient_photo'] = $patient['patient_photo'];
}


$patient_name = $_SESSION['patient_name'];

function fetchAllAppointmentInfo($conn)
{

  global $appointment_id;
  $sql = "SELECT * FROM appointment WHERE appointment_id = appointment_id";
  $result = mysqli_query($conn, $sql);

  // Initialize an array to store the results
  $appointmentInfo = array();

  // Fetch each row and store it in the array
  while ($row = mysqli_fetch_assoc($result)) {
    $appointmentInfo[] = $row;
  }

  // Return the array containing all appointment information
  return $appointmentInfo;
}



// Fetch all appointment information
$AllAppointmentInfo = fetchAllAppointmentInfo($conn);



// Output the fetched information


foreach ($AllAppointmentInfo as $appointment) {


  $_SESSION['patient_id'] = $appointment['patient_id'];
  $_SESSION['doctor_id'] = $appointment['doctor_id'];
}


$appointment_name = $_SESSION['appointment_name'];


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
              href="../medical history.php"
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
          <tr>
            <td>Vitamin and Supplements</td>
            <td>Maintaining Health</td>
            <td>1 tablet</td>
            <td>Daily</td>
          </tr>
          <tr>
            <td>Celestamine</td>
            <td>For allergy attacks</td>
            <td>1 tablet</td>
            <td>As needed</td>
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
                <p>Smoking History</p>
                <p>No</p>
              </td>
              <td>
                <p>Alcohol Consumption</p>
                <p>No</p>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <p>Substance Abuse History</p>
                <p>No</p>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <p>Allergies History</p>
                <p>No</p>
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
          <h3>Physical Exam Date</h3>
          <p>January 1, 2000</p>

          <table class="table" style="background-color: #fafbfc">
            <tr>
              <th>Temperature</th>
              <th>Blood Pressure</th>
              <th>Heart Rate</th>
              <th>Respiratory Rate</th>
            </tr>
            <tr>
              <td>37.0</td>
              <td>119/70</td>
              <td>70</td>
              <td>15</td>
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
              <th>Im not sure</th>
            </tr>
            <tr>
              <td>Eye Problem</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>Seizure</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>Epilepsy</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>Hearing Problem</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>Diabetes</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>Cardiovascular Disease</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>History of Strokes</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>Respiratory Problem</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>Kidney Problem</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>Stomach and Liver Problem</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>Pancreatic Problems</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>Anxiety and Depression</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>Other Mental Health Issue</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>Sleep Disorder</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>Neck or Back Problem</td>
              <td></td>
              <td></td>
              <td></td>
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
          <h3>Diagnosis Examination</h3>
          <table class="table" style="background-color: #fafbfc">
            <tr>
              <th>Procedure Name</th>
              <th>Purpose</th>
              <th>Result</th>
            </tr>
            <tr>
              <td>Chest X-ray</td>
              <td>Check Lungs</td>
              <td>Normal</td>
            </tr>
            <tr>
              <td>Urinalysis</td>
              <td>Check urinary tract</td>
              <td>Normal</td>
            </tr>
            <tr>
              <td>Kidney Test</td>
              <td>Check functionality</td>
              <td>Normal</td>
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
                <p><?php echo $appointment['doctor_id']  ?></p>
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
      <a href="../medical history.html">
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