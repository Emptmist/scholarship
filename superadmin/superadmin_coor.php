<?php 
        session_start();

        ob_start();

        $conn = new mysqli('localhost','root','','db_scholarship_system');

        // Fetch scholarships for filter
        $optionsscholarships ='';
        $scholarships = $conn->query("SELECT scholarship_no, scholarship_name FROM tbl_scholarship");
        while ($row = $scholarships->fetch_assoc()) {
            $optionsscholarships .= '<option value="'.$row['scholarship_no'].'">'.$row['scholarship_name'].'</option>';
        }


        // Fetch announcements for filter
        $optionsannouncements ='';
        $announcements = $conn->query("SELECT no_announcement, title FROM tbl_announcement");
        while ($row = $announcements->fetch_assoc()) {
            $optionsannouncements .= '<option value="'.$row['no_announcement'].'">'.$row['title'].'</option>';
        }

        

        $sql = "SELECT  tbl_admin_account.Admin_id,
                                        tbl_admin_account.Email,
                                        tbl_admin_personal_info.Last_Name ,
                                        tbl_admin_personal_info.First_Name ,
                                        tbl_admin_personal_info.Middle_Name ,
                                        tbl_admin_personal_info.address ,
                                        tbl_admin_personal_info.birth_date ,
                                        tbl_admin_personal_info.age ,
                                        tbl_admin_personal_info.phone
                                FROM tbl_admin_account
                                LEFT JOIN tbl_admin_personal_info
                                ON tbl_admin_account.Admin_id = tbl_admin_personal_info.Admin_id";
                        $result = $conn->query($sql);

        $options = ""; // Initialize options string
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $Admin_id = $row['Admin_id'];
                $lname = $row['Last_Name'];
                $fname = $row['First_Name'];
                $options .= "<option value='$Admin_id'>$lname $fname</option>"; // Set value to no_req
            }
        }

        $sql = "SELECT * FROM tbl_scholarship";
$result = $conn->query($sql);

$options = ""; // Initialize options string
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $scholarship_no = $row['scholarship_no'];
        $scholarship_name = $row['scholarship_name'];
        $options .= "<option value='$scholarship_no'>$scholarship_name</option>"; // Set value to no_req
    }
}
?> 
<!-- php for bar graph -->
<?php

    $sql = "SELECT 
                Admin_id,
                COUNT(*) AS applicant_count
            FROM 
                tbl_application_scholarship
            GROUP BY 
                Admin_id
            ORDER BY 
                Admin_id;";

    $result = $conn->query($sql);

    $chartData = [];
    foreach ($result as $row) {
        $chartData[] = "['Coordinator " . $row['Admin_id'] . "', " . $row['applicant_count'] . "]";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin</title>

    <!--bootstrap-->
    <link href="bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap.bundle.min.js"></script>
    <script src="bootstrap.min.js"></script>

    <!--icons-->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!--icon website-->
    <link rel="icon" type="image/x-icon" href="../homepage/logo.png">

    <!--css-->
    <link rel="stylesheet" href="superadmin.css">

    <!--sweetalert2-->
    <script src="sweetalert2.all.min.js"></script>
    <link href="sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<!-- bar chart -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ["Admin ID", "Applicants"],
            <?php echo implode(", ", $chartData); ?>
        ]);

        var options = {
            title: "Number of Applications Processed by Coordinator",
            width: 450,
            height: 300,
            bars: 'vertical', 
            legend: { position: "none" },
            colors: ['#83C78E'], // Set the color for all bars
            vAxis: {
                viewWindow: {
                    min: 0,
                    max: 300
                },
                ticks: [0, 50, 100, 150, 200, 250, 300]  // Optional: Specify custom tick values
            }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById("barchart_values"));
        chart.draw(data, options);
    }

    // Example of a resizeChart function (make sure it’s defined if used)
    function resizeChart() {
        if (typeof chart !== 'undefined') {
            chart.draw(data, options); // Ensure 'data' and 'options' are defined globally or passed as parameters
        }
    }

    // Call resizeChart if needed
    // resizeChart(); // Uncomment if you have a reason to resize the chart


    
