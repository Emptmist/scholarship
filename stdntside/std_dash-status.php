<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

    // Check if the session variable is set
    if (isset($_SESSION['scholarship_no'])) {
        $scholarship_no = $_SESSION['scholarship_no'];

    } else {
    }
    // Check if the session variable is set
    if (!isset($_SESSION['Student_No'])) {
        // Redirect to the login page if the user is not logged in
        header("Location: ../homepage/login_page.php");
        exit();
    }else{
        $student_no = $_SESSION['Student_No'];
    }
    //PERSONAL INFO
    $sql_personal = "SELECT * FROM tbl_student_acc WHERE Student_No = $student_no";
    $result_per = $conn->query($sql_personal);
    if ($result_per->num_rows > 0) {
        while ($row = $result_per->fetch_assoc()) {
            $firstName = $row['First_name'];
        }
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard Status</title>

    <!--bootstrap-->
    <link href="bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap.bundle.min.js"></script>
    <script src="bootstrap.min.js"></script>

    <!--icons-->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!--icon website-->
    <link rel="icon" type="image/x-icon" href="logo.png">

    <!--css-->
    <link rel="stylesheet" href="std_dash-status.css">

    <!-- STYLESHEET -->
    <link rel="stylesheet" href="style.css">

    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!--sweetalert2-->
    <script src="sweetalert2.all.min.js"></script>
    <link href="sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <li style="border-radius: 5px;
background: rgba(244, 244, 244, 0.20);
box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.25);">
                <a href="std_dash-view.php">
                    <i class='bx bxs-home'></i>
                    <span class="link_name">DASHBOARD</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">DASHBOARD</a></li>
                </ul>
            </li>
            <li>
                <a href="std_info.php">
                    <i class='bx bxs-user'></i>
                    <span class="link_name">PERSONAL INFO</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">PERSONAL INFO</a></li>
                </ul>
            </li>
            <li>
                <a href="std_attach.php">
                    <i class='bx bxs-copy-alt'></i>
                    <span class="link_name">ATTACHMENT</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">ATTACHMENT</a></li>
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
                <span class=" ms-4 fw-bold">DASHBOARD</span>
                <div class="d-flex ms-auto">
                    <a href="#" class="nav-link d-flex align-items-center">
                        <span class="me-2 fw-normal">STUDENT</span>
                        <i class='bx bxs-user-circle custom-icon'></i>
                    </a>
                </div>
            </div>
        </nav>

        <hr>

        <!-- main content start here-->
        <div class="row">

            <div class="col-md-8">
                <div class="main-container">
                    <span class="main-style" style="color: white;">Hello, Student <b style="text-transform: uppercase; letter-spacing: 2px;"><?php echo $firstName; ?></b>!</span>
                    <p class="text3" style="color: white;">Application Status:</p>
                    <div class="save">
                        <a href="std_dash-view.php">
                            <button class="button1" style="padding: 0px 10px 0px 20px;">
                                View<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16" style="margin-left: 10px;">
                                    <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z" />
                                    <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z" />
                                </svg>
                            </button>
                        </a>
                    </div>
                </div>
                <div class="main-2nd-container">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php

                            // $sql = "SELECT scholarship_no, scholarship_name, C_status  FROM tbl_application_scholarship WHERE Student_No = $student_no";
                            $sql = "SELECT 
                                            tbl_application_scholarship.scholarship_no, 
                                            tbl_scholarship.scholarship_name, 
                                            tbl_application_scholarship.C_status,
                                            tbl_application_scholarship.rejection_reason 
                                        FROM 
                                            tbl_application_scholarship 
                                        INNER JOIN 
                                            tbl_scholarship 
                                        ON 
                                            tbl_application_scholarship.scholarship_no = tbl_scholarship.scholarship_no 
                                        WHERE 
                                            tbl_application_scholarship.Student_No = $student_no";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                echo "<table>
                                        <tr>
                                            <th colspan='3'> SCHOLARSHIP PROGRAM</th>
                                            <th style=' text-align: center;' colspan='2'> COMMENTS</th>
                                            <th style=' text-align: center;' colspan='3'> STATUS</th>
                                            </tr>";
                                while ($row = $result->fetch_assoc()) {
                                    $bgColor = '';
                                    if ($row["C_status"] == 'pending') {
                                        $bgColor = 'background-color: gray;';
                                    } elseif ($row["C_status"] == 'approved') {
                                        $bgColor = 'background-color: #0ddf53;';
                                    } elseif ($row["C_status"] == 'rejected') {
                                        $bgColor = 'background-color: red;';
                                        $color = 'FF0000';
                                    }
                                    echo "<tr style=' background-color: #fafafa'>
                                            <td colspan='3'>".$row["scholarship_name"]."</td>
                                            <td colspan='2' onclick=\"showComment('".$row["rejection_reason"]."')\" style='cursor: pointer; text-align: center; color: #00bbf0;'>".'view'."</td>  
                                            <td style=' text-align: center;' colspan='3'><button style='".$bgColor." width: 100px; color: white; border-radius: 10px; border: #c2c2c2 solid 1px; padding: 5px 10px 5px 10px; text-transform: uppercase;'>".$row["C_status"]."</button></td>  
                                        </tr>";
                                        
                                }
                                echo "</table><br><br>";
                                    
                            } else {
                                echo "<table>
                                                <tr>
                                                    <th colspan='2'> SCHOLARSHIP PROGRAM</th>
                                                    <th colspan='2'> STATUS</th>
                                                 </tr> 
                                                 <tr>
                                                    <td >NO APPLICATION SUBMITTED</td>
                                                </tr>
                                                 </table><br><br>";
                            }

                            ?>

                        </div>


                    </div>
                </div>
            </div>


            <div class="col-md-4"> <br>
                <div class="row" style="padding: 2px;">
                    <div class="col-md-1"><i class='bx bx-calendar' style="font-size: 40px; color: #346373;"></i></div>
                    <div class="col-md-5" style="padding: 10px;">
                        <span class="text3" id="currentDate" style="color: #346373;font-size: 20px;"></span>
                    </div>
                </div>
                <div class="sub-container">
                    <div class="container">
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
                    </div>
                    <!--notification REMINDER-->
                    <div class="notif">
                        <div class="row">
                            <div class="col-md-3">
                                <button class="btn btn-outline-primary w-100 filter-btn active" data-filter="today"><b>Today</b></button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-outline-primary w-100 filter-btn" data-filter="week"><b>Week</b></button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-outline-primary w-100 filter-btn" data-filter="month"><b>Month</b></button>
                            </div>
                        </div>
                        <br>
                        <div class="content1">
                            <div class="content-item today-content">
                                <div class="row">
                                    <div class="col-md-1 font-weight-bold" id="today-date"></div>
                                    &nbsp; &nbsp;
                                    <div class="col-md-1 font-weight-bold" id="today-day"></div>
                                    <div class="col-md-9" id="today-time"></div>
                                </div>
                                <div class="row" style="margin-top: 2%;">
                                    <div class="col-md-10" id="today-scholarships"></div>
                                </div>
                            </div>

                            <div class="content-item week-content d-none">
                                <div class="row">
                                    <div class="col-md-11" id="week-scholarships"></div>
                                </div>
                            </div>

                            <div class="content-item month-content d-none">

                                <div class="row">
                                    <div class="col-md-11" id="month-scholarships"></div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                    <!-- SCRIPT -->
                    <script src="script.js"></script>
                </div>

                <div>
                    <div class="sub-container"> <br>
                        <div class="trigger view" data-popup="popup1">
                            <button class="btn">
                                <span class="text-title"> ANNOUNCEMENT</span>
                                <p style="text-align: center;">View Details</p>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php

        // Fetch data announcement from database
        $sql = "SELECT * FROM tbl_announcement";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $title = $row['title'];
                $body = $row['body'];
            }
        }

        ?>

        <div id="popup1" class="popup">
            <div class="popup-content2">
                <span class="close-button"></span>
                <p class="fs-3">Announcements</p>
                <div id="data-wrapper"></div>
            </div>
        </div>

    </section>



    <div class="one"></div>

    <script>
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
        });

        //announcement
        document.addEventListener('DOMContentLoaded', () => {
            const dataWrapper = document.getElementById('data-wrapper');
            const data = <?php
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

                            $sql = "SELECT title, body, post_date, zwhere, zwhen, ann_pic
                                    FROM tbl_announcement
                                    WHERE posted_to = 'all'
                                    OR posted_to IN (
                                    SELECT c_status
                                    FROM tbl_application_scholarship
                                    WHERE student_no = '$student_no'
                                    )
                                    ORDER BY no_announcement DESC";
                            $result = $conn->query($sql);

                            $announcements = array();

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $announcements[] = $row;
                                }
                            }

                            echo json_encode($announcements);

                            $conn->close();
                            ?>;

            data.forEach(item => {
                const div = document.createElement('div');
                div.className = 'data-container';

                const title = document.createElement('div');
                title.className = 'data-title';
                title.textContent = item.title;

                const postDate = document.createElement('div');
                postDate.className = 'data-post-date';

                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                postDate.textContent = new Date(item.post_date).toLocaleDateString(undefined, options);
                const formattedPostDate = new Date(item.post_date).toLocaleDateString(undefined, options);

                if (item.ann_pic) {
                    const img = document.createElement('img');
                    img.src = '../adminside/admin-UPLOAD_FILEs/announcement_images/' + item.ann_pic;
                    img.alt = 'Announcement Image';
                } 
                const content = document.createElement('div');
                content.className = 'data-content';
                content.textContent = item.body;

                const seeMoreButton = document.createElement('button');
                seeMoreButton.className = 'see-more';
                seeMoreButton.textContent = 'See More';
                seeMoreButton.addEventListener('click', () => {
                    Swal.fire({
                        title: item.title,
                        html: `
                            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                                <p style="margin: 0 0 20px 0; display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; margin-top: 2%;">
                                    <span><strong>When:</strong> ${item.zwhen || 'N/A'}</span>
                                    <span><strong>Where:</strong> ${item.zwhere || 'N/A'}</span>
                                </p>
                                ${item.ann_pic ? '<img src="../adminside/admin-UPLOAD_FILEs/announcement_images/' + item.ann_pic + '" style="width: 700; height: 300px; object-fit: cover; position:relative; border-style: solid; border-radius:4px;">' : ''}
                                <p style="margin: 20px 0; max-width: 50%; word-wrap: break-word; margin-bottom: 2%;">
                                    ${item.body}
                                </p>
                                <p style="margin: 20px 0; max-width: 50%; word-wrap: break-word; margin-bottom: 2%;">
                                    <strong>Posted on:</strong> ${formattedPostDate}
                                </p>
                            </div>
                        `,
                        width: '80%',
                        padding: '3em',
                        background: '#fff',
                        confirmButtonText: 'Close'
                    });
                });

                div.appendChild(title);
                div.appendChild(postDate);
                div.appendChild(seeMoreButton);
                dataWrapper.appendChild(div);

                // Debugging statements
                console.log('Scroll Height:', content.scrollHeight);
                console.log('Client Height:', content.clientHeight);

                // Force button visibility for debugging
                seeMoreButton.style.display = 'inline-block';

                // Check if content exceeds the allowed height
                if (content.scrollHeight > content.clientHeight) {
                    seeMoreButton.style.display = 'inline-block';
                }
            });
        });

        ////comment
        function showComment(comment) {
            Swal.fire({
                title: 'COMMENT',
                text: comment,
                icon: 'info',
                confirmButtonText: 'OK',
                confirmButtonColor: '#346473'
            });
        }

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

</body>

</html>