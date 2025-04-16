<?php
header('Content-Type: application/json');
$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $studentId = $data['studentId'];
    $scholarshipNo = $data['scholarshipNo']; // Retrieve the scholarshipNo sent from JS

    if ($studentId && $scholarshipNo) {
        // Prepare the DELETE statement
        $sql_delete = "DELETE FROM tbl_application_scholarship WHERE Student_No = ? AND scholarship_no = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("ii", $studentId, $scholarshipNo);

        if ($stmt_delete->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "Error executing deletion."]);
        }

        $stmt_delete->close();
    } else {
        echo json_encode(["success" => false, "error" => "Invalid input data."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request method."]);
}

$conn->close();
