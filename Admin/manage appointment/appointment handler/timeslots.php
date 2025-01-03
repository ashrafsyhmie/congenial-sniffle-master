<?php
session_start();
$admin_id = $_SESSION['admin_id'];

require_once '../../../db conn.php';
require './timeslots-function.php';


$patient_id = $_SESSION['patient_id'];
$doctor_id = $_SESSION['doctor_id'];
$date = date('Y-m-d', strtotime($_GET['date']));


// Your SQL query should now work with a valid patient_id
$sql = "SELECT * FROM patient WHERE patient_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $patient_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $patient_name = $row['patient_name'];
    $patient_ID = $row['patient_id'];
}
$stmt->close();


// Prepared statement for doctor query
$sql = "SELECT * FROM doctor WHERE doctor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $doctor_id); // Bind the doctor_id to the query
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $doctor_name = $row['doctor_name'];
    $doctor_ID = $row['doctor_id'];
} else {
    die("No doctor found with the provided ID.");
}


$booked_timeslot = isset($_GET['booked_timeslot']) ? $_GET['booked_timeslot'] : '';
$bookings = [];

if ($booked_timeslot) {
    $bookings[] = $booked_timeslot;
}

// Retrieve existing bookings for the selected date and doctor_id (including all patients) and their statuses
if (!empty($date)) {
    $stmt = $conn->prepare("SELECT timeslot, status FROM appointment WHERE DATE = ? AND (doctor_id = ? OR patient_id = ?)");
    $stmt->bind_param('sss', $date, $doctor_id, $patient_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $bookings[$row['timeslot']] = $row['status']; // Store timeslot and status
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
    $stmt = $conn->prepare("SELECT * FROM appointment WHERE DATE = ? AND TIMESLOT = ? AND patient_id = ? AND doctor_id = ? ");
    $stmt->bind_param('ssss', $date, $timeslot, $patient_id, $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $msg = "<div class='alert alert-danger'>Already Booked</div>";
    } else {
        // Insert the booking into the database with patient_id
        $stmt = $conn->prepare("INSERT INTO appointment (DATE, TIMESLOT, patient_id,doctor_id) VALUES (?, ?, ?,?)");
        $stmt->bind_param('ssss', $date, $timeslot, $patient_id, $doctor_id);

        if ($stmt->execute()) {
            $msg = "<div class='alert alert-success'>Booking Successful</div>";
            header("Location: timeslots.php?date=" . $date . "&patient_id=" . $patient_id . "&doctor_id=" . $doctor_id . "&message=Booked successfully&message_type=success");
            // date=$date&booked_timeslot=$timeslot
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
        <?php
        // Display success or error message
        if (isset($_GET['message'])) {
            $messageType = $_GET['message_type'] == 'success' ? 'alert-success' : 'alert-danger';
            echo '<div class="alert ' . $messageType . '">';
            echo '<strong>' . htmlspecialchars($_GET['message']) . '</strong>';
            echo '</div>';
        }
        ?>
        <div class="row">
            <div class="col-md-12">
                <?php echo $msg; ?>
            </div>
            <?php
            // Set the correct time zone
            date_default_timezone_set('Asia/Kuala_Lumpur');

            // Get today's date and current time
            $today = date("Y-m-d");
            $currentTime = date("H:i");

            foreach ($timeslots as $t) {
                // Extract the start time of the timeslot
                $timeslotStart = explode(" - ", $t)[0]; // Assuming "H:iA - H:iA" format
                $timeslotStart24 = date("H:i", strtotime($timeslotStart)); // Convert to 24-hour format

                // Check if the date matches today
                $isToday = $date === $today;

                // Check if the timeslot is booked or in the past (only for today)
                $isBooked = isset($bookings[$t]) && $bookings[$t] != 'cancelled';
                $isPast = $isToday && $timeslotStart24 < $currentTime; // Only check time for today's date

                // Set button class and state
                $buttonClass = $isBooked || $isPast ? 'btn-danger' : 'btn-success book';
                $disabled = $isBooked || $isPast ? "disabled" : "data-timeslot='$t'";

                echo "<button class='btn $buttonClass' style='margin: 10px; width:13%;' $disabled>$t</button>";
            }
            ?>
            <br><br>
            <div class="container" style="text-align: center;">
                <a href="./calendar.php?doctor_id=<?php echo $doctor_id; ?>&patient_id=<?php echo $patient_id; ?>"><button class="btn btn-primary">BACK</button></a>
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