<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require '../vendor/autoload.php';

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_scholarship_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo 'Database connection failed: ' . $conn->connect_error;
    exit;
}

// Retrieve and validate email address and password from POST request
$email = filter_var($_POST['admin_email'] ?? '', FILTER_VALIDATE_EMAIL);
$admin_password = $_POST['admin_password'] ?? '';

if (!$email || empty($admin_password)) {
    http_response_code(400);
    echo 'Invalid email address or password.';
    exit;
}

// Hash the password
$hash_pass = password_hash($admin_password, PASSWORD_DEFAULT);

// Insert new admin into the database
$sql = $conn->prepare("INSERT INTO tbl_admin_account (Email, Password) VALUES (?, ?)");
$sql->bind_param('ss', $email, $hash_pass);

if (!$sql->execute()) {
    http_response_code(500);
    echo 'Failed to add admin to the database.';
    $conn->close();
    exit;
}

// Get the last inserted ID
$new_admin_id = $conn->insert_id;

// Email configuration
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'scholarshipsystem1@gmail.com';
    $mail->Password   = 'tmpn yszw tasf wfue';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('scholarshipsystem1@gmail.com', 'Scholarship System');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Welcome to the Scholarship System';

    // Prepare the email body
    $mailBody = '
        <html>
        <head>
            <title>Welcome to the Scholarship System</title>
        </head>
        <body>
            <p>Good day!</p>
            <p>You have been added as an admin to the Scholarship System.</p>
            <p>Your login details are as follows:</p>
            <p>User ID: <strong>' . htmlspecialchars($new_admin_id) . ' </strong></p>
            <p>Your Temporary Password:<strong> ' . htmlspecialchars($admin_password) . '</strong></p>
            <p>For your security, we strongly advise that you change your password immediately upon logging in. You can update your password through the user settings page after your first <a href="http://localhost:3000/homepage/login_page.php">Login</p>
    
    <p>If you have any questions or encounter any issues, please do not hesitate to contact our support team.</p>
    
    <p>Thank you for joining us, and we look forward to your contributions to the Scholarship System.</p>
    
    <p>Best regards,<br>The Scholarship System Team</p>
        </body>
        </html>
    ';

    // Send email
    $mail->Body = $mailBody;
    $mail->send();

    echo 'Admin added and email sent successfully.';
} catch (Exception $e) {
    http_response_code(500);
    echo 'Failed to send email. Error: ' . $mail->ErrorInfo;
}

// Close the database connection
$conn->close();
