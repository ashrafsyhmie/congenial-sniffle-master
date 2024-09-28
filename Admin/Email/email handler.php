<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'medassist.admin@medassist.icu';                     //SMTP username
    $mail->Password   = '#2!U7Iw7@';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('medassist.admin@medassist.icu', 'MedAssist');
    $mail->addAddress('icerafsyahmie12@gmail.com', 'Ashraf Syahmie');     //Add a recipient           //Name is optional
    $mail->addReplyTo('medassist.admin@medassist.icu', 'Customer Center');



    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "Upcoming Appointment Reminder - [Doctor's Name] on [Appointment Date]";
    $mail->Body    = 'Dear [Patient Name],<br>

We hope this message finds you well.<br>

This is a friendly reminder about your upcoming appointment with [Doctor’s Name] on **[Appointment Date]** at **[Appointment Time]**.<br>
Please make sure to arrive 10-15 minutes early for any necessary preparations.<br>

**Appointment Details:**
- **Doctor:** [Doctor’s Name]<br>
- **Date:** [Appointment Date]<br>
- **Time:** [Appointment Time]<br>
- **Location:** [Clinic Address]<br>

If you need to reschedule or have any questions, feel free to reply to this email or call us at [Clinic Contact Number].<br><br>

We look forward to seeing you!<br><br>

Best regards,  <br>
MedAssisst  <br>
[Clinic Contact Information]<br>
';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>
<br>
<button><a href="http://localhost/congenial-sniffle-master/admin/homepage.php"></a>Back</button>