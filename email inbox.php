<?php
// Hostinger IMAP settings
$hostname = '{imap.hostinger.com}INBOX'; // Replace with your IMAP host
$username = 'medassist.admin@medassist.icu';  // Replace with your full email
$password = '#2!U7Iw7@'; // Your email password


// Open an IMAP connection
$inbox = imap_open($hostname, $username, $password) or die('Cannot connect to mail server: ' . imap_last_error());

// Search for all emails in the inbox
$emails = imap_search($inbox, 'ALL');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Email Inbox</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <style>
        /* Styling for the email inbox */
        .email-inbox {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .email-list {
            margin-top: 20px;
        }

        .email-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .email-item:last-child {
            border-bottom: none;
        }

        .email-sender {
            color: #007bff;
            font-weight: bold;
        }

        .email-subject {
            flex-grow: 1;
            margin-left: 20px;
            color: #555;
        }

        .email-date {
            color: #999;
            font-size: 12px;
        }

        .email-item:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }
    </style>
    <div class="email-inbox">
        <h2>Inbox</h2>
        <div class="email-list">
            <?php
            // If emails were found
            if ($emails) {
                // Sort emails from newest to oldest
                rsort($emails);

                // Loop through each email and display its details
                // Loop through each email and display its details
                foreach ($emails as $email_number) {
                    // Fetch the email's overview (headers)
                    $overview = imap_fetch_overview($inbox, $email_number, 0);

                    // Safely access properties with null checks
                    $from = isset($overview[0]->from) ? htmlspecialchars($overview[0]->from) : 'Unknown Sender';
                    $subject = isset($overview[0]->subject) ? htmlspecialchars($overview[0]->subject) : 'No Subject';
                    $date = isset($overview[0]->date) ? htmlspecialchars($overview[0]->date) : 'Unknown Date';

                    // Display the email's sender, subject, and date with a link to the full email
                    echo '<div class="email-item">';
                    echo '<a href="view_email.php?email_number=' . $email_number . '" style="text-decoration: none; color: inherit;">';
                    echo '<div class="email-sender">' . $from . '</div>';
                    echo '<div class="email-subject">' . $subject . '</div>';
                    echo '<div class="email-date">' . $date . '</div>';
                    echo '</a>';
                    echo '</div>';
                }
            } else {
                // If no emails were found
                echo '<p>No emails found.</p>';
            }

            // Close the IMAP connection
            imap_close($inbox);
            ?>
        </div>
    </div>
</body>

</html>