<?php
header('Content-Type: application/json');
$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $attachmentName = $data['attachment_name'];
    $studentId = $data['student_id'];

    if ($attachmentName && $studentId) {
        $sql_fetch = "SELECT Name_Attachment FROM tbl_req_attachment WHERE Student_No = ? AND Name_Attachment = ?";
        $stmt_fetch = $conn->prepare($sql_fetch);
        $stmt_fetch->bind_param("is", $studentId, $attachmentName);
        $stmt_fetch->execute();
        $result_fetch = $stmt_fetch->get_result();

        if ($result_fetch->num_rows > 0) {
            $row = $result_fetch->fetch_assoc();
            $filePath = 'UPLOAD_files/' . $row['Name_Attachment'];

            // Delete the file if it exists
            if (file_exists($filePath)) {
                if (!unlink($filePath)) {
                    echo json_encode(['success' => false, 'message' => 'Failed to delete the file.']);
                    exit;
                }
            }

            // Delete from the database
            $sql_delete = "DELETE FROM tbl_req_attachment WHERE Student_No = ? AND Name_Attachment = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("is", $studentId, $attachmentName);
            if ($stmt_delete->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete the database record.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'File not found in database.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

$conn->close();
?>
