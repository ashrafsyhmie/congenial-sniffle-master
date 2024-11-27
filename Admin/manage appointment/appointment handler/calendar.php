<?php
session_start();
require_once '../../../db conn.php';

require './timeslots-function.php';


// Store doctor_id and patient_id in session if they exist in the GET request
if (isset($_POST['doctor_id'], $_POST['patient_id'])) {
    $_SESSION['doctor_id'] = $_POST['doctor_id'];
    $_SESSION['patient_id'] = $_POST['patient_id'];
}

// Retrieve doctor_id and patient_id from session
$doctor_id = $_SESSION['doctor_id'] ?? '';
$patient_id = $_SESSION['patient_id'] ?? '';




function displayAvailableSlots($date, $doctor_id, $patient_id, $conn)
{
    date_default_timezone_set('Asia/Kuala_Lumpur'); // Set timezone

    // Get all available slots in the "g:iA - g:iA" format
    $all_slots = timeslots();
    if (empty($all_slots)) {
        die('Error: No slots returned from timeslots function.');
    }

    // Extract the start time of the last slot for comparison
    $last_slot = end($all_slots);
    $last_slot_start = substr($last_slot, 0, strpos($last_slot, ' -')); // Extract "8:00AM"

    // Get the current time in the same format as the slots
    $current_time = date('g:iA');
    $current_date = date('Y-m-d');


    // If the current date is today and time is past the last slot, disable
    if ($date == $current_date && strtotime($current_time) > strtotime($last_slot_start)) {
        return true; // Fully booked (time has passed)
    }

    // Query booked slots
    $stmt = $conn->prepare("SELECT DISTINCT timeslot FROM appointment WHERE DATE = ? AND (doctor_id = ? OR patient_id = ?)");
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param('sss', $date, $doctor_id, $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $booked_slots = [];
    while ($row = $result->fetch_assoc()) {
        $booked_slots[] = $row['timeslot'];
    }
    $stmt->close();

    // Find available slots
    $available_slots = array_diff($all_slots, $booked_slots);

    // If no slots are available, return true (fully booked)
    return empty($available_slots);
}



function build_calendar($month, $year, $patient_id, $conn)
{
    global $doctor_id;
    $stmt = $conn->prepare("SELECT DATE FROM appointment WHERE MONTH(DATE) = ? AND YEAR(DATE) = ? AND patient_id = ?");
    $stmt->bind_param('iis', $month, $year, $patient_id);
    $bookings = array();

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row['DATE'];
        }
        $stmt->close();
    }

    $daysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];

    $calendar = "<table class='text-center table table-bordered'>";
    $calendar .= "<center><h2>$monthName $year</h2>";
    $calendar .= "<a class='btn btn-xs btn-danger' href='?month=" . date('m', mktime(0, 0, 0, $month - 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month - 1, 1, $year)) . "'>Previous Month</a> ";
    $calendar .= " <a class='btn btn-xs btn-success' href='?month=" . date('m') . "&year=" . date('Y') . "'>Current Month</a> ";
    $calendar .= "<a class='btn btn-xs btn-primary' href='?month=" . date('m', mktime(0, 0, 0, $month + 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month + 1, 1, $year)) . "'>Next Month</a></center><br>";

    $calendar .= "<tr>";
    foreach ($daysOfWeek as $day) {
        $calendar .= "<th class='header'>$day</th>";
    }
    $calendar .= "</tr><tr>";

    if ($dayOfWeek > 0) {
        for ($k = 0; $k < $dayOfWeek; $k++) {
            $calendar .= "<td class='empty'></td>";
        }
    }

    $currentDay = 1;
    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberDays) {
        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";
        $today = $date == date('Y-m-d') ? "today" : "";

        // $fullyBooked = isDateFullyBooked($date, $doctor_id, $conn);
        $fullyBooked = displayAvailableSlots($date, $doctor_id, $patient_id, $conn);

        if ($fullyBooked || $date < date('Y-m-d')) {
            // Date is fully booked or in the past, display as not clickable
            $calendar .= "<td class='$today'><h4>$currentDay</h4> <button class='btn btn-danger btn-xs' disabled>";
            $calendar .= $fullyBooked ? "<span class='glyphicon glyphicon-lock'></span> Fully Booked" : "<span class='glyphicon glyphicon-ban-circle'></span> Not Available";
            $calendar .= "</button></td>";
        } else {
            // Date is available for booking, include doctor_id in the URL
            $calendar .= "<td class='$today'><h4>$currentDay</h4> <a href='timeslots.php?date=" . $date . "' class='btn btn-success btn-xs'><span class='glyphicon glyphicon-ok'></span> Book Now</a></td>";
        }

        $currentDay++;
        $dayOfWeek++;
    }

    if ($dayOfWeek != 7) {
        $remainingDays = 7 - $dayOfWeek;
        for ($l = 0; $l < $remainingDays; $calendar .= "<td class='empty'></td>", $l++);
    }

    $calendar .= "</tr>";
    $calendar .= "</table>";
    echo $calendar;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Calendar</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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

        .table td {
            text-align: center;
            /* Center the text within the table cells */
        }

        @media only screen and (max-width: 760px),
        (min-device-width: 802px) and (max-device-width: 1020px) {

            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }

            .empty {
                display: none;
            }

            th {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                border: 1px solid #ccc;
            }

            td {
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
                text-align: center;
                /* Center the text within the table cells */
            }

            td:nth-of-type(1):before {
                content: "Sunday";
            }

            td:nth-of-type(2):before {
                content: "Monday";
            }

            td:nth-of-type(3):before {
                content: "Tuesday";
            }

            td:nth-of-type(4):before {
                content: "Wednesday";
            }

            td:nth-of-type(5):before {
                content: "Thursday";
            }

            td:nth-of-type(6):before {
                content: "Friday";
            }

            td:nth-of-type(7):before {
                content: "Saturday";
            }
        }

        @media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
            body {
                padding: 0;
                margin: 0;
            }
        }

        @media only screen and (min-device-width: 802px) and (max-device-width: 1020px) {
            body {
                width: 495px;
                margin: 7.5px;
                background-color: #FAFBFC;
            }
        }

        @media (min-width: 641px) {
            table {
                table-layout: fixed;
            }

            td {
                width: 33%;
                text-align: center;
                /* Center the text within the table cells */
            }
        }

        .row {
            margin-top: 20px;
        }

        .today {
            background: #eee;
        }
    </style>
</head>

<body style="text-align:center">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger bg-primary" style=" border:none; color:#fff">
                    <h1>Appointment Calendar</h1>
                </div>
                <?php
                $dateComponents = getdate();
                if (isset($_GET['month']) && isset($_GET['year'])) {
                    $month = (int)$_GET['month'];
                    $year = (int)$_GET['year'];
                } else {
                    $month = $dateComponents['mon'];
                    $year = $dateComponents['year'];
                }

                build_calendar($month, $year, $patient_id, $conn);
                ?>
            </div>
        </div>
    </div>

    <a href="../new appointment.php"><button type="button" class="btn btn-primary text-white">Back</button></a>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>

</html>