<?php
session_start();
require_once '../../../db conn.php';
require_once './timeslots-function.php';

if (isset($_GET['doctor_id'])) {
    $doctor_id = $_GET['doctor_id'];
    $patient_id = $_GET['patient_id'];
} elseif (isset($_POST['patient_id'])) {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
}

// Display available slots function
function displayAvailableSlots($date, $doctor_id, $patient_id, $conn)
{
    $all_slots = timeslots();
    $stmt = $conn->prepare("SELECT DISTINCT timeslot FROM appointment WHERE DATE = ? AND (doctor_id = ? OR patient_id = ?)");
    $stmt->bind_param('sss', $date, $doctor_id, $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booked_slots = [];
    while ($row = $result->fetch_assoc()) {
        $booked_slots[] = $row['timeslot'];
    }
    $stmt->close();
    return array_diff($all_slots, $booked_slots) ? false : true;
}

// Build calendar function
function build_calendar($month, $year, $patient_id, $conn)
{
    global $doctor_id;
    $stmt = $conn->prepare("SELECT DATE FROM appointment WHERE MONTH(DATE) = ? AND YEAR(DATE) = ? AND patient_id = ?");
    $stmt->bind_param('iis', $month, $year, $patient_id);
    $bookings = [];

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row['DATE'];
        }
        $stmt->close();
    }

    $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];

    $calendar = "<table class='table table-bordered'>";
    $calendar .= "<center><h2>$monthName $year</h2>";
    $calendar .= "<a class='btn btn-xs btn-danger' onclick='navigateMonth(" . ($month - 1) . ", $year)'>Previous Month</a> ";
    $calendar .= "<a class='btn btn-xs btn-success' onclick='navigateMonth(" . date('m') . ", " . date('Y') . ")'>Current Month</a> ";
    $calendar .= "<a class='btn btn-xs btn-primary' onclick='navigateMonth(" . ($month + 1) . ", $year)'>Next Month</a></center><br>";

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
        $fullyBooked = displayAvailableSlots($date, $doctor_id, $patient_id, $conn);

        if ($fullyBooked || $date < date('Y-m-d')) {
            $calendar .= "<td class='$today'><h4>$currentDay</h4> <button class='btn btn-danger btn-xs' disabled>";
            $calendar .= $fullyBooked ? "<span class='glyphicon glyphicon-lock'></span> Fully Booked" : "<span class='glyphicon glyphicon-ban-circle'></span> Not Available";
            $calendar .= "</button></td>";
        } else {
            $calendar .= "<td class='$today'><h4>$currentDay</h4> <a href='timeslots.php?date=" . $date . "&doctor_id=" . $doctor_id . "&patient_id=" . $patient_id . "' class='btn btn-success btn-xs'><span class='glyphicon glyphicon-ok'></span> Book Now</a></td>";
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
                <div id="calendar">
                    <div class="alert alert-primary bg-primary" style="border:none; color:#fff; display: flex; justify-content: space-between; align-items: center;">
                        <!-- Left-aligned button -->
                        <a href="../new appointment.php">
                            <button type="button" id="backButton" class="btn btn-light previous-btn ">&#8249;</button>
                        </a>

                        <!-- Centered Heading -->
                        <h1 class="text-center" style="flex-grow: 1; text-align: center;">Appointment Calendar</h1>
                    </div>

                </div>
            </div>
        </div>


    </div>

    <script>
        function loadCalendar(month, year) {
            // Hide the back button while fetching the calendar
            document.getElementById('backButton').style.display = 'none';

            fetch(`calendar_fetch.php?month=${month}&year=${year}&patient_id=<?php echo $patient_id; ?>&doctor_id=<?php echo $doctor_id; ?>`)
                .then(response => response.text())
                .then(data => {
                    // Update the calendar content
                    document.getElementById('calendar').innerHTML = data;

                    // Show the back button after the calendar is updated
                    document.getElementById('backButton').style.display = 'inline-block';
                })
                .catch(error => console.error('Error fetching calendar:', error));
        }

        // Function to navigate to the previous, current, or next month
        function navigateMonth(month, year) {
            loadCalendar(month, year); // Call loadCalendar to reload the calendar for the new month
        }

        // Load the current month's calendar on initial page load
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            loadCalendar(today.getMonth() + 1, today.getFullYear()); // Load current month
        });
    </script>


</body>

</html>