<?php
include '../homepage/Time_Expiration.php';
session_start();

$conn = mysqli_connect("localhost", "root", "", "db_scholarship_system");
ob_start();
// Check if the session variable is set
// Check if the session variable is not set
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

scholarship_expiration($conn)

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard View</title>

    <!--bootstrap-->
    <link href="bootstrap.min.css" rel="stylesheet">
    <script defer src="bootstrap.bundle.min.js"></script>
    <script defer src="bootstrap.min.js"></script>

    <!--icons-->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!--icon website-->
    <link rel="icon" type="image/x-icon" href="logo.png">

    <!--css-->
    <link rel="stylesheet" href="std_dash-view.css">

    <!-- STYLESHEET -->
    <link rel="stylesheet" href="style.css">

    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!--sweetalert2-->
    <script defer src="sweetalert2.all.min.js"></script>
    <link href="sweetalert2.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                <a href="#">
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


        <div class="row">
            <div class="col-md-8">
                <div class="main-container">
                    <span class="main-style">Hello, Student <b style="text-transform: uppercase; letter-spacing: 2px;"><?php echo $firstName; ?></b>!</span>
                    <p class="text3">Application Status:</p>

                    <div class="save">
                        <a href="std_dash-status.php">
                            <button class="button1" style="padding: 0px 10px 0px 20px;">
                                View<i class="bi bi-eye-fill"></i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16" style="margin-left: 10px;">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                </svg>
                            </button>
                        </a>
                    </div>

                </div>

                <div class="main-2nd-container">
                    <span class="nd-main-style" style="font-weight: bold;">NOTICE</span>
                    <p class="text2">We want to inform you that our scholarship application system does not automatically evaluate and process submissions. Therefore, it's essential to ensure that your application is complete and submitted in advance. Please note that it will take 59 to 62 days to process your applications after the submission deadline. We appreciate your patience and understanding in this matter. For questions, inquiries, or bug reports on the portal, please feel free to reach out to us at <span style="font-weight: 450;">scholarshipsystem1@gmail.com</span>.
                    </p>
                </div>

                <div class="text">SCHOLARSHIP PROGRAM</div>


                <div class="row">
                    <?php
                    $conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {

                        if (isset($_POST['view_scholarship'])) {
                            $_SESSION['scholarship_no'] = $_POST['view_scholarship'];
                            header('Location: std_dash.php'); // Redirect to the target page
                            exit();
                        }
                    }

                    $sql = "SELECT * FROM tbl_scholarship";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="col-md-3 col-sm-6 style="width: 400px; height: 400px; margin-top: 10px;">
                                        <div class="attach" style="width: 100%; height: 100%; padding: 10px; > <br>
                                            <span class="text1">' . $row["scholarship_name"] . '</span> <br> <br>
                                            <div class="text-container" style="color: #346373; flex-grow: 1;">
                                                ' . $row["description"] . '
                                            </div>
                                            <br>
                                            <form action="" method="post">
                                                    <button class="button" type="submit" name="view_scholarship" id="view_scholarship" value="' . $row["scholarship_no"] . '">VIEW</button> <br> <br> <br>
                                            </form>
                                        </div>
                                    </div>';
                        }
                    }
                    ob_end_flush();
                    ?>
                </div>
                <br><br>
                <span style="font-size: 20px; padding-left:55px; color:#346373; font-family:Inter; font-weight:800;">FEEDBACK HISTORY</span>

                

                <?php
                    
                    $sql_fbhistory = "SELECT * FROM tbl_feedback WHERE Student_No = $student_no";
                    $result = $conn->query($sql_fbhistory);

                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $feedback_date = htmlspecialchars($row['feedback_date']);
                            $feedback_category = htmlspecialchars($row['feedback_category']);
                            $feedback_message = htmlspecialchars($row['feedback_message']);
                            $feedback_image = htmlspecialchars($row['feedback_image']);
                            $feedback_no = $row['feedback_no']; // Assuming there's a unique ID for each feedback

                            echo '<div class="feedback_container">
                                    <div class="row">
                                        <div class="col-sm-12" style="background-color: white; border-radius: 15px; padding: 20px;">
                                            <span class="nd-main-style" style="font-weight: bold;">Date: <span style="font-weight:300;">'.$feedback_date.'</span></span><br>
                                            <span class="nd-main-style" style="font-weight: bold;">Feedback Category: <span style="font-weight: 300;">'.$feedback_category.'</span></span><br>
                                            <span class="nd-main-style" style="font-weight: bold;">Message:<p class="text2">'.$feedback_message.'</p></span>';

                            if (!empty($feedback_image)) {
                                echo '<button class="form-btn" style="width: 120px; height: 40px;" onclick="toggleImage(' . $feedback_no . ')">Image</button>';
                                echo '<div id="imageContainer_' . $feedback_no . '" style="display:none; margin-top: 10px;">
                                        <img src="../adminside/admin-UPLOAD_FILEs/'.$feedback_image.'" alt="Feedback Image" style="max-width: 100%; max-height: 300px; border-radius: 10px;">
                                    </div>';
                            }

                            echo '      </div>
                                    </div>
                                </div>';
                        }

                    } else {
                        echo'<div style="text-align: center;">
                                <span style="font-size: 20px; color:#e3e3e3; font-family:Inter; font-weight:800;">No Feedback History</span>
                            </div>';
                    }



                ?>