</script>


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
                <a href="superadmin_dashboard.php">
                    <i class='bx bxs-home'></i>
                    <span class="link_name">DASHBOARD</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">DASHBOARD</a></li>
                </ul>
            </li>
            <li>
                <a href="superadmin_Student.php">
                    <i class='bx bxs-user' ></i>
                    <span class="link_name">STUDENT</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">STUDENT</a></li>
                </ul>
            </li>
            <li style="border-radius: 5px;
background: rgba(244, 244, 244, 0.20);
box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.25);">
                <a href="superadmin_coor.php">
                    <i class='bx bxs-user-detail' ></i>
                    <span class="link_name">COORDINATOR</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">COORDINATOR</a></li>
                </ul>
            </li>
            <li>
                <a href="superadmin_history.php">
                <i class='bx bx-history' ></i>
                    <span class="link_name">LOGIN HISTORY</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">LOGIN HISTORY</a></li>
                </ul>
            </li>
            <li>
                <a href="superadmin_setting.php">
                    <i class='bx bxs-cog' ></i>
                    <span class="link_name">SETTING</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">SETTING</a></li>
                </ul>
            </li>
            <li>
                <a href="superadmin_announcement.php">
                    <i class='bx bxs-megaphone'></i>
                    <span class="link_name">ANNOUNCEMENT</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">ANNOUNCEMENT</a></li>
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
                <span class=" ms-4 fw-bold">COORDINATOR</span>
                <div class="d-flex ms-auto">
                    <a href="#" class="nav-link d-flex align-items-center">
                        <span class="me-2 fw-normal">SUPER ADMIN</span>
                        <i class='bx bxs-user-circle custom-icon'></i>
                    </a>
                </div>
            </div>
        </nav> 
        

        <hr>
       
        <div class="main-container" id="div1">
            <div class="row">
                <div class="col-sm-12">
                    <button class="application-btn trigger view form-btn" style="float: left; margin-right:10px;"  type="button" data-popup="popup1"><i class='bx bxs-user-plus'></i>Add Coordinator</button>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-8 content-student" >
                <?php 
                    $sql = "SELECT  tbl_admin_account.Admin_id,
                                    tbl_admin_account.Email,
                                    tbl_admin_personal_info.Last_Name,
                                    tbl_admin_personal_info.First_Name,
                                    tbl_admin_personal_info.Middle_Name,
                                    tbl_admin_personal_info.address,
                                    tbl_admin_personal_info.birth_date,
                                    tbl_admin_personal_info.age,
                                    tbl_admin_personal_info.phone
                            FROM tbl_admin_account
                            LEFT JOIN tbl_admin_personal_info
                            ON tbl_admin_account.Admin_id = tbl_admin_personal_info.Admin_id";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        echo "<table>
                                <tr>
                                    <th>ID</th>
                                    <th>NAME</th>
                                    <th>EMAIL</th>
                                    <th>ADDRESS</th>
                                    <th>BIRTHDAY</th>
                                    <th>AGE</th>
                                    <th>PHONE NO</th>
                                    <th style='text-align: center;'>ACTION</th>                              
                                </tr>";
                        $row_count = 0; // Counter for row colors

                        while ($row = $result->fetch_assoc()) {
                            // Alternate row color
                            $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
                            $row_count++;

                            // Check if values are null or empty and provide substitutes
                            $admin_id = !empty($row["Admin_id"]) ? htmlspecialchars($row["Admin_id"]) : 'N/A';
                            $email = !empty($row["Email"]) ? htmlspecialchars($row["Email"]) : 'N/A';
                            $last_name = !empty($row["Last_Name"]) ? htmlspecialchars($row["Last_Name"]) : 'N/A';
                            $first_name = !empty($row["First_Name"]) ? htmlspecialchars($row["First_Name"]) : 'N/A';
                            $middle_name = !empty($row["Middle_Name"]) ? htmlspecialchars($row["Middle_Name"]) : '';
                            $address = !empty($row["address"]) ? htmlspecialchars($row["address"]) : 'No Address Provided';
                            $birth_date = !empty($row["birth_date"]) ? htmlspecialchars($row["birth_date"]) : 'Not Available';
                            $age = !empty($row["age"]) ? htmlspecialchars($row["age"]) : 'Unknown';
                            $phone = !empty($row["phone"]) ? htmlspecialchars($row["phone"]) : 'No Phone Number';

                            echo "<tr class='$row_class'>
        <td>$admin_id</td>
        <td>$last_name $first_name $middle_name</td>
        <td>$email</td>
        <td>$address</td>
        <td>$birth_date</td>
        <td>$age</td>
        <td>$phone</td>
        <td style='text-align: center;'>
            <button type='button' class='delete-btn' data-admin-id='$admin_id'>
                <i class='bx bxs-trash' style='color: red;'></i>
            </button>
        </td>
    </tr>";


                        }
                        echo "</table><br><br>";
                    }

                        else {
                            echo "<table>
                                   <table>
                                    <tr>
                                        <th>ID</th>
                                        <th>NAME</th>
                                        <th>EMAIL</th>
                                        th>ADDRESS</th>
                                        <th>BIRTHDAY</th>
                                        <th>AGE</th>
                                        <th>PHONE NO</th>
                                        <th style='text-align: center;'>ACTION</th>                              
                                    </tr>
                                    <tr>
                                        <td colspan = '8' style='text-align: center;'> NO COORDINATOR!</td>
                                    </tr>
                                </table>";
                        }      

                    ob_end_flush();
                    
                    ?>
                </div>
                <div class="col-sm-4 content-student">
                    <div class="border rounded-3 shadow-sm chart-container" style="height: 20rem; Background-color: white;">
                        <div id="barchart_values" style="width: 80%; height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div id="popup1" class="popup">
            <div class="popup-content2">
                <span class="close-button"></span>
                <br>
                <div class="row">
                    <div class="col-md-6 content3">
                        <div class="text-Popup">Add New Coordinator</div>
                        <br><br>
                        <form style="padding-left: 0px;" method="POST">
                            <label class="form-lbl" style="color: #346473;">Email Address:</label><br>
                            <input class="lblpoptitle" type="email" id="admin_email" placeholder="Enter Email" required>
                            <div id="password-feedback" style="color: red; font-size: 12px; padding: 0; margin: 0;"></div>
                            <label class="form-lbl" style="color: #346473;">Password:</label><br>
                            <input class="lblpoptitle" type="password" id="admin_password" placeholder="Enter Password:" required><br><br>
                            <br>
                            <div style="display: flex; justify-content: center;">
                                <button type="submit" class="btn btn-lg shadow post-btn px-5" id="add-acc">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- <div class="main-container">
            <div class="row">
                <div class="col-sm-12">
                    <span style="font-size: 22px; color:#346473;"><b>ACTIVITY LOG</b></span>
                </div><br><br>
                <div class="col-sm-12">
                    <div class="activity-log">
                        <div class="filter-container"> -->
                            <!-- Filter Dropdowns -->
                            <!-- <select style="border: none; text-align:center;" class="application-btn" id="filter-scholarship" class="filter-dropdown">
                                <option value="">All Scholarships</option>
                                <?php echo $optionsscholarships; ?>
                            </select> -->

                            <!-- <select style="border: none; text-align:center;" class="application-btn" id="filter-status" class="filter-dropdown">
                                <option value="">All Statuses</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                                <option value="pending">Pending</option>
                            </select> -->

                            <!-- <select style="border: none; text-align:center;" class="application-btn" id="filter-announcement" class="filter-dropdown">
                                <option value="">All Announcements</option>
                                <?php echo $optionsannouncements; ?>
                            </select> -->

                            <!-- Date Input Filter -->
                            <!-- <input type="date" id="filter-date" class="filter-input input-fieldss" style="width: 350px;"> -->

                            <!-- Live Search Input -->
                            <!-- <input type="text" id="search-input" class="filter-input input-fieldss search-input" placeholder="Search...">
                            <button name="submit" value="submit-search"><div class='bx bx-search'></div></button>
                        </div>

                        <div id="activity-log-container">
                            <?php include('superadmin_activitylog.php'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="main-container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- <span style="font-size: 22px; color:#346473;"><b>ACTIVITY LOG</b></span> -->
                </div><br>
                <div class="col-sm-12">
                    <div class="activity-log">
                        
                        <!-- Scholarship Activity Log Filters -->
                        <div class="filter-container">
                            <h3>Scholarship Activity Log</h3>
                            <select id="filter-scholarship" style="border: none; text-align:center; display: none;" class="application-btn">
                                <option value="">All Scholarships</option>
                                <?php echo $options; ?>
                            </select>
                        </div>

                        <div id="scholarship-log-container">
                            <?php include('scholarship_log.php'); ?>
                        </div>

                        <!-- Application Status Activity Log Filters -->
                        <div class="filter-container">
                            <h3>Application Status Modification Log</h3>
                            <select id="filter-app-scholarship" style="border: none; text-align:center;" class="application-btn">
                                <option value="">All Scholarships</option>
                                <?php echo $options; ?>
                            </select>
                            <select id="filter-status" style="border: none; text-align:center;" class="application-btn">
                                <option value="">All Statuses</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>

                        <div id="application-log-container">
                            <?php include('application_log.php'); ?>
                        </div>

                        <!-- Announcement Creation Log Filters -->
                        <div class="filter-container">
                            <h3>Announcement Creation Log</h3>
                            <select id="filter-announcement" style="border: none; text-align:center;" class="application-btn">
                                <option value="">All Announcements</option>
                                <option value="approved">Approved</option>
                                <option value="pending">Pending</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>

                        <div id="announcement-log-container">
                            <?php include('announcement_log.php'); ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
            
    </section>

    <div class="one"></div>    
    <!-- Include SweetAlert2 and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        // Handle delete button clicks
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const adminId = this.getAttribute('data-admin-id');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You will not be able to recover this coordinator!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request to delete the admin
                        $.ajax({
                            url: 'delete-admin.php',
                            type: 'POST',
                            data: { admin_id: adminId },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    'The coordinator has been deleted.',
                                    'success'
                                ).then(() => {
                                    location.reload(); // Reload the page to reflect changes
                                });
                            },
                            error: function() {
                                Swal.fire(
                                    'Error!',
                                    'There was an issue deleting the coordinator.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    });
</script>

    <script>
        //popups handler
        document.addEventListener("DOMContentLoaded", () => {
            const triggers = document.querySelectorAll(".trigger");
            const popups = document.querySelectorAll(".popup");
            const closeButtons = document.querySelectorAll(".close-button");

            triggers.forEach(trigger => {
                trigger.addEventListener("click", () => {
                    const popupId = trigger.getAttribute("data-popup");
                    const popup = document.getElementById(popupId);
                    popup.style.display = "block";
                });
            });

            closeButtons.forEach(button => {
                button.addEventListener("click", () => {
                    popups.forEach(popup => {
                        popup.style.display = "none";
                    });
                });
            });

            window.addEventListener("click", (event) => {
                popups.forEach(popup => {
                    if (event.target === popup) {
                        popup.style.display = "none";
                    }
                });
            });
        })

        const sidebar = document.querySelector(".sidebar");
        const sidebarBtn = document.querySelector(".bx-menu");

        function toggleSidebar() {
            const viewportWidth = window.innerWidth;
            if (viewportWidth > 768) { // Only allow toggling if viewport is wider than 768px
                sidebar.classList.toggle("close");
            }
        }

        function handleResize() {
            const viewportWidth = window.innerWidth;
            if (viewportWidth <= 768) { // Close sidebar and disable toggle for small screens
                sidebar.classList.add("close");
                sidebarBtn.removeEventListener("click", toggleSidebar);
            } else {
                sidebarBtn.addEventListener("click", toggleSidebar);
            }
        }

        sidebarBtn.addEventListener("click", toggleSidebar);
        window.addEventListener("resize", handleResize);

        // Initial check
        handleResize();

        document.addEventListener('DOMContentLoaded', function() {
            function fetchActivityLog() {
                const scholarshipNo = document.getElementById('filter-scholarship').value;
                const status = document.getElementById('filter-status').value;
                const announcementNo = document.getElementById('filter-announcement').value;
                const activityDate = document.getElementById('filter-date').value;
                const search = document.getElementById('search-input').value;

                const xhr = new XMLHttpRequest();
                xhr.open('GET', `superadmin_activitylog.php?scholarship_no=${encodeURIComponent(scholarshipNo)}&status=${encodeURIComponent(status)}&announcement_no=${encodeURIComponent(announcementNo)}&activity_date=${encodeURIComponent(activityDate)}&search=${encodeURIComponent(search)}`, true);
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        document.getElementById('activity-log-container').innerHTML = xhr.responseText;
                    } else {
                        console.error('Error fetching data.');
                    }
                };
                xhr.send();
            }

            // Add event listeners for filters and search input
            document.getElementById('filter-scholarship').addEventListener('change', fetchActivityLog);
            document.getElementById('filter-status').addEventListener('change', fetchActivityLog);
            document.getElementById('filter-announcement').addEventListener('change', fetchActivityLog);
            document.getElementById('filter-date').addEventListener('change', fetchActivityLog);
            document.getElementById('search-input').addEventListener('input', fetchActivityLog);

            // Initial fetch
            fetchActivityLog();
        });



        //adding of admin
        $(document).ready(function() {
            $('#add-acc').click(function() {
                event.preventDefault();
                const adminEmail = $('#admin_email').val();
                const adminPassword = $('#admin_password').val();

                if (!adminEmail || !adminPassword) {
                    Swal.fire({
                        title: 'Please fill out all fields.',
                        confirmButtonColor: '#346473'
                    });
                    return;
                } else {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to add new admin ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, add it!',
                        cancelButtonText: 'Cancel',
                        confirmButtonColor: '#346473'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: 'add-admin.php',
                                type: 'POST',
                                data: { 
                                    admin_email: adminEmail,
                                    admin_password: adminPassword
                                },
                                success: function(response) {
                                    console.log("New admin account inserted successfully");
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Added!', 
                                        text: 'New admin account has been added.', 
                                        confirmButtonText: 'success',
                                        confirmButtonColor: '#346473'
                                    }).then(() => {
                                        location.reload();                                        
                                        $('#admin_email').val('');
                                        $('#admin_password').val('');
                                    });
                                },
                                error: function() {
                                    Swal.fire('Error!', 'There was a problem adding admin account.', 'error');
                                }
                            });
                        }
                    });
                }    
            })        
        });



       /// log out button
       document.getElementById('logout-link').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default link click behavior
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out.",
                icon: 'warning',
                iconColor:'#346473',
                showCancelButton: true,
                confirmButtonColor: '#346473',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the user clicks "Yes", navigate to the logout page
                    window.location.href = event.target.href="../homepage/login_page.php";
                }
            });
        });

        //filtering options
        document.addEventListener('DOMContentLoaded', function() {
    function updateLogs() {
        const filterScholarship = document.getElementById('filter-scholarship').value;
        const filterAppScholarship = document.getElementById('filter-app-scholarship').value;
        const filterStatus = document.getElementById('filter-status').value;
        const filterAnnouncement = document.getElementById('filter-announcement').value;

        // Update Scholarship Log
        fetch(`scholarship_log.php?filter-scholarship=${encodeURIComponent(filterScholarship)}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('scholarship-log-container').innerHTML = data;
            });

        // Update Application Status Log
        fetch(`application_log.php?filter-app-scholarship=${encodeURIComponent(filterAppScholarship)}&filter-status=${encodeURIComponent(filterStatus)}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('application-log-container').innerHTML = data;
            });

        // Update Announcement Log
        fetch(`announcement_log.php?filter-announcement=${encodeURIComponent(filterAnnouncement)}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('announcement-log-container').innerHTML = data;
            });
    }

    document.getElementById('filter-scholarship').addEventListener('change', updateLogs);
    document.getElementById('filter-app-scholarship').addEventListener('change', updateLogs);
    document.getElementById('filter-status').addEventListener('change', updateLogs);
    document.getElementById('filter-announcement').addEventListener('change', updateLogs);

    // Trigger updateLogs on page load to populate logs initially
    updateLogs();
});
    </script>
    
</body>

</html>
