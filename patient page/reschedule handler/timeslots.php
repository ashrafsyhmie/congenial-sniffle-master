<?php
session_start();
$patient_id = $_SESSION['patient_id'];

require_once '../../db conn.php';
require './timeslots-function.php';

$date = isset($_GET['date']) ? $_GET['date'] : '';
$doctor_id = isset($_GET['doctor_id']) ? $_GET['doctor_id'] : '';

$appointment_id = $_GET['appointment_id'];

// Fetch the appointment details using the appointment_id
$appointmentDetails = fetchAppointmentById($conn, $appointment_id);

function fetchAppointmentById($conn, $appointment_id)
{
    $sql = "SELECT * FROM appointment WHERE appointment_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $appointment_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the appointment details
    if ($row = mysqli_fetch_assoc($result)) {
        return $row;
    } else {
        return null;
    }
}

// Process the data (e.g., reschedule, display the details, etc.)
if ($appointmentDetails) {
    // Store or display the appointment details
    $_SESSION['appointment_id'] = $appointmentDetails['appointment_id'];
    $_SESSION['appointment_date'] = $appointmentDetails['date'];
    $_SESSION['appointment_timeslot'] = $appointmentDetails['timeslot'];
    $_SESSION['appointment_doctor'] = $appointmentDetails['doctor_id'];
} else {
    echo "Appointment not found!";
}

// Function to fetch doctor information using doctor_id
function fetchDoctorById($conn, $doctor_id)
{
    // Prepare the SQL query to fetch the doctor info based on doctor_id
    $sql = "SELECT * FROM doctor WHERE doctor_id = ?";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    // Bind the doctor_id parameter to the query
    mysqli_stmt_bind_param($stmt, "i", $doctor_id);

    // Execute the query
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the doctor details if found
    if ($row = mysqli_fetch_assoc($result)) {
        return $row; // Return the doctor details
    } else {
        return null; // Return null if no doctor is found
    }
}



// Fetch the doctor details using the doctor_id
$doctorInfo = fetchDoctorById($conn, $appointmentDetails['doctor_id']);

if ($doctorInfo) {
    // Store doctor info in session or display it as needed
    $_SESSION['doctor_name'] = $doctorInfo['doctor_name'];
} else {
    echo "No doctor found with the provided doctor_id!";
}

$sql = "SELECT * FROM patient WHERE patient_id = $patient_id";

// Execute the query
$result = mysqli_query($conn, $sql);

// Check for errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

$patient_name = $row['patient_name'];


$sql = "SELECT * FROM patient WHERE patient_id = $patient_id";

// Execute the query
$result = mysqli_query($conn, $sql);

// Check for errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

$doctor_name = $doctorInfo['doctor_name'];


$booked_timeslot = isset($_GET['booked_timeslot']) ? $_GET['booked_timeslot'] : '';
$bookings = [];

if ($booked_timeslot) {
    $bookings[] = $booked_timeslot;
}

// Retrieve existing bookings for the selected date and doctor_id (including all patients)
if (!empty($date)) {
    $stmt = $conn->prepare("SELECT timeslot FROM appointment WHERE DATE = ? AND (doctor_id = ? OR patient_id = ?)");
    $stmt->bind_param('sss', $date, $doctor_id, $patient_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row['timeslot'];
        }
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Error retrieving bookings: " . $stmt->error . "</div>";
    }
}

$msg = '';

