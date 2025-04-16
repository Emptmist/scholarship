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

$searchTerm = isset($_POST['search_pending']) ? trim($_POST['search_pending']) : '';
$role = isset($_POST['req_name']) ? $_POST['req_name'] : '';
$searchDate = isset($_POST['search_date']) ? trim($_POST['search_date']) : '';

$searchTermEscaped = $conn->real_escape_string($searchTerm);
$searchDateEscaped = $conn->real_escape_string($searchDate);

if ($role === 'coordinator' || $role === '') {
    $dateCondition = $searchDateEscaped ? "AND DATE(tbl_admin_history.login_time) = '$searchDateEscaped'" : '';

    $sql_query = "
    SELECT 
            tbl_admin_history.email AS Email,
            tbl_admin_history.login_time AS last_login_time,
            tbl_admin_history.logout_time AS last_logout_time
        FROM 
            tbl_admin_history
        JOIN 
            tbl_admin_account
        ON 
            tbl_admin_history.email = tbl_admin_account.email
        WHERE 
            tbl_admin_account.email LIKE '%$searchTermEscaped%'
            $dateCondition
        ORDER BY 
            tbl_admin_history.admin_login_no DESC
    ";

    $result_query = $conn->query($sql_query);

    if ($result_query->num_rows > 0) {
        $row_count = 0; // Counter for row colors

        while ($row = $result_query->fetch_assoc()) {
            // Alternate row color
            $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
            $row_count++;

            $loginTime = $row['last_login_time'] ? htmlspecialchars($row['last_login_time']) : 'No login record';
            $logoutTime = $row['last_logout_time'] ? htmlspecialchars($row['last_logout_time']) : 'Currently Logged In';
            echo "<tr class='$row_class'>
                    <td>" . htmlspecialchars($row['Email']) . "</td>
                    <td> Data Not Available </td>
                    <td>" . $loginTime . "</td>
                    <td>" . $logoutTime . "</td>
                    <td style='color: green; font-weight: bold;'>ACTIVE</td>
                  </tr>";
        }
    }
} 

if ($role === 'student' || $role === '') {
    $dateCondition = $searchDateEscaped ? "AND DATE(tbl_student_history.login_time) = '$searchDateEscaped'" : '';

    $sql_query = "
        SELECT 
            tbl_student_acc.email_address AS Email,
            tbl_student_history.login_time AS last_login_time,
            tbl_student_history.logout_time AS last_logout_time,
            MAX(tbl_application_scholarship.application_date) AS latest_applied_date,
            tbl_student_acc.verification_status AS verification_status
        FROM 
            tbl_student_history
        JOIN 
            tbl_student_acc
        ON 
            tbl_student_history.email = tbl_student_acc.email_address
        LEFT JOIN 
            tbl_application_scholarship
        ON 
            tbl_student_acc.student_no = tbl_application_scholarship.student_no
        WHERE 
            tbl_student_acc.email_address LIKE '%$searchTermEscaped%'
            $dateCondition
        GROUP BY 
            tbl_student_acc.email_address, tbl_student_history.login_time, tbl_student_history.logout_time
        ORDER BY
            tbl_student_history.student_login_no DESC
    ";

    $result_query = $conn->query($sql_query);

    if ($result_query->num_rows > 0) {
        $row_count = 0; // Counter for row colors

        while ($row = $result_query->fetch_assoc()) {
            // Alternate row color
            $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
            $row_count++;

            $appliedDate = $row['latest_applied_date'];
            $currentDate = new DateTime();

            // Ensure $appliedDate is a valid date
            $appliedDateObj = $appliedDate ? new DateTime($appliedDate) : null;

            if ($appliedDateObj) {
                $interval = $currentDate->diff($appliedDateObj);

                // Format the date based on the interval
                if ($interval->days == 0) {
                    $formattedDate = 'Today';
                } elseif ($interval->y > 0) {
                    $formattedDate = $interval->y . ' year(s) ago';
                } elseif ($interval->m > 0) {
                    $formattedDate = $interval->m . ' month(s) ago';
                } elseif ($interval->d >= 7) {
                    $weeks = floor($interval->d / 7);
                    $formattedDate = $weeks . ' week(s) ago';
                } elseif ($interval->d > 0) {
                    $formattedDate = $interval->d . ' day(s) ago';
                } elseif ($interval->h > 0) {
                    $formattedDate = $interval->h . ' hour(s) ago';
                } elseif ($interval->i > 0) {
                    $formattedDate = $interval->i . ' minute(s) ago';
                } else {
                    $formattedDate = 'Just now';
                }
            } else {
                $formattedDate = 'No application record';
            }

            // Check for NULL values
            $lastLoginTime = $row['last_login_time'] ? htmlspecialchars($row['last_login_time']) : 'No login record';
            $lastLogoutTime = $row['last_logout_time'] ? htmlspecialchars($row['last_logout_time']) : 'Currently Logged In';
            
            // Determine action based on verification status
            $verificationStatus = $row['verification_status'];
            $action = $verificationStatus == 0 ? 'DEACTIVATED' : 'ACTIVE';
            $actionColor = $verificationStatus == 0 ? 'red' : 'green';

            echo "<tr class='$row_class'>
                    <td>" . htmlspecialchars($row['Email']) . "</td>
                    <td>" . htmlspecialchars($formattedDate) . "</td>
                    <td>" . $lastLoginTime . "</td>
                    <td>" . $lastLogoutTime . "</td>
                    <td style='color: $actionColor; font-weight: bold;'>$action</td>
                  </tr>";
        }
    }
}

if ($role === '' || ($role !== 'student' && $role !== 'coordinator')) {
    echo "<tr><td colspan='5'> List of All Students & Coordinator</td></tr>";
}

$conn->close();
?>
