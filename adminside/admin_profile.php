<?php

    session_start();
    // Database connection
    $conn = new mysqli('localhost','root','','db_scholarship_system');

    // Check if the session variable is set

    if (!isset($_SESSION['Admin_id'])) {
        // Redirect to the login page if the user is not logged in
        header("Location: ../homepage/login_page.php");
        exit();
    }else{
        $Admin_id = $_SESSION['Admin_id'];
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- will change these link/script once actual file used in this link is found-->
    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
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

    <title>Coordinator Profile</title>
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

    .form-lbl, .form-span {
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
    input[type="file"]{
        display: none;
    }
    img {
        border-radius: 50%;
        width: 148px;
        height: 148px;
        margin-top: 5px;
        border: 2px solid #ccc;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background-color: #f3f3f3;
    }

    @media screen and (max-width:1440px){
            .custompic{
                margin-top:100px;
            }
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
            <li style="border-radius: 5px;
background: rgba(244, 244, 244, 0.20);
box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.25);">
                <a href="#">
                    <i class='bx bxs-user'></i>
                    <span class="link_name">PROFILE</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">PROFILE</a></li>
                </ul>
            </li>
            <li>
                <a href="admin_dash.php">
                    <i class='bx bxs-home' ></i>
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
                <span class=" ms-4 fw-bold">COORDINATOR PROFILE</span>
                <div class="d-flex ms-auto">
                    <a href="#" class="nav-link d-flex align-items-center" style="color: #25A55F;">
                        <span class="me-2 fw-normal">SCHOLARSHIP COORDINATOR</span>
                        <i class='bx bxs-user-circle custom-icon'></i>
                    </a>
                </div>
            </div>
        </nav> 

        <hr>

        <div>
            
        <?php
            

            

            // Check if form is submitted
            if (isset($_POST['admin_submit'])) {
                
                $admin_lname = $_POST['admin_lname'];
                $admin_fname = $_POST['admin_fname'];
                $admin_mname = $_POST['admin_mname'];
                $admin_address = $_POST['admin_address'];
                $admin_phone = $_POST['admin_phone'];
                $admin_age = $_POST['admin_age'];
                $admin_bdate = $_POST['admin_bdate'];

                // Insert data into database
                $sql = "UPDATE tbl_admin_personal_info SET Last_Name = '$admin_lname',First_Name = '$admin_fname',Middle_name = '$admin_mname', address = '$admin_address', phone = '$admin_phone', age = '$admin_age', birth_date = '$admin_bdate' WHERE Admin_id = $Admin_id";
                // $sql = "INSERT INTO tbl_admin_personal_info (Admin_id,Last_Name,First_Name,Middle_name,address,phone,age,birth_date) VALUES ($Admin_id,'$admin_lname','$admin_fname', '$admin_mname', '$admin_address','$admin_phone','$admin_age','$admin_bdate')";
                $result = mysqli_query($conn, $sql);

                //pop upp
                echo "<script>Swal.fire({
                    title: 'SAVED',
                    text: 'Successfully Completed!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2000
                    });</script>";
            } 
            else {
                
                $sql = "SELECT * FROM tbl_admin_personal_info WHERE Admin_id = $Admin_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $admin_lname = $row['Last_Name'];
                        $admin_fname = $row['First_Name'];
                        $admin_mname = $row['Middle_Name'];
                        $admin_address = $row['address'];
                        $admin_phone = $row['phone'];
                        $admin_age = $row['age'];
                        $admin_bdate = $row['birth_date'];
                    }
                }
                else {
                    // If no data is found, keep the variables as empty strings (inputs will be blank)
                    $admin_lname = "";
                    $admin_fname = "";
                    $admin_mname = "";
                    $admin_address = "";
                    $admin_phone = "";
                    $admin_age = "";
                    $admin_bdate = "";
                }
            }
            // Fetch data from database
            $sql = "SELECT * FROM tbl_admin_account WHERE Admin_id = $Admin_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $Email = $row['Email'];
                    $Pass = $row['Password'];
                    
                }
            }

            ?>
            
            <div class="row">
                <div class="title-page">
                    <span id="title-name" style="color:  #346473;">General Details</span>
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <div class="main-container" style="max-height: none;">
                        <p id="title-name costum-title"><B>PERSONAL INFORMATION</B></p>
                        <p id="title-name costum-title">Coordinator ID:<B><?php echo $Admin_id;?></B></p>
                        <hr>
                        <form action="" method="post" id="admin-form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div>
                                        <label class="form-lbl">Last Name:</label><br>
                                    </div>
                                    <div>
                                        <input class="form-ipt" value="<?= htmlspecialchars($admin_lname);?>" placeholder="Enter Last Name" style="margin-bottom: 10px;" name="admin_lname" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div>
                                        <label class="form-lbl">First Name:</label><br>
                                    </div>
                                    <div>
                                        <input class="form-ipt" value="<?= htmlspecialchars($admin_fname);?>" placeholder="Enter First Name" style="margin-bottom: 10px;"name="admin_fname" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div>
                                        <label class="form-lbl">Middle Name:</label><br>
                                    </div>
                                    <div>
                                        <input class="form-ipt" value="<?= htmlspecialchars($admin_mname);?>" placeholder="Enter Middle Name" style="margin-bottom: 10px;"name="admin_mname" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <label class="form-lbl">Full Address:</label><br>
                                    <input class="form-ipt" value="<?= htmlspecialchars($admin_address);?>" placeholder="Enter Address" style="padding: 10px 100px 100px 10px;"name="admin_address" required>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <label class="form-lbl">Phone:</label><br>
                                    <span class="form-num input-group-text" style="width: 17%; float: left; margin-right: 7px;" id="addon-wrapping">+63</span>
                                    <!-- <input class="form-ipt" value="<?= htmlspecialchars($admin_phone);?>" placeholder="Enter Phone number"name="admin_phone" required> -->
                                    <input style="width: 200px;" class="form-num form-control" value="<?= htmlspecialchars($admin_phone);?>" placeholder="Enter Phone Number" oninput="validateNumberInput(event)" maxlength="10" name="admin_phone" id="admin_phone" required>
                                    <script>
                                        const phoneInput = document.getElementById('admin_phone');
                                        phoneInput.addEventListener('input', () => {
                                            const charCount = phoneInput.value.length;
                                            const charValue = phoneInput.value;
                                            if (charCount >= 10 && charValue >= 9000000000) {
                                                phoneInput.value = phoneInput.value.substring(0, 10);
                                                phoneInput.setCustomValidity('');
                                            }else if (charCount != 10){
                                                phoneInput.setCustomValidity(`Must be a valid 10 digits (9XX-XXX-XXXX)`);
                                            }
                                        });
                                    </script>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <label class="form-lbl">Age:</label><br>
                                            <input class="form-ipt" value="<?= htmlspecialchars($admin_age);?>" placeholder="Enter Age" name="admin_age" id="admin_age" min="17" readonly required>
                                            <p id="message" style="color: red; margin: 0; padding: 0;"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <label class="form-lbl">Birthdate:</label><br>
                                    <input class="form-ipt" type="date" value="<?= htmlspecialchars($admin_bdate);?>" placeholder="Birthdate" name="admin_bdate" id="admin_bdate" required oninput="calculateAge()">
                                </div>
                            </div><br>
                            <div class="row">
                                <br><br>
                                <div class="col-lg-6 col-md-12">
                                    <label class="form-lbl">Email Address:</label><br>
                                    <input class="form-ipt" value="<?= htmlspecialchars($Email);?>" placeholder="Email Address"name="admin_email" readonly>
                                </div>
                                <br><br>
                                <div class="col-lg-6 col-md-12">
                                    <label class="form-lbl">Password:</label><br>
                                    <input class="form-ipt" type="password" value="**********" placeholder="Password" name="admin_pass" readonly>
                                </div>
                                <div class="col-lg-12" style="margin-top:10px;">
                                    <div class="save">
                                        <button class="button" style="padding: 7px 30px 7px 30px;" name="admin_submit" type="submit">UPDATE</button>
                                    </div>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>
                <?php 
                    $conn = new mysqli('localhost','root','','db_scholarship_system'); // Adjust your connection details

                    $sql_img = "SELECT * FROM tbl_admin_profile_picture WHERE Admin_id = $Admin_id";
                    
                    $res = mysqli_query($conn, $sql_img);

                    
                    if (mysqli_num_rows($res) > 0) {
                        $images = mysqli_fetch_assoc($res);
                        $img_url = !empty($images['image']) ? 'admin-UPLOAD_FILEs/'.$images['image'] : '';
                    } else {
                        $img_url = '';
                    }

                    if(isset($_POST['save-picture']) && isset($_FILES['uploadpicbtn'])) {
                
                        $img_name = $_FILES['uploadpicbtn']['name'];
                        $img_size = $_FILES['uploadpicbtn']['size'];
                        $tmp_name = $_FILES['uploadpicbtn']['tmp_name'];
                        $error = $_FILES['uploadpicbtn']['error'];
                
                        if ($error === 0) {
                            if ($img_size > 525000) {
                                echo "<script>Swal.fire({
                                    icon: 'error',
                                    title: 'File too large!,
                                    showConfirmButton: false,
                                    timer: 1500
                                    });</script>";

                            } else {

                                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                                $img_ex_lc = strtolower($img_ex);
                
                                $allowed_exs = array('jpg', 'jpeg', 'png');
                
                                if (in_array($img_ex_lc, $allowed_exs)) {
                                    $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                                    $img_upload_path = 'admin-UPLOAD_FILEs/' . $new_img_name;
                                    move_uploaded_file($tmp_name, $img_upload_path);
                
                                    // INSERT INTO DATABASE
                                    $sql = "UPDATE tbl_admin_profile_picture SET image = '$new_img_name' WHERE  Admin_id = $Admin_id";
                                    // $sql = "INSERT INTO tbl_admin_profile_picture(image) VALUES('$new_img_name')";
                                    mysqli_query($conn, $sql);
                                    echo "<script>Swal.fire({
                                        title: 'SAVED',
                                        text: 'Successfully uploaded!',
                                        icon: 'success',
                                        showConfirmButton: false,
                                        timer: 1500
                                        });</script>";
                                } else {
                                    echo "<script>Swal.fire({
                                        icon: 'error',
                                        title: 'Invalid file type!,
                                        showConfirmButton: false,
                                        timer: 1500
                                        });</script>";
                                }
                            }
                        } else {
                            echo "<script>Swal.fire({
                                icon: 'error',
                                title: 'An error occurred during file upload!,
                                showConfirmButton: false,
                                timer: 1500
                                });</script>";
                        }
                    }

                ?>
                
                    
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="main-container">
                        <p id="title-name costum-title"><B>PROFILE PICTURE</B></p>
                        <hr>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-6 col-md-6  col-lg-6">
                                    <input type="file" id="uploadpicbtn" name="uploadpicbtn" accept="image/*" style="display: none;" onchange="previewImage(event)">
                                        <div for="uploadpicbtn" class="img-cont" onclick="document.getElementById('uploadpicbtn').click();">
                                            <?php if ($img_url): ?>
                                                <img src="<?= $img_url ?>" alt="User Image">
                                            <?php else: ?>
                                                <div class='bx bxs-user-circle custom-icon' style="font-size: 150px;"></div>
                                            <?php endif; ?>
                                        </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6 custompic" style="margin-top:30px; font-size:18px;">
                                    <div>
                                        <p id="title-name">Edit your photo</p>
                                    </div>
                                    <di class="row">
                                        <div class="col-sm-6">
                                            <div class="save">
                                                <button type="submit" name="save-picture" class="button" data-popup='popup1' style="padding: 2px 10px 2px 10px;">UPDATE</button>
                                            </div>
                                        </div>
                                    </di>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="popup1" class="popup">
                    <div class="popup-content2" align='center'>
                        <h1 style="color:#346473;">UPDATED</h1><br>
                        <p style="font-size: 20px;">Profile Picture Updated successfully!</p><br>
                        <div class="row">
                            <div class="col-sm-12">
                                <button class="close-button cancel-boton">CLOSE</button>
                            </div>
                        </div>
                    </div>
                </div>
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

        // //popups handler
        // document.addEventListener("DOMContentLoaded", () => {
        //     const triggers = document.querySelectorAll(".trigger");
        //     const popups = document.querySelectorAll(".popup");
        //     const closeButtons = document.querySelectorAll(".close-button");

        //     triggers.forEach(trigger => {
        //         trigger.addEventListener("click", () => {
        //             const popupId = trigger.getAttribute("data-popup");
        //             const popup = document.getElementById(popupId);
        //             popup.style.display = "block";
        //         });
        //     });

        //     closeButtons.forEach(button => {
        //         button.addEventListener("click", () => {
        //             popups.forEach(popup => {
        //                 popup.style.display = "none";
        //             });
        //         });
        //     });

        //     window.addEventListener("click", (event) => {
        //         popups.forEach(popup => {
        //             if (event.target === popup) {
        //                 popup.style.display = "none";
        //             }
        //         });
        //     });
        // })
        function previewImage(event) {
            var output = document.querySelector('.img-cont');
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    output.innerHTML = '<img src="' + e.target.result + '" alt="Image Preview">';
                }
                reader.readAsDataURL(file);
            }
        }

        /// log out button
        document.getElementById('logout-link').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default link click behavior
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out.",
                icon: 'warning',
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

        function validateNumberInput(event) {
            // Get the value of the input field
            const inputField = event.target;
            const value = inputField.value;

            // Regular expression to allow only numbers
            const regex = /^[0-9]*$/;

            // Validate the input value against the regex
            if (!regex.test(value)) {
                // Remove the last character if it's not a number
                inputField.value = value.slice(0, -1);
            }
            const inputFieldlen = event.target;
            const maxLength = inputFieldlen.getAttribute('maxlength');
            const currentLength = inputFieldlen.value.length;

            // Check if the current length exceeds the maximum length
            if (currentLength >= maxLength) {
                // Prevent additional input
                inputFieldlen.value = inputFieldlen.value.slice(0, maxLength);
            }
        }

        function calculateAge() {
            const birthYearInput = document.getElementById('admin_bdate').value;
            const currentYear = new Date().getFullYear();
            const ageInput = document.getElementById('admin_age');
            const message = document.getElementById('message');

            // Check if the input is valid
            if (birthYearInput) {
                const birthYear = new Date(birthYearInput).getFullYear();
                
                // Calculate age
                if (birthYear > 0 && birthYear <= currentYear) {
                    const age = currentYear - birthYear;
                    ageInput.value = age;
                    message.innerHTML = '';
                    if (age < 17) {
                        ageInput.value = '';
                        message.innerHTML = 'Age must be 17 or older';
                    }
                } else {
                    ageInput.value = '';
                }
            } else {
                ageInput.value = '';
            }
        }

        document.getElementById('admin-form').onsubmit = function(event) {
            const age = document.getElementById('admin_age').value;
            if (age < 17) {
                event.preventDefault(); // Prevent form submission
                document.getElementById('message').innerHTML = 'Age must be 17 or older';
            }
        };
    </script>
</body>
</html>
