<?php
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

// Get filter values
$filterAnnounceStatus = isset($_GET['filter-announcement']) ? $_GET['filter-announcement'] : '';

$sqlAnnouncement = "
    SELECT no_announcement, title, posted_to, post_date, Admin_id
    FROM tbl_announcement
    WHERE ('$filterAnnounceStatus' = '' OR posted_to = '$filterAnnounceStatus')
    ORDER BY post_date DESC";

$resultAnnouncement = $conn->query($sqlAnnouncement);

//echo "<h2>Announcement Creation Log</h2>";
if ($resultAnnouncement->num_rows > 0) {
    echo "<table>
            <thead>
                <tr>
                    <th>Announcement No</th>
                    <th>Title</th>
                    <th>Posted To</th>
                    <th>Post Date</th>
                    <th>Admin ID</th>
                </tr>
            </thead>
            <tbody>";
            $row_count = 0;
    while ($row = $resultAnnouncement->fetch_assoc()) {
       
        $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
        $row_count++;
        // Set color based on the posted_to value
        $color = '';
        switch ($row['posted_to']) {
            case 'approved':
                $color = '#25A55F';
                break;
            case 'rejected':
                $color = 'red';
                break;
            case 'pending':
                $color = 'gray';
                break;
        }

        echo "<tr class='$row_class'>
                <td>" . htmlspecialchars($row['no_announcement']) . "</td>
                <td>" . htmlspecialchars($row['title']) . "</td>
                <td style='color: $color;'>" . htmlspecialchars($row['posted_to']) . "</td>
                <td>" . htmlspecialchars($row['post_date']) . "</td>
                <td>" . htmlspecialchars($row['Admin_id']) . "</td>
            </tr>";
    }
    echo "</tbody></table><br><br>";
} else {
    echo "No announcement creation activity found.<br><br>";
}

$conn->close();
?>