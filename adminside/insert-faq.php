<?php
$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    // Insert FAQ in the database
    $sql = "INSERT INTO tbl_faq (question, answer) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $question, $answer);

    if ($stmt->execute()) {
        echo "FAQ inserted successfully";
    } else {
        echo "Error inserting FAQ: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
