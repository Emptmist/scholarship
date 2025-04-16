<?php 
        session_start();
        
        // Check if the session variable is set
        if (!isset($_SESSION['Student_No'])) {
            // Redirect to the login page if the user is not logged in
            header("Location: ../homepage/login_page.php");
            exit();
        }else{
            $student_no = $_SESSION['Student_No'];
        }

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attachment</title>

    <!--bootstrap-->
    <link href="bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap.bundle.min.js"></script>
    <script src="bootstrap.min.js"></script>

    <!--icons-->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!--icon website-->
    <link rel="icon" type="image/x-icon" href="logo.png">

    <!--css-->
    <link rel="stylesheet" href="std_attach.css">

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
                    <i class='bx bxs-user' ></i>
                    <span class="link_name">PERSONAL INFO</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">PERSONAL INFO</a></li>
                </ul>
            </li>
            <li style="border-radius: 5px;
background: rgba(244, 244, 244, 0.20);
box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.25);">
                <a href="#">
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
                <span class=" ms-4 fw-bold">ATTACHMENT</span>
                <div class="d-flex ms-auto">
                    <a href="#" class="nav-link d-flex align-items-center">
                        <span class="me-2 fw-normal">STUDENT</span>
                        <i class='bx bxs-user-circle custom-icon'></i>
                    </a>
                </div>
            </div>
        </nav> 
        

        <hr>
        <?php
            $conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

            function handleFileUpload($file, $student_no, $table, $column, $conn, $allowed_exs,$newname) {
                $img_name = $file['name'];
                $img_size = $file['size'];
                $tmp_name = $file['tmp_name'];
                $error = $file['error'];

                if ($error === 0) {
                    if ($img_size > 4194304) {
                        echo "<script>Swal.fire({
                            icon: 'error',
                            title: 'File too large for $column',
                            showConfirmButton: false,
                            timer: 1500
                            });</script>";
                        return false;
                    } else {
                        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                        $img_ex_lc = strtolower($img_ex);

                        if (in_array($img_ex_lc, $allowed_exs)) {
                            $new_img_name = uniqid($newname, true) . '.' . $img_ex_lc;
                            $img_upload_path = 'UPLOAD_files/' . $new_img_name;
                            if (move_uploaded_file($tmp_name, $img_upload_path)) {
                                // INSERT INTO DATABASE
                                 $sql = "UPDATE $table SET $column = '$new_img_name' WHERE Student_No = $student_no ";
                                // $sql = "INSERT INTO $table (Student_No, $column) VALUES ($student_no, '$new_img_name')";
                                if (mysqli_query($conn, $sql)) {
                                    echo "<script>Swal.fire({
                                        title: 'SAVED',
                                        text: 'Successfully uploaded!',
                                        icon: 'success',
                                        showConfirmButton: false,
                                        timer: 1500
                                        });</script>";
                                } 
                            }
                            else {
                                echo "<script>Swal.fire({
                                    icon: 'error',
                                    title: 'Failed to move uploaded file for $column',
                                    showConfirmButton: false,
                                    timer: 1500
                                    });</script>";
                                return false;
                            }
                        } 
                        else {
                            echo "<script>Swal.fire({
                                icon: 'error',
                                title: 'Invalid file type for $column',
                                showConfirmButton: false,
                                timer: 1500
                                });</script>";
                            return false;
                        }
                    }
                } 
                else {
                    echo "<script>Swal.fire({
                        icon: 'error',
                        title: 'An error occurred during file upload for $column: error code $error'',
                        showConfirmButton: false,
                        timer: 1500
                        });</script>";
                    return false;
                }
            }

            if (isset($_POST['save-attach'])) {
                $uploads = array(
                    'pic_upload' => array('file' => isset($_FILES['pic_upload']) ? $_FILES['pic_upload'] : null, 'newname' => 'ID_PIC_ATTACHMENT', 'table' => 'tb_id_picture', 'column' => 'img_url', 'allowed_exs' => array('jpg', 'jpeg', 'png')),
                    'psa_upload' => array('file' => isset($_FILES['psa_upload']) ? $_FILES['psa_upload'] : null,'newname' => 'PSA_ATTACHMENT', 'table' => 'tbl_psa', 'column' => 'PSA_url', 'allowed_exs' => array('pdf'))
                );

                foreach ($uploads as $key => $upload) {
                    if ($upload['file'] && $upload['file']['error'] !== UPLOAD_ERR_NO_FILE) {
                        $result = handleFileUpload($upload['file'], $student_no, $upload['table'], $upload['column'], $conn, $upload['allowed_exs'],$upload['newname']);
                        if ($result) {
                        }
                    }
                }

            }


            // Fetch data from database
            $sql_pic = "SELECT * FROM tb_id_picture WHERE Student_No = $student_no";
            $result_pic = $conn->query($sql_pic);

            if ($result_pic->num_rows > 0) {
                while ($row = $result_pic->fetch_assoc()) {
                    $Student_No = $row['Student_No'];
                    $img_url = $row['img_url'];
                }
            } else {
                $img_url = " ";
            }
            $sql_psa = "SELECT * FROM tbl_psa WHERE Student_No = $student_no";
            $result_psa = $conn->query($sql_psa);

            if ($result_psa->num_rows > 0) {
                while ($row = $result_psa->fetch_assoc()) {
                    $Student_No = $row['Student_No'];
                    $PSA_url = $row['PSA_url'];
                }
            } else {
                $PSA_url = " ";
            }

        ?>
        
        <!--main content-->
        <div class="main-container">
            <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <span class="main-style">List of Attachment</span>
                <!--id picture-->
                <div class="col-lg-4">
                    <div class="attach">
                        <span class="main-style">ID PICTURE</span>
                        <p>Note: Must be taken within three (3) months prior to application. Standard, closed-up shot from the shoulders up.</p>
                        <br>
                        <input type="file" id="uploadpicbtn" name="pic_upload"  value="" accept="image/jpeg" onchange="displayFileName(this)">
                        <label for="uploadpicbtn"  class="button">Click to Upload</label>
                        <p style="margin-top: 10px">Only JPEG/JPG files with a maximum file size of less than 4MB (4096 KB) are accepted.</p>
                        <p style="color: brown;"><i class='bx bxs-file-blank' style="margin-right: 5px;"><span id="file-name"><?php echo"$img_url";?></span></i></p>
                    </div>
                </div>
                <!--psa-->
                <div class="col-lg-4">
                    <div class="attach">
                        <span class="main-style">PSA</span>
                        <p>Note: Philippine Statistics Authority (also known as NSO)/City or Municipality Registrar Birth Certificate.</p>
                        <br>
                        <input type="file" id="uploadpsabtn" name="psa_upload" value="" accept="application/pdf" onchange="displayFileName1(this)">
                        <label for="uploadpsabtn" class="button">Click to Upload</label>
                        <p style="margin-top: 10px">Only PDF files with a maximum file size of less than 4MB (4096 KB) are accepted.</p>
                        <p style="color: brown;"><i class='bx bxs-file-blank' style="margin-right: 5px;"></i><span id="file-name1"><?php echo"$PSA_url";?></span></i></p>
                    </div>
                </div>
            </div>
            <div class="save">
                <button class="button" style="padding: 7px 30px 7px 30px;" name="save-attach">Save</button>
            </div>
            </form>
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

        function displayFileName(input) {
            const fileName = input.files[0].name;
            document.getElementById('file-name').textContent = fileName;
        }
        function displayFileName1(input) {
            const fileName1 = input.files[0].name;
            document.getElementById('file-name1').textContent = fileName1;
        }

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