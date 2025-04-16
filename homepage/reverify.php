<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require '../vendor/autoload.php';
require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_scholarship_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the date one year ago from today
$date_one_year_ago = date('Y-m-d', strtotime('-1 year'));

// Prepare the SQL query to select students with applications older than one year
$sql_select = "
    SELECT 
        tbl_student_acc.email_address,
        tbl_student_acc.Verification_Token,
        tbl_student_acc.student_no
    FROM 
        tbl_student_acc
    JOIN 
        tbl_application_scholarship 
    ON 
        tbl_student_acc.student_no = tbl_application_scholarship.student_no
    WHERE 
        tbl_application_scholarship.application_date <= ?
";

// Prepare and execute the select query
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("s", $date_one_year_ago);
$stmt_select->execute();
$result = $stmt_select->get_result();

// Email configuration
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
    $mail->SMTPAuth   = true;
    $mail->Username   = 'scholarshipsystem1@gmail.com'; // SMTP username
    $mail->Password   = 'tmpn yszw tasf wfue'; // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('scholarshipsystem1@gmail.com', 'Scholarship System');
    $mail->isHTML(true);
    $mail->Subject = 'Account Deactivation Notification';

    // Prepare the email body
    $mailBody = '
        <p>Dear Student,</p>
        <p>We hope this message finds you well.</p>
        <p>We are writing to inform you that your account with the Scholarship System has been deactivated due to inactivity. Our records indicate that there has been no activity on your account for over one year.</p>
        <p>If you believe this to be an error or if you wish to reactivate your account, please log in to the Scholarship System and follow the instructions to re-verify your details. If you encounter any issues, feel free to contact our support team for assistance.</p>
        <p>Thank you for your attention to this matter.</p>
        <p>Best regards,</p>
        <p>The Scholarship System Team</p>
        <p>Verify <a href="http://localhost/scholarship/homepage/email_verification.php?token={{token}}">Now</a></p> 
    ';

    // Loop through each student and process
    while ($row = $result->fetch_assoc()) {
        // Update verification status to 0
        $sql_update_status = "UPDATE tbl_student_acc SET Verification_Status = 0 WHERE student_no = ?";
        $stmt_update_status = $conn->prepare($sql_update_status);
        $stmt_update_status->bind_param("s", $row['student_no']);
        $stmt_update_status->execute();
        $stmt_update_status->close();

        // Send email
        $mail->Body = str_replace('{{token}}', $row['Verification_Token'], $mailBody);
        $mail->addAddress($row['email_address']);
        try {
            $mail->send();
            $mail->clearAddresses(); // Clear addresses after sending to prevent sending to all recipients in one go
        } catch (Exception $e) {
            echo "Error sending email to " . $row['email_address'] . ": " . $mail->ErrorInfo;
        }

        // Delete records from tbl_application_scholarship
        $sql_delete = "DELETE FROM tbl_application_scholarship WHERE student_no = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("s", $row['student_no']);
        $stmt_delete->execute();
        $stmt_delete->close();
    }

} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}

$stmt_select->close();
$conn->close();
?>
