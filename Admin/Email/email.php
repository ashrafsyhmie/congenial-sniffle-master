<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Sender GUI</title>
</head>

<body>
    <h2>Send Email to Patients</h2>
    <form action="./email send(manual).php" method="POST">
        <label for="recipients">Recipient Emails (comma-separated):</label><br>
        <input type="text" id="recipients" name="recipients" required><br><br>

        <label for="subject">Subject:</label><br>
        <input type="text" id="subject" name="subject" required><br><br>

        <label for="body">Email Body:</label><br>
        <textarea id="body" name="body" rows="10" cols="30" required></textarea><br><br>

        <input type="submit" value="Send Email">
    </form>
</body>

</html>