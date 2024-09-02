<?php
session_start();
$patient_id = $_SESSION['patient_id'];
$doctor_id = isset($_GET['doctor_id']) ? $_GET['doctor_id'] : '';
echo $doctor_id;


// Database connection
$host = "localhost"; // Your database host (usually "localhost")
$user = "root"; // Your database username
$password = ""; // Your database password
$dbname = "medassist 2"; // Your database name

$mysqli = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}


require './timeslots-function.php';




$date = "2024-09-3"; // Example date

// displayAvailableSlots($date, $mysqli);




function displayAvailableSlots($date, $doctor_id, $mysqli)
{
    // Define slot parameters
    $duration = 30; // Duration of each slot in minutes
    $cleanup = 10;  // Cleanup time in minutes
    $start = "08:00"; // Start time
    $end = "17:00";   // End time

    // Generate all possible time slots for the day
    $all_slots = timeslots($duration, $cleanup, $start, $end);

    // Prepare the SQL statement to get booked slots
    $stmt = $mysqli->prepare("SELECT DISTINCT timeslot FROM appointment WHERE DATE = ? AND doctor_id = ?");
    if (!$stmt) {
        die('Prepare failed: ' . $mysqli->error);
    }

    // Bind parameters and execute
    $stmt->bind_param('ss', $date, $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booked_slots = [];
    while ($row = $result->fetch_assoc()) {
        $booked_slots[] = $row['timeslot'];
    }
    $stmt->close();

    // Find available slots
    $available_slots = array_diff($all_slots, $booked_slots);

    if (empty($available_slots)) {

        return true;
    }
}


// function isDateFullyBooked($date, $doctor_id, $mysqli)
// {

//     // Get the total number of time slots for the day
//     $duration = 30;
//     $cleanup = 10;
//     $start = "08:00";
//     $end = "17:00";
//     $all_slots = timeslots($duration, $cleanup, $start, $end);
//     $total_slots = count($all_slots);

//     $stmt = $mysqli->prepare("SELECT COUNT(DISTINCT timeslot) AS slot_count FROM appointment WHERE DATE = ? AND doctor_id = ?");
//     if (!$stmt) {
//         die('Prepare failed: ' . $mysqli->error);
//     }
//     $stmt->bind_param('si', $date, $doctor_id);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     $row = $result->fetch_assoc();
//     $stmt->close();





//     // echo $row['slot_count'];

//     // echo $total_slots;




//     echo $date;

//     // return ($row['slot_count'] >= $total_slots);
// }

function build_calendar($month, $year, $patient_id, $mysqli)
{
    global $doctor_id;
    $stmt = $mysqli->prepare("SELECT DATE FROM appointment WHERE MONTH(DATE) = ? AND YEAR(DATE) = ? AND patient_id = ?");
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

    $calendar = "<table class='table table-bordered'>";
    $calendar .= "<center><h2>$monthName $year</h2>";
    $calendar .= "<a class='btn btn-xs btn-danger' href='?month=" . date('m', mktime(0, 0, 0, $month - 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month - 1, 1, $year)) . "'>Previous Month</a> ";
    $calendar .= " <a class='btn btn-xs btn-success' href='?month=" . date('m') . "&year=" . date('Y') . "'>Current Month</a> ";
    $calendar .= "<a class='btn btn-xs btn-primary' href='?month=" . date('m', mktime(0, 0, 0, $month + 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month + 1, 1, $year)) . "'>Next Month</a></center><br>";

    $calendar .= "<tr>";
    foreach ($daysOfWeek as $day) {
        $calendar .= "<th class='header'>$day</th>";
    }
    $calendar .= "</tr><tr>";

    // if ($dayOfWeek > 0) {
    //     for ($k = 0; $k < $dayOfWeek; $k++) {
    //         $calendar .= "<td class='empty'></td>";
    //     }
    // }


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

        // $fullyBooked = isDateFullyBooked($date, $doctor_id, $mysqli);
        $fullyBooked = displayAvailableSlots($date, $doctor_id, $mysqli);

        if ($fullyBooked || $date < date('Y-m-d')) {
            // Date is fully booked or in the past, display as not clickable
            $calendar .= "<td class='$today'><h4>$currentDay</h4> <button class='btn btn-danger btn-xs' disabled>";
            $calendar .= $fullyBooked ? "<span class='glyphicon glyphicon-lock'></span> Fully Booked" : "<span class='glyphicon glyphicon-ban-circle'></span> Not Available";
            $calendar .= "</button></td>";
        } else {
            // Date is available for booking, include doctor_id in the URL
            $calendar .= "<td class='$today'><h4>$currentDay</h4> <a href='timeslots.php?date=" . $date . "&doctor_id=" . $doctor_id . "' class='btn btn-success btn-xs'><span class='glyphicon glyphicon-ok'></span> Book Now</a></td>";
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

                build_calendar($month, $year, $patient_id, $mysqli);
                ?>
            </div>
        </div>
        <a href="../new appointment.php"><button type="button" class="btn btn-primary text-white">Back</button></a>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>

</html>