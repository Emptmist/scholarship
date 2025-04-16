<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the default time zone to the Philippines
date_default_timezone_set('Asia/Manila');

if (isset($_SESSION['Student_No'])) {
    // Prepare and execute statement to get email for student
    $email_sql = "SELECT Email_address FROM tbl_student_acc WHERE Student_No = ?";
    $stmt_email = $conn->prepare($email_sql);
    if ($stmt_email === false) {
        error_log("Prepare failed: " . $conn->error);
        exit();
    }
    $stmt_email->bind_param("s", $_SESSION['Student_No']);
    $stmt_email->execute();
    $email_result = $stmt_email->get_result();

    if ($email_result->num_rows > 0) {
        $email_row = $email_result->fetch_assoc();
        $email = $email_row['Email_address'];

        // Prepare and execute statement to get the most recent login record for the student
        $recent_login_sql = "SELECT student_login_no FROM tbl_student_history 
                             WHERE email = ? AND logout_time IS NULL
                             ORDER BY login_time DESC LIMIT 1";
        $stmt_recent_login = $conn->prepare($recent_login_sql);
        if ($stmt_recent_login === false) {
            error_log("Prepare failed: " . $conn->error);
            exit();
        }
        $stmt_recent_login->bind_param("s", $email);
        $stmt_recent_login->execute();
        $recent_login_result = $stmt_recent_login->get_result();

        if ($recent_login_result->num_rows > 0) {
            $login_row = $recent_login_result->fetch_assoc();
            $login_no = $login_row['student_login_no'];
            $logout_time = date('Y-m-d H:i:s');

            // Prepare and execute statement to update logout time for the specific login record
            $update_history = "UPDATE tbl_student_history SET logout_time = ? WHERE student_login_no = ?";
            $stmt_update = $conn->prepare($update_history);
            if ($stmt_update === false) {
                error_log("Prepare failed: " . $conn->error);
                exit();
            }
            $stmt_update->bind_param("ss", $logout_time, $login_no);

            if (!$stmt_update->execute()) {
                error_log("Update failed: " . $stmt_update->error);
            }

            // Clear session
            unset($_SESSION['Student_No']);
        } else {
            error_log("No active login record found for student number: " . $_SESSION['Student_No']);
        }
    } else {
        error_log("No email found for student number: " . $_SESSION['Student_No']);
    }

} else if (isset($_SESSION['Admin_id'])) {
    // Prepare and execute statement to get email for admin
    $email_sql = "SELECT Email FROM tbl_admin_account WHERE Admin_id = ?";
    $stmt_email = $conn->prepare($email_sql);
    if ($stmt_email === false) {
        error_log("Prepare failed: " . $conn->error);
        exit();
    }
    $stmt_email->bind_param("s", $_SESSION['Admin_id']);
    $stmt_email->execute();
    $email_result = $stmt_email->get_result();

    if ($email_result->num_rows > 0) {
        $email_row = $email_result->fetch_assoc();
        $email = $email_row['Email'];

        // Prepare and execute statement to get the most recent login record for the admin
        $recent_login_sql = "SELECT admin_login_no FROM tbl_admin_history 
                             WHERE email = ? AND logout_time IS NULL
                             ORDER BY login_time DESC LIMIT 1";
        $stmt_recent_login = $conn->prepare($recent_login_sql);
        if ($stmt_recent_login === false) {
            error_log("Prepare failed: " . $conn->error);
            exit();
        }
        $stmt_recent_login->bind_param("s", $email);
        $stmt_recent_login->execute();
        $recent_login_result = $stmt_recent_login->get_result();

        if ($recent_login_result->num_rows > 0) {
            $login_row = $recent_login_result->fetch_assoc();
            $login_no = $login_row['admin_login_no'];
            $logout_time = date('Y-m-d H:i:s');

            // Prepare and execute statement to update logout time for the specific login record
            $update_history = "UPDATE tbl_admin_history SET logout_time = ? WHERE admin_login_no = ?";
            $stmt_update = $conn->prepare($update_history);
            if ($stmt_update === false) {
                error_log("Prepare failed: " . $conn->error);
                exit();
            }
            $stmt_update->bind_param("ss", $logout_time, $login_no);

            if (!$stmt_update->execute()) {
                error_log("Update failed: " . $stmt_update->error);
            }

            // Clear session
            unset($_SESSION['Admin_id']);
        } else {
            error_log("No active login record found for admin ID: " . $_SESSION['Admin_id']);
        }
    } else {
        error_log("No email found for admin ID: " . $_SESSION['Admin_id']);
    }
}

session_destroy();
header("Location: login_page.php"); // Redirect to login page
exit;
?>
