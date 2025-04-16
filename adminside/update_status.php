<?php
header('Content-Type: application/json');
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]));
}

// Check if the session variable is set
if (isset($_SESSION['Admin_id'])) {
    $Admin_id = $_SESSION['Admin_id'];
} else {
    die(json_encode(['success' => false, 'message' => 'Admin ID not set.']));
}

// Get POST data
$student_no = $_POST['student_no'];
$scholarship_no = $_POST['scholarship_no'];
$status = $_POST['status'];
$reason = isset($_POST['reason']) ? $_POST['reason'] : '';

// Prepared statement to update the status
if ($status === 'rejected') {
    $sql = "UPDATE tbl_application_scholarship SET C_status = ?, rejection_reason = ?, Admin_id = ?, processed_date = CURRENT_TIMESTAMP WHERE scholarship_no = ? AND Student_No = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiii", $status, $reason, $Admin_id, $scholarship_no, $student_no);
} elseif ($status === 'approved') {
    $reason = 'Congratulations! Your application has been approved as your grades exceeded our criteria. We look forward to supporting your academic journey. Thank you.';
    $sql = "UPDATE tbl_application_scholarship SET C_status = ?, rejection_reason = ?, Admin_id = ?, processed_date = CURRENT_TIMESTAMP WHERE scholarship_no = ? AND Student_No = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiii", $status, $reason, $Admin_id, $scholarship_no, $student_no);
} else {
    $sql = "UPDATE tbl_application_scholarship SET C_status = ?, Admin_id = ? WHERE scholarship_no = ? AND Student_No = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siii", $status, $Admin_id, $scholarship_no, $student_no);
}

// Execute the query and check for success
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error updating status: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
