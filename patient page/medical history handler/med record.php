<?php

session_start();

require_once("../db conn.php");

$patient_id = $_SESSION['patient_id'];
$doctor_id = 1;
$appointment_id = 88;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>

<body>
    <form action="./med record.php" method="post">
        <section>
            <label for="notes">Doctor Notes</label>
            <input type='text' name='notes' class='form-control' placeholder="notes" />
        </section>
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
                        <td>
                            <input type="text" name="medication" class="form-control" placeholder="Medication" />
                        </td>
                        <td><input type="text" name="purpose" class="form-control" placeholder="Purpose" /></td>
                        <td><input type="text" name="dosage" class="form-control" placeholder="Dosage" /></td>
                        <td>
                            <input type="text" name="frequency" class="form-control" placeholder="Frequency" />
                        </td>
                    </tr>
                </table>
            </div>
        </section>

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
                            <td><input type='text' name='procedure name' class='form-control' placeholder="Procedure Name" /></td>
                            <td><input type='text' name='purpose' class='form-control' placeholder="Purpose" /></td>
                            <td><input type='text' name='result' class='form-control' placeholder="Result" /></td>
                        </tr>
                    </table>
                </div>
            </section>
        </div>
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
        <input type="submit" value="Submit" class="btn btn-primary">
    </form>


    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



    <script>
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
    </script>
</body>

</html>

<?php

if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['submit']))) {
    $notes = $_POST['notes'];
    $medication_name = $_POST['medication'];
    $purpose = $_POST['purpose'];
    $dosage = $_POST['dosage'];
    $frequency = $_POST['frequency'];
    $procedure_name = $_POST['procedure_name'];
    $purpose = $_POST['purpose'];
    $result = $_POST['result'];
    $exam_date = date("Y-m-d");
    $temperature = $_POST['temperature'];
    $blood_pressure = $_POST['blood_pressure'];
    $heart_rate = $_POST['heart_rate'];
    $respiratory_rate = $_POST['respiratory_rate'];
} else {
    $notes = "";
    $medication_name = "";
    $purpose = "";
    $dosage = "";
    $frequency = "";
    $procedure_name = "";
    $purpose = "";
    $result = "";
    $exam_date = "";
    $temperature = "";
    $blood_pressure = "";
    $heart_rate = "";
    $respiratory_rate = "";
}

$sql = "INSERT INTO medical_record (appointment_id, patient_id, notes) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $appointment_id, $patient_id, $notes);
$stmt->execute();
$medical_record_id = $conn->insert_id;

$sql = "INSERT INTO medication (medical_record_id, medication_name, purpose, dosage, frequency) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issss", $medical_record_id, $medication_name, $purpose, $dosage, $frequency);
$stmt->execute();

$sql = "INSERT INTO diagnosis (medical_record_id, procedure_name, purpose, result) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $medical_record_id, $procedure_name, $purpose, $result);
$stmt->execute();

$sql = "INSERT INTO physical_exam (medical_record_id, exam_date, temperature, blood_pressure, heart_rate, respiratory_rate) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iissss", $medical_record_id, $exam_date, $temperature, $blood_pressure, $heart_rate, $respiratory_rate);
$stmt->execute();

$sql = "UPDATE medical_record SET medication_id = ?, diagnosis_id = ?, physical_exam_id = ? WHERE medical_record_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $medication_id, $diagnosis_id, $physical_exam_id, $medical_record_id);
$stmt->execute();

?>