<?php
                    if (isset($_POST['save-feedback'])) {
                        $feedback_category = $_POST['feeback-category'];
                        $feedback_message = $_POST['feedback-message'];
                        
                        if (isset($_FILES['upload-feedback']) && $_FILES['upload-feedback']['error'] === 0) {
                            // File upload is successful
                            $img_name = $_FILES['upload-feedback']['name'];
                            $img_size = $_FILES['upload-feedback']['size'];
                            $tmp_name = $_FILES['upload-feedback']['tmp_name'];
                    
                            if ($img_size > 525000) {
                                echo "<script>Swal.fire({
                                    icon: 'error',
                                    title: 'File too large!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });</script>";
                            } else {
                                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                                $img_ex_lc = strtolower($img_ex);
                    
                                $allowed_exs = array('jpg', 'jpeg', 'png');
                    
                                if (in_array($img_ex_lc, $allowed_exs)) {
                                    $new_img_name = uniqid("feedbackpic-", true) . '.' . $img_ex_lc;
                                    $img_upload_path = '../adminside/admin-UPLOAD_FILEs/' . $new_img_name;
                                    move_uploaded_file($tmp_name, $img_upload_path);
                                    echo '<script>
                                        Swal.fire({
                                        title: "SAVED",
                                        text: "Successfully uploaded!",
                                        icon: "success",
                                        confirmButtonColor: "#2e7d32"
                                            })
                                    </script>';
                    
                                    // INSERT INTO DATABASE
                                    $sql_feedback = "INSERT INTO tbl_feedback(feedback_date, feedback_category, feedback_message, feedback_image, Student_No)
                                                    VALUES(CURDATE(), '$feedback_category', '$feedback_message','$new_img_name', $student_no)";
                                    mysqli_query($conn, $sql_feedback);
                    
                                    echo "<script>Swal.fire({
                                        title: 'SAVED',
                                        text: 'Successfully uploaded!',
                                        icon: 'success',
                                        showConfirmButton: true,
                                        confirmButtonColor: '#2e7d32',
                                        timer: 1500
                                    });</script>";
                                } else {
                                    echo "<script>Swal.fire({
                                        icon: 'error',
                                        title: 'Invalid file type!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });</script>";
                                }
                            }
                        } else {
                            // No file uploaded, insert feedback without an image
                            $sql_feedback1 = "INSERT INTO tbl_feedback(feedback_date, feedback_category, feedback_message, feedback_image, Student_No)
                                              VALUES(CURDATE(), '$feedback_category', '$feedback_message', '', $student_no)";
                            $res = mysqli_query($conn, $sql_feedback1);
                            
                            if ($res) {
                                echo "<script>Swal.fire({
                                    title: 'SAVED',
                                    text: 'Successfully uploaded!',
                                    icon: 'success',
                                    showConfirmButton: true,
                                    confirmButtonColor: '#2e7d32'
                                    });</script>";
                            } else {
                                echo "<script>Swal.fire({
                                    icon: 'error',
                                    title: 'Error saving feedback!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });</script>";
                            }
                        }
                    }
                    
                    
                
                ?>

                    
                <div class="">
                    <div class="feedback_box main-3nd-container" onclick="toggleFeedbackForm()">
                        <span class="nd-main-style" style="font-weight: bold;">Give Feedback</span>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        <div id="feedback_form" class="feedback_form main-3nd-container" style="display: none;">
                            <span class="nd-main-style" style="font-weight: bold;">Feedback Category:</span><br>
                            <select style="border: none; margin-top:10px; padding-left:6px;" name="feeback-category" id="category" class="category-btn" placeholder="Category" onchange="handleStatusChange(this)" required>
                                <option value="" disabled selected>Select Category</option>
                                <option value="Bug Reports">Bug Reports</option>
                                <option value="Comments">Comments</option>
                                <option value="Suggestions">Suggestions</option>
                                <option value="Questions">Questions</option>
                            </select>
                            <br>
                            <span class="nd-main-style" style="font-weight: bold;">Message:</span><br>
                                <textarea class="form-control rounded-3" id="qual" name="feedback-message" rows="5" placeholder="Give as many details as possible..." required></textarea>
                                <label for="file-input" class="custom-file-label">Add Image</label>
                                <input type="file" id="file-input" class="custom-file-input"  name="upload-feedback"  accept="image/jpeg">
                                
                            <div class="row">
                                <div class="col" align="right" style="margin-top:10px;">
                                    <button class="form-btn" style="width: 100px;" name="save-feedback">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>


            <div class="col-md-4"><br>
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

        function toggleImage(feedbackId) {
            var imageContainer = document.getElementById('imageContainer_' + feedbackId);
            if (imageContainer.style.display === 'none') {
                imageContainer.style.display = 'block';
            } else {
                imageContainer.style.display = 'none';
            }
        }


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
                                 ${item.ann_pic ? '<img src="../adminside/admin-UPLOAD_FILEs/announcement_images/' + item.ann_pic + '" style="width: 700px; height: 300px; object-fit: cover; position:relative; border-style: solid; border-radius:4px;">' : ''}
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

        //For Feedback
        function toggleFeedbackForm() {
            var form = document.getElementById('feedback_form');
            if (form.style.display === 'none') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
        document.getElementById('file-input').addEventListener('change', function () {
            const fileName = this.files.length > 0 ? this.files[0].name : 'Choose File';
            document.querySelector('.custom-file-label').textContent = fileName;
        });


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