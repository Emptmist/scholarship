<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_scholarship_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

session_start();

include '../homepage/Time_Expiration.php';
scholarship_expiration($conn);

if (!isset($_SESSION['Admin_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ../homepage/login_page.php");
    exit();
}else{
    $Admin_id = $_SESSION['Admin_id'];
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Query to get counts based on C_Status
$sql = "SELECT C_Status, COUNT(*) as count FROM tbl_application_scholarship GROUP BY C_Status";
$result = $conn->query($sql);

$data = [];
$colorMapping = [
    'Pending' => '#83C78E',
    'Approved' => '#CAF2D0',
    'Rejected' => '#39563C'
];

while ($row = $result->fetch_assoc()) {
    $data[] = [$row['C_Status'], (int)$row['count']];
}

$jsonData = json_encode($data);
$jsonColors = json_encode(array_values($colorMapping));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- STYLESHEET -->
    <link rel="stylesheet" href="style.css" />

    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <!-- will change these link/script once actual file used in this link is found-->
    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!--icon website-->
    <link rel="icon" type="image/x-icon" href="logo.png">

    <!--icons-->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!--SweetAlert2-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- own css -->
    <link rel="stylesheet" href="admin_dash.css">
    <link rel="stylesheet" href="retri-ann.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.4/dist/sweetalert2.all.min.js"></script>
    <script src="sidebar.js"></script>
    <script src="popup.js"></script>
    <script src="retri-ann_script.js"></script>

    <style>
        /* Center the chart container */
        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        #donutchart {
            width: 400px;
            height: 400px;
        }
    </style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Status', 'Count'],
                <?php
                foreach ($data as $d) {
                    echo "['" . $d[0] . "', " . $d[1] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Scholarship Status',
                pieHole: 0.4,
                legend: {
                    position: 'bottom'
                },
                colors: <?php echo $jsonColors; ?> // Use the colors array from PHP
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        }
    </script>

    <title>Coordinator Dashboard</title>
</head>

<body>
    <!-- Side bar -->
    <div class="sidebar open">
        <div class="home-content">
            <i class='bx bx-menu'></i>
        </div>
        <div class="logo-details justify-content-center">
            <span class="logo_name">SCHOLARSHIP SYSTEM</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="admin_profile.php">
                    <i class='bx bxs-user'></i>
                    <span class="link_name">PROFILE</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">PROFILE</a></li>
                </ul>
            </li>
            <li style="border-radius: 5px;
background: rgba(244, 244, 244, 0.20);
box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.25);">
                <a href="admin_dash.php">
                    <i class='bx bxs-home'></i>
                    <span class="link_name">DASHBOARD</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">DASHBOARD</a></li>
                </ul>
            </li>
            <li>
                <a href="admin_application.php">
                    <i class='bx bxs-copy-alt'></i>
                    <span class="link_name">APPLICATIONS</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">APPLICATIONS</a></li>
                </ul>
            </li>
            <li>
                <a href="scholarship.php">
                    <i class='bx bxs-graduation'></i>
                    <span class="link_name ">SCHOLARSHIP</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">SCHOLARSHIP</a></li>
                </ul>
            </li>
            <li>
                <a href="admin_setting.php">
                    <i class='bx bx-cog'></i>
                    <span class="link_name">SETTING</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">SETTING</a></li>
                </ul>
            </li>
            <li>
                <a href="" id="logout-link">
                    <i class='bx bxs-log-out'></i>
                    <span class="link_name ">LOG OUT</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">LOG OUT</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <section class="home-section ">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <span class="ms-4 fw-bold">DASHBOARD</span>
                <div class="d-flex ms-auto">
                    <a href="#" class="nav-link d-flex align-items-center" style="color: #25A55F;">
                        <span class="me-2 fw-normal">SCHOLARSHIP COORDINATOR</span>
                        <i class='bx bxs-user-circle custom-icon'></i>
                    </a>
                </div>
            </div>
        </nav>

        <hr>

        <!--popup buttons-->
        <div class="container-fluid px-5" id="div1">
            <div class="row gx-5">
                <div class="col">
                    <div class="row my-5">
                        <div class="p-4 border rounded-3 shadow-sm d-flex position-relative trigger view" data-popup="popup1">
                            <i class='bx bxs-graduation pop-icon p-2'></i>
                            <span class="d-inline mx-3">
                                <p class="fs-5 mb-1">APPLIED</p>
                                <p class="fs-2 m-0 p-0" style="color: #346473;">
                                    <?php
                                    // SQL query to count rows
                                    $sql = "SELECT  COUNT(*) as count FROM tbl_application_scholarship WHERE C_status = 'approved' OR C_status = 'rejected' OR C_status = 'pending'";
                                    $result = $conn->query($sql);

                                    // Fetch the result
                                    $row_count = 0;
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $row_count = $row['count'];
                                        echo $row_count;
                                    } else {
                                        echo "0";
                                    }
                                    ?>

                                </p>
                            </span>
                            <i class='bx bx-arrow-back bx-rotate-180 arrow-icon position-absolute m-3'></i>
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="p-4 border view   rounded-3 shadow-sm d-flex position-relative trigger" data-popup="popup2">
                            <i class='bx bxs-user-check pop-icon p-2'></i>
                            <span class="d-inline mx-3">
                                <p class="fs-5 mb-2">APPROVED</p>
                                <p class="fs-2 m-0 p-0" style="color: #346473;">
                                    <?php
                                    // SQL query to count rows
                                    $sql = "SELECT  COUNT(*) as count FROM tbl_application_scholarship WHERE C_status = 'approved'";
                                    $result = $conn->query($sql);

                                    // Fetch the result
                                    $row_count = 0;
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $row_count = $row['count'];
                                        echo $row_count;
                                    } else {
                                        echo "0";
                                    }
                                    ?>
                                </p>
                            </span>
                            <i class='bx bx-arrow-back bx-rotate-180 arrow-icon position-absolute m-3'></i>
                        </div>
                    </div>
                    <div class="row my-5 ">
                        <div class="p-4 border    rounded-3 shadow-sm d-flex position-relative trigger view" data-popup="popup3">
                            <i class='bx bxs-x-circle pop-icon p-2'></i>
                            <span class="d-inline mx-3">
                                <p class="fs-5 mb-2">REJECTED</p>
                                <p class="fs-2 m-0 p-0" style="color: #346473;">
                                    <?php
                                    // SQL query to count rows
                                    $sql = "SELECT COUNT(*) as count FROM tbl_application_scholarship WHERE C_status = 'rejected'";
                                    $result = $conn->query($sql);

                                    // Fetch the result
                                    $row_count = 0;
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $row_count = $row['count'];
                                        echo $row_count;
                                    } else {
                                        echo "0";
                                    }
                                    ?>
                                </p>
                            </span>
                            <i class='bx bx-arrow-back bx-rotate-180 arrow-icon position-absolute m-3'></i>
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="p-4 border    rounded-3 shadow-sm d-flex position-relative trigger view" data-popup="popup4">
                            <i class='bx bxs-stopwatch pop-icon p-2'></i>
                            <span class="d-inline mx-3">
                                <p class="fs-5 mb-2">PENDING</p>
                                <p class="fs-2 m-0 p-0" style="color: #346473;">
                                    <?php
                                    // SQL query to count rows
                                    $sql = "SELECT COUNT(*) as count FROM tbl_application_scholarship WHERE C_status = 'pending'";
                                    $result = $conn->query($sql);

                                    // Fetch the result
                                    $row_count = 0;
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $row_count = $row['count'];
                                        echo $row_count;
                                    } else {
                                        echo "0";
                                    }
                                    ?>
                                </p>
                            </span>
                            <i class='bx bx-arrow-back bx-rotate-180 arrow-icon position-absolute m-3'></i>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row my-5">
                        <div class="p-4 border    rounded-3 shadow-sm d-flex position-relative trigger view" data-popup="popup5">
                            <i class='bx bxs-user pop-icon p-2'></i>
                            <span class="d-inline mx-3">
                                <p class="fs-5 mb-2">ACCOUNTS</p>
                                <p class="fs-2 m-0 p-0" style="color: #346473;">
                                    <?php
                                    // SQL query to count rows
                                    $sql = "SELECT COUNT(*) as count FROM tbl_student_acc";
                                    $result = $conn->query($sql);

                                    // Fetch the result
                                    $row_count = 0;
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $row_count = $row['count'];
                                        echo $row_count;
                                    } else {
                                        echo "0";
                                    }
                                    ?>
                                </p>
                            </span>
                            <i class='bx bx-arrow-back bx-rotate-180 arrow-icon position-absolute m-3'></i>
                        </div>
                    </div>
                    <!--Chart-->
                    <div class="row my-5">
                        <div class="border rounded-3 shadow-sm chart-container" style="height: 30rem;">
                            <div id="donutchart"></div>
                        </div>
                    </div>
                </div>
                <!--Calendar-->
                <div class="col">
                    <div class="row my-5">
                        <div class="calendar">
                            <div class="header">
                                <div class="month"></div>
                                <div class="btns">
                                    <div class="btn today-btn">
                                        <i class="fas fa-calendar-day"></i>
                                    </div>
                                    <div class="btn prev-btn">
                                        <i class="fas fa-chevron-left"></i>
                                    </div>
                                    <div class="btn next-btn">
                                        <i class="fas fa-chevron-right"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="weekdays">
                                <div class="day">Sun</div>
                                <div class="day">Mon</div>
                                <div class="day">Tue</div>
                                <div class="day">Wed</div>
                                <div class="day">Thu</div>
                                <div class="day">Fri</div>
                                <div class="day">Sat</div>
                            </div>
                            <div class="days">
                                <!-- lets add days using js -->
                            </div>
                        </div>

                        <!-- SCRIPT -->
                        <script src="script.js"></script>
                    </div>
                    <div class="row my-5">
                        <div class="p-4 border rounded-3 shadow-sm d-flex position-relative announcement" onclick="replaceDiv()">
                            <i class='bx bx-comment-add pop-icon m-2' style="color: white;"></i>
                            <span class="d-inline mt-3 ms-3">
                                <p class="fs-3">Create Announcement</p>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!--popups-->
            <div id="popup1" class="popup">
                <div class="popup-content2">
                    <div class="border border-1 p-2 mx-auto rounded-3 d-flex align-items-center shadow-sm bg-light mb-5" style="min-width: 200px; max-width: 300px; ">
                        <i class='bx bxs-graduation pop-icon border border-1 shadow-sm rounded-3 p-1' style="background-color: white;"></i>
                        <span class="fs-3 fw-bold mx-auto">APPLIED</span>
                    </div>
                    <div>
                        <?php
                        $sql = "SELECT DISTINCT 
                            s.Student_No, 
                            CONCAT(s.First_Name, ' ', s.Last_Name) AS Name, 
                            s.Email_Address, 
                            sch.Scholarship_No, 
                            sch.Scholarship_Name, 
                            app.C_status
                        FROM 
                            tbl_application_scholarship AS app
                        JOIN 
                            tbl_student_acc AS s ON app.Student_No = s.Student_No
                        JOIN 
                            tbl_scholarship AS sch ON app.Scholarship_No = sch.Scholarship_No
                        WHERE 
                            app.C_status = 'approved' OR app.C_status = 'pending' OR app.C_status = 'rejected'";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo "<table>
                            <tr>
                                <th>Student No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Scholarship No</th>
                                <th>Scholarship Name</th>
                                <th>Status</th>
                            </tr>";
                            $row_count = 0; // Counter for row colors

                            while ($row = $result->fetch_assoc()) {

                                 // Alternate row color
                                $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
                                $row_count++;
                                echo "<tr class='$row_class'>
                                <td>" . $row['Student_No'] . "</td>
                                <td>" . $row['Name'] . "</td>
                                <td>" . $row['Email_Address'] . "</td>
                                <td>" . $row['Scholarship_No'] . "</td>
                                <td>" . $row['Scholarship_Name'] . "</td>
                                <td>" . $row['C_status'] . "</td>
                            </tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "<table>
                            <tr>
                                <th>Student No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Scholarship No</th>
                                <th>Scholarship Name</th>
                                <th>Status</th>
                            </tr>
                            <tr>
                                <td colspan='3' style='color: #346473'>No Applied Students</td>
                            </tr>
                            </table>";
                        }
                        ?>

                    </div>
                    <div class="d-flex justify-content-center my-3">
                        <button class="close-button back-btn btn shadow-sm px-4 py-0">Back</button>
                    </div>
                </div>
            </div>

            <div id="popup2" class="popup">
                <div class="popup-content2">
                    <div class="border border-1 p-2 mx-auto rounded-3 d-flex align-items-center shadow-sm bg-light mb-5" style="min-width: 200px; max-width: 300px; ">
                        <i class='bx bxs-user-check pop-icon border border-1 shadow-sm rounded-3 p-1' style="background-color: white;"></i>
                        <span class="fs-3 fw-bold mx-auto">APPROVED</span>
                    </div>
                    <div>
                        <?php
                        $sql = "SELECT DISTINCT 
                            s.Student_No, 
                            CONCAT(s.First_Name, ' ', s.Last_Name) AS Name, 
                            s.Email_Address, 
                            sch.Scholarship_No, 
                            sch.Scholarship_Name, 
                            app.C_status
                        FROM 
                            tbl_application_scholarship AS app
                        JOIN 
                            tbl_student_acc AS s ON app.Student_No = s.Student_No
                        JOIN 
                            tbl_scholarship AS sch ON app.Scholarship_No = sch.Scholarship_No
                        WHERE 
                            app.C_status = 'approved'";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo "<table>
                            <tr>
                                <th>Student No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Scholarship No</th>
                                <th>Scholarship Name</th>
                                <th>Status</th>
                            </tr>";
                            $row_count = 0; // Counter for row colors

                            while ($row = $result->fetch_assoc()) {

                                 // Alternate row color
                                $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
                                $row_count++;
                                echo "<tr class='$row_class'>
                                <td>" . $row['Student_No'] . "</td>
                                <td>" . $row['Name'] . "</td>
                                <td>" . $row['Email_Address'] . "</td>
                                <td>" . $row['Scholarship_No'] . "</td>
                                <td>" . $row['Scholarship_Name'] . "</td>
                                <td>" . $row['C_status'] . "</td>
                            </tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "<table>
                            <tr>
                                <th>Student No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Scholarship No</th>
                                <th>Scholarship Name</th>
                                <th>Status</th>
                            </tr>
                            <tr>
                                <td colspan='3' style='color: #346473'>No Approved Applicantion</td>
                            </tr>
                            </table>";
                        }
                        ?>
                    </div>
                    <div class="d-flex justify-content-center my-3">
                        <button class="close-button back-btn btn shadow-sm px-4 py-0">Back</button>
                    </div>
                </div>
            </div>
            <div id="popup3" class="popup">
                <div class="popup-content2">
                    <div class="border border-1 p-2 mx-auto rounded-3 d-flex align-items-center shadow-sm bg-light mb-5" style="min-width: 200px; max-width: 300px; ">
                        <i class='bx bxs-x-circle pop-icon border border-1 shadow-sm rounded-3 p-1' style="background-color: white;"></i>
                        <span class="fs-3 fw-bold mx-auto">REJECTED</span>
                    </div>
                    <div>
                        <?php
                        $sql = "SELECT DISTINCT 
                            s.Student_No, 
                            CONCAT(s.First_Name, ' ', s.Last_Name) AS Name, 
                            s.Email_Address, 
                            sch.Scholarship_No, 
                            sch.Scholarship_Name, 
                            app.C_status
                        FROM 
                            tbl_application_scholarship AS app
                        JOIN 
                            tbl_student_acc AS s ON app.Student_No = s.Student_No
                        JOIN 
                            tbl_scholarship AS sch ON app.Scholarship_No = sch.Scholarship_No
                        WHERE 
                            app.C_status = 'rejected'";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo "<table>
                            <tr>
                                <th>Student No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Scholarship No</th>
                                <th>Scholarship Name</th>
                                <th>Status</th>
                            </tr>";
                            $row_count = 0; // Counter for row colors

                            while ($row = $result->fetch_assoc()) {

                                 // Alternate row color
                                $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
                                $row_count++;
                                echo "<tr class='$row_class'>
                                <td>" . $row['Student_No'] . "</td>
                                <td>" . $row['Name'] . "</td>
                                <td>" . $row['Email_Address'] . "</td>
                                <td>" . $row['Scholarship_No'] . "</td>
                                <td>" . $row['Scholarship_Name'] . "</td>
                                <td>" . $row['C_status'] . "</td>
                            </tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "<table>
                            <tr>
                                <th>Student No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Scholarship No</th>
                                <th>Scholarship Name</th>
                                <th>Status</th>
                            </tr>
                            <tr>
                                <td colspan='3' style='color: #346473'>No Rejected Applicantion</td>
                            </tr>
                            </table>";
                        }
                        ?>
                    </div>
                    <div class="d-flex justify-content-center my-3">
                        <button class="close-button back-btn btn shadow-sm px-4 py-0">Back</button>
                    </div>
                </div>
            </div>

            <div id="popup4" class="popup">
                <div class="popup-content2">
                    <div class="border border-1 p-2 mx-auto rounded-3 d-flex align-items-center shadow-sm bg-light mb-5" style="min-width: 200px; max-width: 300px; ">
                        <i class='bx bxs-stopwatch pop-icon border border-1 shadow-sm rounded-3 p-1' style="background-color: white;"></i>
                        <span class="fs-3 fw-bold mx-auto">PENDING</span>
                    </div>
                    <div>
                        <?php
                        $sql = "SELECT DISTINCT 
                            s.Student_No, 
                            CONCAT(s.First_Name, ' ', s.Last_Name) AS Name, 
                            s.Email_Address, 
                            sch.Scholarship_No, 
                            sch.Scholarship_Name, 
                            app.C_status
                        FROM 
                            tbl_application_scholarship AS app
                        JOIN 
                            tbl_student_acc AS s ON app.Student_No = s.Student_No
                        JOIN 
                            tbl_scholarship AS sch ON app.Scholarship_No = sch.Scholarship_No
                        WHERE 
                            app.C_status = 'pending'";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo "<table>
                            <tr>
                                <th>Student No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Scholarship No</th>
                                <th>Scholarship Name</th>
                                <th>Status</th>
                            </tr>";
                            $row_count = 0; // Counter for row colors

                            while ($row = $result->fetch_assoc()) {

                                 // Alternate row color
                                $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
                                $row_count++;
                                echo "<tr class='$row_class'>
                                <td>" . $row['Student_No'] . "</td>
                                <td>" . $row['Name'] . "</td>
                                <td>" . $row['Email_Address'] . "</td>
                                <td>" . $row['Scholarship_No'] . "</td>
                                <td>" . $row['Scholarship_Name'] . "</td>
                                <td>" . $row['C_status'] . "</td>
                            </tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "<table>
                            <tr>
                                <th>Student No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Scholarship No</th>
                                <th>Scholarship Name</th>
                                <th>Status</th>
                            </tr>
                            <tr>
                                <td colspan='3' style='color: #346473'>No Pending Applicantion</td>
                            </tr>
                            </table>";
                        }
                        ?>
                    </div>
                    <div class="d-flex justify-content-center my-3">
                        <button class="close-button back-btn btn shadow-sm px-4 py-0">Back</button>
                    </div>
                </div>
            </div>

            <div id="popup5" class="popup">
                <div class="popup-content2">
                    <div class="border border-1 p-2 mx-auto rounded-3 d-flex align-items-center shadow-sm bg-light mb-5" style="min-width: 200px; max-width: 300px; ">
                        <i class='bx bxs-user pop-icon border border-1 shadow-sm rounded-3 p-1' style="background-color: white;"></i>
                        <span class="fs-3 fw-bold mx-auto">ACCOUNTS</span>
                    </div>
                    <div>
                        <?php
                        $sql = "SELECT DISTINCT 
                         Student_No, 
                         CONCAT(First_Name, ' ', Last_Name) AS Name, 
                         Email_Address
                     FROM 
                         tbl_student_acc";
                        $result = $conn->query($sql);


                        if ($result->num_rows > 0) {
                            echo "<table >
                             <tr>
                                <th>Student No</th>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>";
                            $row_count = 0; // Counter for row colors

                            while ($row = $result->fetch_assoc()) {

                                 // Alternate row color
                                $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
                                $row_count++;
                                echo "<tr class='$row_class'>
                                <td>" . $row['Student_No'] . "</td>
                                <td>" . $row['Name'] . "</td>
                                <td>" . $row['Email_Address'] . "</td>
                            </tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "<table>
                            <tr>
                                <th>Student No</th>
                                <th>Name</th>
                                <th>Email</th>
                
                            </tr>
                            <tr>
                                <td colspan='3' style='color: #346473'>No Available Accounts</td>
                            </tr>
                            </table>";
                        }
                        ?>
                    </div>
                    <div class="d-flex justify-content-center my-3">
                        <button class="close-button back-btn btn shadow-sm px-4 py-0">Back</button>
                    </div>
                </div>
            </div>
        </div>



        <!--create announcement-->
        <div class="container-fluid mt-3 px-5" style="display: flex; flex-direction: column; height: 95vh; display: none;" id="div2">
            <div class="m-3 ms-0" onclick="replaceDiv()">
                <i style="font-size: 26px;; border: #e0e0e0 solid 1px; background-color: #fff; border-radius: 5px; padding: 0px 5px 0px 5px;" class='bx bx-arrow-back'></i>
            </div>
            <div class="row gx-5">
                <div class="col-7">
                    <form id="announcementForm">
                        <div class="border rounded-3 bg-light shadow-sm p-3" style="height: 110vh;">
                            <label for="title" class="form-label fs-5" style="margin-top:1%;">
                                <h5><b> Create Announcement </h5></b>
                            </label>
                            <hR>


                            <div class="d-flex flex-column" style="margin-top: 3%; margin-bottom: 2%;">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="flex-grow-1">
                                        <label for="title" class="form-label fs-5">Title</label>

                                        <select class="form-select" id="posted_to" name="posted_to" required style="width: auto; max-width: 200px; float:right;margin-bottom:2%;">
                                            <option value="all">All Students</option>
                                            <option value="pending">Pending</option>
                                            <option value="approved">Approved</option>
                                            <option value="rejected">Rejected</option>
                                        </select>
                                        <label for="post_to" class="form-label fs-6" style="float:right; margin-right :1%;margin-top:0.5%;">Post to : </label>
                                        <textarea class="form-control" id="title" name="title" rows="3" maxlength="80" oninput="updateCharCount()" placeholder="Announcement Title" style="margin-top: 1%;" required></textarea>
                                        <div id="charCount" class="mt-2">0 / 80 characters</div>
                                    </div>

                                </div>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-md-6">
                                    <label for="when" class="form-label fs-7">When</label>
                                    <textarea class="form-control" id="zwhen" name="zwhen" rows="1" style="max-height: 20vh;" required></textarea>
                                </div>

                                <div class="col-md-6">
                                    <label for="where" class="form-label fs-7">Where</label>
                                    <textarea class="form-control" id="zwhere" name="zwhere" rows="1" style="max-height: 20vh;" required></textarea>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="body" class="form-label fs-5">Body</label>
                                <textarea class="form-control" id="body" name="body" rows="100" style="overflow-y: scroll; max-height: 50vh;" placeholder="Announcement Body" required></textarea>
                            </div>

                            <div class="position-relative d-flex">
                                <div class="file-input-wrapper" >
                                    <button type="button" class="file-input-button" id="file-button">Upload &nbsp;<img src="upimg.png" style="height:20px;width:25px;"></button>
                                    <input type="file" id="pic_ann" name="pic_ann" accept="image/*" class="file-input">
                                </div>
                                <button type="submit" class="btn btn-lg post-btn position-absolute shadow" style="right: 5px;">Post</button>
                            </div>
                        </div>
                    </form>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script src="announcement.js"></script>
                </div>
                <div class="col-5" style="max-height:85vh;">
                    <p class="fs-3">Previous Announcements</p>
                    <div id="data-wrapper"></div>
                </div>
            </div>
        </div>


        <!--Post popup-->

        </div>
        <script src="div-toggle.js"></script>
        </div>
    </section>
    <script>
        const fileInput = document.getElementById('pic_ann');
        const fileButton = document.getElementById('file-button');

        fileButton.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', () => {
            const fileName = fileInput.files.length > 0 ? fileInput.files[0].name : 'Choose File';
            fileButton.textContent = fileName;
        });
    </script>



</body>
<script>
    /// log out button
    document.getElementById('logout-link').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default link click behavior
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out.",
            icon: 'warning',
            iconColor: '#346473',
            showCancelButton: true,
            confirmButtonColor: '#346473',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                    fetch('../homepage/logout.php', {
                    method: 'GET', 
                    credentials: 'same-origin' 
                })
                .then(response => {
                    if (response.ok) {
                       
                        window.location.href = "../homepage/login_page.php";
                    } else {
                       
                        Swal.fire('Error', 'There was a problem logging out.', 'error');
                    }
                })
                .catch(error => {
                    
                    Swal.fire('Error', 'There was a problem with the network.', 'error');
                });
            }
        });
    });
</script>

</html>