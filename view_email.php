<?php
// Hostinger IMAP settings
$hostname = '{imap.hostinger.com}INBOX'; // Replace with your IMAP host
$username = 'medassist.admin@medassist.icu';  // Replace with your full email
$password = '#2!U7Iw7@'; // Your email password

// Open an IMAP connection
$inbox = imap_open($hostname, $username, $password) or die('Cannot connect to mail server: ' . imap_last_error());

// Get the email number from the query string
$email_number = isset($_GET['email_number']) ? intval($_GET['email_number']) : 0;

// Fetch the overview of the email
$overview = imap_fetch_overview($inbox, $email_number, 0);

// Safely access properties with null checks
$from = isset($overview[0]->from) ? htmlspecialchars($overview[0]->from) : 'Unknown Sender';
$subject = isset($overview[0]->subject) ? htmlspecialchars($overview[0]->subject) : 'No Subject';
$date = isset($overview[0]->date) ? htmlspecialchars($overview[0]->date) : 'Unknown Date';

// Fetch the full email structure
$structure = imap_fetchstructure($inbox, $email_number);

// Initialize the message variable
$message = '';

// Check if the email is multipart
if (isset($structure->parts) && count($structure->parts)) {
    // Loop through the parts to find the HTML part
    foreach ($structure->parts as $part) {
        // Check if the part is HTML
        if (isset($part->subtype) && strtolower($part->subtype) === 'html') {
            // Fetch the HTML body
            $message = imap_fetchbody($inbox, $email_number, $part->ifdisposition ? 2 : 1);
            break; // Exit the loop once we've found the HTML part
        }
    }
} else {
    // If the email is not multipart, get the body directly
    $message = imap_fetchbody($inbox, $email_number, 1);
}

// Close the IMAP connection
imap_close($inbox);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>View Email</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div class="email-view">
        <h2><?php echo $subject; ?></h2>
        <p><strong>From:</strong> <?php echo $from; ?></p>
        <p><strong>Date:</strong> <?php echo $date; ?></p>
        <div class="email-content">
            <?php
            // Display the full email message safely
            echo $message; // Echo the HTML content directly
            ?>
        </div>
    </div>
    <style>
        /* Styling for the full email view */
        .email-view {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 600px;
            margin: 20px auto;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .email-content {
            margin-top: 20px;
            color: #333;
        }
    </style>
</body>

</html>