<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
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
    die("Connection failed: " . $conn->connect_error);
}

// Start the session to access session variables
session_start();

// Check if the user is logged in and retrieve Admin_id
if (!isset($_SESSION['Admin_id'])) {
    echo "User is not logged in.";
    exit();
} else {
    $Admin_id = $_SESSION['Admin_id'];
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST['title'];
    $body = $_POST['body'];
    $when = $_POST['zwhen'];
    $where = $_POST['zwhere'];
    $posted_to = $_POST['posted_to'];

    // Handle file upload
    $ann_pic = '';
    if (isset($_FILES['pic_ann']) && $_FILES['pic_ann']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['pic_ann']['tmp_name'];
        $fileName = $_FILES['pic_ann']['name'];
        $fileType = $_FILES['pic_ann']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (in_array($fileExtension, $allowedExtensions) && in_array($fileType, $allowedMimeTypes)) {
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = './admin-UPLOAD_FILEs/announcement_images/';
            $destPath = $uploadFileDir . $newFileName;

            // Create upload directory if not exists
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            // Move the file to the upload directory
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $ann_pic = $newFileName; // Store file name to database
            } else {
                echo "Error moving the uploaded file.";
                exit;
            }
        } else {
            // Invalid file type
            echo "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
            exit;
        }
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO tbl_announcement (title, body, zwhen, zwhere, posted_to, ann_pic, Admin_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $title, $body, $when, $where, $posted_to, $ann_pic, $Admin_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New announcement posted successfully!";

        if ($posted_to === 'all') {
            $emailQuery = "SELECT email_address FROM tbl_student_acc";
        } else {
            $emailQuery = "
                SELECT tbl_student_acc.email_address
                FROM tbl_student_acc
                JOIN tbl_application_scholarship ON tbl_student_acc.student_no = tbl_application_scholarship.student_no
                WHERE tbl_application_scholarship.c_status = ?";
        }

        $emailStmt = $conn->prepare($emailQuery);
        if ($posted_to !== 'all') {
            $emailStmt->bind_param("s", $posted_to);
        }
        $emailStmt->execute();
        $emailResult = $emailStmt->get_result();

        // Fetch email addresses into an array
        $emailAddresses = [];
        while ($row = $emailResult->fetch_assoc()) {
            $emailAddresses[] = $row['email_address'];
        }

        if (!empty($emailAddresses)) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'scholarshipsystem1@gmail.com';
                $mail->Password   = 'tmpn yszw tasf wfue';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   
                $mail->Port       = 587;

                $mail->setFrom("scholarshipsystem1@gmail.com", "Scholarship System");
                $mail->isHTML(true);
                $mail->Subject = "New Announcement by Scholarship System";
                $loginUrl = "http://localhost/scholarship/homepage/homepage.php"; // Update with your login URL
                $emailMessage = "
                    <p><strong>📣 New Announcement 📣</strong></p>
                    <p><strong>Title:</strong> $title</p>
                    <p>We are pleased to inform you of an important update. To review the full details of this announcement, please click the following link: <a href='$loginUrl'>View Announcement</a>.</p>
                    <p>Should you have any questions or require further information, please do not hesitate to contact us.</p>
                    <p>Best regards,<br>The Scholarship System Team</p>";
                $mail->Body = $emailMessage;

                // Add all email addresses to BCC
                foreach ($emailAddresses as $emailAddress) {
                    $mail->addBCC($emailAddress);
                }

                // Send the email
                $mail->send();
                echo "Email sent to all recipients successfully!";
            } catch (Exception $e) {
                echo "Error sending email: " . $mail->ErrorInfo;
            }
        } else {
            echo "No student emails found.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>