if (isset($_POST['submit'])) {
    $timeslot = $_POST['timeslot'];

    // Check if the timeslot is already booked for the patient_id
    $stmt = $conn->prepare("SELECT * FROM appointment WHERE DATE = ? AND TIMESLOT = ? AND patient_id = ? AND doctor_id = ?");
    $stmt->bind_param('ssss', $date, $timeslot, $patient_id, $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $msg = "<div class='alert alert-danger'>Already Booked</div>";
    } else {

        $sql = "UPDATE appointment SET date = ?, timeslot = ? WHERE appointment_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $date, $timeslot, $appointment_id);



        if ($stmt->execute()) {
            header("Location: ../all appointment.php?message=Appointment Rescheduled Successfully&message_type=success");
            exit;
        } else {
            $msg = "<div class='alert alert-danger'>Booking Failed: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
}

// function timeslots($duration, $cleanup, $start, $end)
// {
//     $start = new DateTime($start);
//     $end = new DateTime($end);
//     $interval = new DateInterval("PT" . $duration . "M");
//     $cleanupInterval = new DateInterval("PT" . $cleanup . "M");
//     $slots = [];

//     for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)) {
//         $endPeriod = clone $intStart;
//         $endPeriod->add($interval);
//         if ($endPeriod > $end) {
//             break;
//         }
//         $slots[] = $intStart->format("H:iA") . " - " . $endPeriod->format("H:iA");
//     }

//     return $slots;
// }

// $duration = 30;
// $cleanup = 10;
// $start = "08:00";
// $end = "17:00";
// $timeslots = timeslots($duration, $cleanup, $start, $end);

$timeslots = timeslots();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book for Date: <?php echo date('F d, Y', strtotime($date)); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body,
        table,
        thead,
        tbody,
        th,
        td,
        tr,
        .alert {
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --bs-body-font-family: 'Poppins';
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Book for Date: <?php echo date('F d, Y', strtotime($date)); ?></h1>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <?php echo $msg; ?>
            </div>

            <?php
            date_default_timezone_set('Asia/Kuala_Lumpur'); // Ensure timezone is set

            // Get the current time and date
            $currentTime = date("H:i");
            $today = date("Y-m-d");

            // Assuming $_SESSION['appointment_date'] contains the previous appointment's date
            $previousAppointmentDate = isset($_SESSION['appointment_date']) ? $_SESSION['appointment_date'] : null;

            foreach ($timeslots as $t) {
                $isBooked = in_array($t, $bookings); // Check if the timeslot is already booked

                // Highlight only if the timeslot matches and is on the same date as the previous appointment
                $isPreviousAppointment = ($t == $_SESSION['appointment_timeslot'] && $date == $previousAppointmentDate);

                // Check if the date is today and the timeslot is in the past
                $timeParts = explode(" - ", $t); // Assume timeslot format is "08:00AM - 08:30AM"
                $slotStartTime = date("H:i", strtotime($timeParts[0]));
                $isPast = ($date == $today && $slotStartTime < $currentTime);

                // Determine the button class
                if ($isPreviousAppointment) {
                    $buttonClass = 'btn-warning'; // Highlight the previous appointment
                } elseif ($isBooked || $isPast) {
                    $buttonClass = 'btn-danger'; // Disable booked or past timeslots
                } else {
                    $buttonClass = 'btn-success book'; // Available timeslots
                }

                // Output the button
                echo "<button class='btn $buttonClass' style='margin: 10px; width:13%;' " .
                    (($isBooked || $isPast) ? "disabled" : "data-timeslot='$t'") . ">$t</button>";
            }
            ?>


            <br><br>
            <div class="container" style="text-align: center;">
                <a href="./calendar.php?appointment_id=<?php echo $appointment_id; ?>"><button class="btn btn-primary">BACK</button></a>
            </div>
        </div>

        <div class="legend">
            <h4>Legend:</h4>
            <button class="btn btn-success" style="width:5%; cursor: default;" disabled></button>
            <span>Available</span>
            <br>
            <br>
            <button class="btn btn-danger" style="width:5%; cursor: default;" disabled></button>
            <span>Booked</span>
            <br>
            <br>
            <button class="btn btn-warning" style="width:5%; cursor: default;" disabled></button>
            <span>Current</span>
        </div>

    </div>

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form method="post" action="">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Booking for: <span id="slot"></span></h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="timeslot">Timeslot</label>
                            <input readonly type="text" class="form-control" id="timeslot" name="timeslot">
                        </div>
                        <?php
                        $stmt = $conn->prepare("SELECT appointment.timeslot, patient.patient_name, doctor.doctor_name 
                                                  FROM appointment 
                                                  JOIN doctor ON appointment.doctor_id = doctor.doctor_id 
                                                  JOIN patient ON appointment.patient_id = patient.patient_id 
                                                  WHERE appointment.patient_id = ?");
                        $stmt->bind_param('i', $patient_id);

                        $stmt->execute();
                        $result = $stmt->get_result();

                        $row = mysqli_fetch_assoc($result);



                        // $sql = "SELECT * FROM patient WHERE patient_id = $patient_id";

                        // // Execute the query
                        // $result = mysqli_query($conn, $sql);

                        // // Check for errors
                        // if (!$result) {
                        //     die("Query failed: " . mysqli_error($conn));
                        // }

                        // $row = mysqli_fetch_assoc($result);
                        // echo $row['patient_name'];


                        ?>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input readonly type="text" class="form-control" id="dateBooked" name="dateBooked" value="<?php echo date('F d, Y', strtotime($date)); ?>">
                        </div>
                        <div class="form-group">
                            <label for="patientName">Patient Name</label>
                            <input readonly type="text" class="form-control" id="patientName" name="patientName" value="<?php echo $patient_name; ?>">
                        </div>
                        <div class="form-group">
                            <label for="doctorName">Doctor Name</label>
                            <input readonly type="text" class="form-control" id="doctorName" name="doctorName" value="<?php echo $doctor_name ?>">
                        </div>

                        <?php


                        $stmt->close();
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script>
        $(".book").click(function() {
            var timeslot = $(this).attr('data-timeslot');
            $("#slot").html(timeslot);
            $("#timeslot").val(timeslot);
            $("#myModal").modal("show");
        });
    </script>
</body>

</html>