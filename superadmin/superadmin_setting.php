<?php
session_start();

ob_start();

$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');


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
                    <i class='bx bxs-user'></i>
                    <span class="link_name">STUDENT</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">STUDENT</a></li>
                </ul>
            </li>
            <li>
                <a href="superadmin_coor.php">
                    <i class='bx bxs-user-detail'></i>
                    <span class="link_name">COORDINATOR</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">COORDINATOR</a></li>
                </ul>
            </li>
            <li>
                <a href="superadmin_history.php">
                    <i class='bx bx-history'></i>
                    <span class="link_name">LOGIN HISTORY</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">LOGIN HISTORY</a></li>
                </ul>
            </li>
            <li style="border-radius: 5px;
background: rgba(244, 244, 244, 0.20);
box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.25);">
                <a href="#">
                    <i class='bx bxs-cog'></i>
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
                <span class=" ms-4 fw-bold">SETTING</span>
                <div class="d-flex ms-auto">
                    <a href="#" class="nav-link d-flex align-items-center">
                        <span class="me-2 fw-normal">SUPER ADMIN</span>
                        <i class='bx bxs-user-circle custom-icon'></i>
                    </a>
                </div>
            </div>
        </nav>


        <hr>


        <!--main content-->
        <form action="">
            <div class="row">
                <div class="col-lg-10">
                    <div id="faq" class="main-container" style="max-height: none;">
                        <p id="title-name costum-title"><B>FAQ</B></p>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <label class="form-lbl">QUESTION:</label><br>
                                <input class="form-ipt" id="question" placeholder="Type Questions" style="padding: 10px 100px 100px 10px;">
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <label class="form-lbl">ANSWER:</label><br>
                                <input class="form-ipt" id="answer" placeholder="Type Answers" style="padding: 10px 100px 100px 10px;">
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="save">
                                    <br>
                                    <button class="button" id="add-faq" style="padding: 7px 30px 7px 30px;">ADD FAQ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right-sidebar">
                    <div class="sidebar-buttons">
                        <div class="sidebar-button">
                            <a href="superadmin_account.php" style="text-decoration:none;"><h3>Your Account</h3>
                            <p>Details of your Account</p></a>
                        </div>
                        <div class="sidebar-button">
                            <a href="superadmin_setting.php" style="text-decoration:none;"><h3>FAQ</h3>
                            <p>Setting up FAQ</p></a>
                        </div>
                        <div class="sidebar-button">
                            <a href="superadmin_feedback.php" style="text-decoration:none;"><h3>Feedback</h3>
                            <p>View user’s feedback</p></a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <div class="one"></div>
    <!-- Include SweetAlert2 and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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


        //insertion of faq
        $(document).ready(function() {
            $('#add-faq').click(function() {
                event.preventDefault();
                const question = $('#question').val();
                const answer = $('#answer').val();

                if (!question || !answer) {
                    Swal.fire({
                        title: 'Please fill out both fields.',
                        confirmButtonColor: '#346473'
                    });
                    return;
                } else {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to add this FAQ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, add it!',
                        cancelButtonText: 'Cancel',
                        confirmButtonColor: '#346473'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: 'insert-faq.php',
                                type: 'POST',
                                data: { question: question, answer: answer },
                                success: function(response) {
                                    console.log("FAQ inserted successfully");
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Added!',
                                        text: 'Your FAQ has been added.', 
                                        confirmButtonText: 'success',
                                        confirmButtonColor: '#346473'
                                    }).then(() => {
                                        location.reload();
                                        // $('#question').val('');
                                        // $('#answer').val('');
                                    });
                                },
                                error: function() {
                                    Swal.fire('Error!', 'There was a problem adding your FAQ.', 'error');
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
                iconColor: '#346473',
                showCancelButton: true,
                confirmButtonColor: '#346473',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the user clicks "Yes", navigate to the logout page
                    window.location.href = event.target.href = "../homepage/login_page.php";
                }
            });
        });
    </script>

</body>

</html>