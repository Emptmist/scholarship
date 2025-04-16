<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');


if (!isset($_SESSION['Admin_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ../homepage/login_page.php");
    exit();
}else{
    $Admin_id = $_SESSION['Admin_id'];
}


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- will change these link/script once actual file used in this link is found-->
    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!--icon website-->
    <link rel="icon" type="image/x-icon" href="logo.png">

    <!--icons-->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!-- own css -->
    <link rel="stylesheet" href="custom.css">

    <!--sweetalert2-->
    <script src="sweetalert2.all.min.js"></script>
    <link href="sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Coordinator Setting</title>
</head>
<style>
    .form-span {
        font-weight: bold;
        padding: 5px 0px 5px 10px;
    }

    .form-row {
        margin: 30px 0px 30px 0px;
    }

    .form-lbl {
        padding: 5px 0px 5px 0px;
        margin: 10px 0px 0px 0px;
        font-weight: 500;
    }

    .form-lbl,
    .form-span {
        font-size: 18px;
    }

    .form-ipt {
        padding: 5px 5px 5px 10px;
        background-color: #ffffff;
        color: gray;
        border-style: none;
        border-radius: 7px;
        font-size: 17px;
        width: 100%;
    }

    .form-ipt:focus {
        outline: none;
        background-color: #e3e3e3;
        transition: 0.3s;
    }
</style>

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
            <li >
                <a href="admin_profile.php">
                    <i class='bx bxs-user'></i>
                    <span class="link_name">PROFILE</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">PROFILE</a></li>
                </ul>
            </li>
            <li>
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
            <li style="border-radius: 5px;
background: rgba(244, 244, 244, 0.20);
box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.25);">
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
                <span class=" ms-4 fw-bold">COORDINATOR SETTING</span>
                <div class="d-flex ms-auto">
                    <a href="#" class="nav-link d-flex align-items-center" style="color: #25A55F;">
                        <span class="me-2 fw-normal">SCHOLARSHIP COORDINATOR</span>
                        <i class='bx bxs-user-circle custom-icon'></i>
                    </a>
                </div>
            </div>
        </nav>

        <hr>
        <form action="">
            <div class="row">
                <div class="col-lg-10">
                    <div class="main-container" style="max-height: none;">
                        <p id="title-name costum-title"><B>ACCOUNT SETTING</B></p>
                        <hr>
                        <div class="row">
                            <div class="col-lg-5 col-md-10">
                                <?php
                                $sql = "SELECT Email FROM tbl_admin_account WHERE Admin_id = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $Admin_id);
                                $stmt->execute();
                                $stmt->bind_result($Email);
                                $stmt->fetch();
                                $stmt->close();
                                ?>
                                <label class="form-lbl">Email Address:</label><br>
                                <input class="form-ipt" value="<?php echo htmlspecialchars($Email); ?>" disabled>
                            </div>
                            <div class="col-lg-12 col-md-10">
                                <label class="form-lbl">Currents Password:</label><br>
                            </div>
                            <div class="col-lg-3 col-md-10">
                                <?php
                                $sql = "SELECT Password FROM tbl_admin_account WHERE Admin_id = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $Admin_id);
                                $stmt->execute();
                                $stmt->bind_result($password);
                                $stmt->fetch();
                                $stmt->close();
                                ?>
                                <input class="form-ipt" type="password" value="**********" placeholder="Password" style="margin-bottom: 10px;" disabled>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <input class="form-ipt" id="newPassword" type="password" placeholder="New Password" style="margin-bottom: 10px;">
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <input class="form-ipt" id="confirmPassword" type="password" placeholder="Confirm Password" style="margin-bottom: 10px;">
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <div class="save">
                                    <button class="button" id="updateButton" style="padding: 7px 30px 7px 30px;">UPDATE</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form action="">
            <div class="row">
                <div class="col-lg-10">
                    <div class="main-container" style="max-height: none;">
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
            </div>
        </form>
    </section>

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

        //password update
        $(document).ready(function() {
            $('#updateButton').click(function(event) {
                event.preventDefault(); // Prevent default form submission

                var newPassword = $('#newPassword').val();
                var confirmPassword = $('#confirmPassword').val();

                if (newPassword.length < 8) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Password must be at least 8 characters long!',
                        confirmButtonColor: '#28a745',
                    });
                } else if (newPassword !== confirmPassword) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Passwords do not match!',
                        confirmButtonColor: '#28a745',
                    });
                } else {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, update it!',
                        cancelButtonText: 'No, cancel!',
                        confirmButtonColor: "#28a745",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "update_password.php",
                                data: {
                                    newPassword: newPassword,
                                    Admin_id: "<?php echo $Admin_id; ?>"
                                },
                                success: function(response) {
                                    console.log("Password updated successfully");
                                    Swal.fire({
                                    title: 'Updated!',
                                    text: 'Your password has been updated.',
                                    icon: 'success',
                                    confirmButtonColor: '#28a745',
                                }).then(() => {
                                        console.log("Reloading page");
                                        window.location.reload(); // Reload the page after the success popup
                                    });
                                },
                                error: function() {
                                    console.error("Error updating password");
                                    Swal.fire(
                                        'Error!',
                                        'There was an error updating your password.',
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                }
            });
        });

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