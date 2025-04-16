<!DOCTYPE html>
<html lang="en">
<?php 

    session_start();

    $conn= mysqli_connect("localhost","root","","db_scholarship_system");

    // Check if the session variable is set
    if (!isset($_SESSION['Admin_id'])) {
        // Redirect to the login page if the user is not logged in
        header("Location: ../homepage/login_page.php");
        exit();
    }else{
        $student_no = $_SESSION['Admin_id'];
    }
    
    if (isset($_SESSION['Application_Student_No'])) {
        $Application_Student_No = $_SESSION['Application_Student_No'];
    } else {
        echo "No student number found in session.";
    }

    if (isset($_SESSION['Application_scholarship_no'])) {
        $Application_scholarship_no = $_SESSION['Application_scholarship_no'];
        
    } else {
        echo "No student number found in session.";
    }
    // Fetch tbl_personal_info data from database
    $sql = "SELECT * FROM tbl_personal_info WHERE Student_No = $Application_Student_No";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $Last_name = $row['Last_Name'];
            $First_name = $row['First_Name'];
            $Middle_name = $row['Middle_Name'];
            $Date_Of_Birth = $row['Date_of_Birth'];
            $Place_Of_Birth = $row['Place_Of_Birth'];
            $Gender = $row['Gender'];
            $Nationality = $row['Nationality'];
            $Religion = $row['Religion'];
            $Age = $row['Age'];
            $Civil_Status = $row['Civil_Status'];
            $Phone_No = $row['Phone_No'];
            $Email = $row['Email'];


        }
    }
    // Fetch tbl_address data from database
    $sql = "SELECT * FROM tbl_address WHERE Student_No = $Application_Student_No";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $Region = $row['Region'];
            $Province = $row['Province'];
            $Municipality = $row['Municipality'];
            $House_No_Street_Barangay = $row['House_No_Street_Barangay'];
        }
    }

    // Fetch tbl_mother_info data from database
    $sql = "SELECT * FROM tbl_mother_info WHERE Student_No = $Application_Student_No";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $M_Last_Name = $row['M_Last_Name'];
            $M_First_Name = $row['M_First_Name'];
            $M_MI = $row['M_MI'];
            $M_Occupation = $row['M_Occupation'];
            $M_Contact_No = $row['M_Contact_No'];
            $M_Citizenship = $row['M_Citizenship'];
            $M_Religion = $row['M_Religion'];
            $M_Income = $row['M_Income'];
        }
    }

    // Fetch tbl_father_info data from database
    $sql = "SELECT * FROM tbl_father_info WHERE Student_No = $Application_Student_No";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $F_Last_Name = $row['F_Last_Name'];
            $F_First_Name = $row['F_First_Name'];
            $F_MI = $row['F_MI'];
            $F_Occupation = $row['F_Occupation'];
            $F_Contact_No = $row['F_Contact_No'];
            $F_Citizenship = $row['F_Citizenship'];
            $F_Religion = $row['F_Religion'];
            $F_Income = $row['F_Income'];
        }
    }

    // Fetch tbl_elem_edu_bg data from database
    $sql = "SELECT * FROM tbl_elem_edu_bg WHERE Student_No = $Application_Student_No";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $Elem_Name_of_school = $row['Elem_Name_of_school'];
            $Elem_Year_graduated = $row['Elem_Year_graduated'];
        }
    }

    // Fetch tbl_jh_edu_bg data from database
    $sql = "SELECT * FROM tbl_jh_edu_bg WHERE Student_No = $Application_Student_No";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $JH_Name_of_school = $row['JH_Name_of_school'];
            $JH_Year_graduated = $row['JH_Year_graduated'];
        }
    }

    // Fetch tbl_sh_edu_bg data from database
    $sql = "SELECT * FROM tbl_sh_edu_bg WHERE Student_No = $Application_Student_No";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $SH_Name_of_school = $row['SH_Name_of_school'];
            $SH_Year_graduated = $row['SH_Year_graduated'];
        }
    }

    // Fetch tbl_college_edu data from database
    $sql = "SELECT * FROM tbl_college_edu WHERE Student_No = $Application_Student_No";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $C_Name_of_school = $row['C_Name_of_school'];
            $C_Year_graduated = $row['C_Year_graduated'];
            $C_Degree_Course = $row['C_Degree_Course'];
            $C_Degree_Unit = $row['C_Degree_Unit'];
            $C_GPA = $row['C_GPA'];
        }
    }

    // Fetch tbl_psa data from database
    $sql = "SELECT * FROM tbl_psa WHERE Student_No = $Application_Student_No";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $PSA_url = $row['PSA_url'];
        }
    }
    else{
        $PSA_url = " ";
    }


if(isset($_POST['view-psa'])){
    
        $sql_img = "SELECT * FROM tbl_psa WHERE Student_No = $Application_Student_No";
    
        $res = mysqli_query($conn, $sql_img);
    
        if (mysqli_num_rows($res) > 0) {
            while($images = mysqli_fetch_assoc($res)) {
                $file_url = $images['PSA_url'];
                $file_ext = pathinfo($file_url, PATHINFO_EXTENSION);
        
                if (in_array($file_ext, ['jpg', 'jpeg', 'png'])) {
                    echo '<div class="alb">
                            <img src="'.$file_url.'" alt="">
                        </div>';
                } elseif ($file_ext === 'pdf') {
                    header("content-type: application/pdf");
                    readfile("../stdntside/UPLOAD_files/".$file_url);
                }
            }
        }
        
    }elseif(isset($_POST['view-attach'])){
        $Name_Attachment = $_POST['Name_Attachment'];
        $no_req = $_POST['no_req'];


        $sql_attach = "SELECT * FROM tbl_req_attachment WHERE Student_No = $Application_Student_No AND no_req = $no_req";                            
        $res = mysqli_query($conn, $sql_attach);
    
        if (mysqli_num_rows($res) > 0) {
            while($attach = mysqli_fetch_assoc($res)) {
                $attach_url = $attach['Name_Attachment'];
                $attach_ext = pathinfo($attach_url, PATHINFO_EXTENSION);
                if ($attach_ext === 'pdf') {
                    header("content-type: application/pdf");
                    readfile("../stdntside/UPLOAD_files/".$attach_url);
                }
            }
        }
        
    }
    


 ?>
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


    <title>Coordinator View Application</title>
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
            <li>
                <a href="admin_dash.php">
                    <i class='bx bxs-home' ></i>
                    <span class="link_name">DASHBOARD</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">DASHBOARD</a></li>
                </ul>
            </li>
            <li style="border-radius: 5px;
background: rgba(244, 244, 244, 0.20);
box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.25);">
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
                <span class=" ms-4 fw-bold">STUDENT APPLICATION</span>
                <div class="d-flex ms-auto">
                    <a href="#" class="nav-link d-flex align-items-center" style="color: #25A55F;">
                        <span class="me-2 fw-normal">SCHOLARSHIP COORDINATOR</span>
                        <i class='bx bxs-user-circle custom-icon'></i>
                    </a>
                </div>
            </div>
        </nav> 

        <hr>

        <div class="row">
            <div class="col-lg-8">
                <div class="main-container" style="max-height: none;">
                    <!------- PERSONAL INFORMATION ------>
                    <div class="row">
                        <div class="col-sm-12">
                            <p id="title-name costum-title"><B>PERSONAL INFORMATION</B></p>
                            <hr>
                            <div class="row">
                                <div class="col" style="padding: 20px;">
                                    <div>
                                        <p><b>Full Name:</b> <?php echo $Last_name." ".$First_name." ".$Middle_name; ?></p>
                                        <p><b>Civil Status:</b> <?php echo $Civil_Status; ?></p>
                                        <p><b>Gender:</b> <?php echo $Gender; ?></p>
                                        <p><b>Age:</b> <?php echo $Age; ?></p>
                                        <p><b>Date of Birth:</b> <?php echo $Date_Of_Birth; ?></p>
                                        <p><b>Place Of Birth:</b> <?php echo $Place_Of_Birth; ?></p>
                                    </div>
                                </div>
                                <div class="col" style="padding: 20px;">
                                    <div>
                                        <p><b>Phone No:</b> <?php echo $Phone_No; ?></p>
                                        <p><b>Email:</b> <?php echo $Email; ?></p>
                                        <p><b>Nationality:</b> <?php echo $Nationality; ?></p>
                                        <p><b>Religion:</b> <?php echo $Religion; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!------- ADDRESS ------>

                    <div class="row">
                        <div class="col-sm-12">
                            <p id="title-name costum-title"><B>ADDRESS</B></p>
                            <hr>
                            <div class="row">
                                <div class="col" style="padding: 20px;">
                                    <div>
                                        <p><b>Region:</b> <?php echo $Region; ?></p>
                                        <p><b>Province:</b> <?php echo $Province; ?></p>
                                        <p><b>Municipality:</b> <?php echo $Municipality; ?></p>
                                        <p><b>House Number, Street and Barangay:</b> <?php echo $House_No_Street_Barangay; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!------- FAMILY BACKGROUND ------>

                    <div class="row">
                        <div class="col-sm-12">
                            <p id="title-name costum-title"><B>FAMILY BACKGROUND</B></p>
                            <hr>
                            <div class="row">
                                <div class="col" style="padding: 20px;">
                                <p id="title-name costum-title"><B>Mother’s Name:</B></p>
                                    <div>
                                        <p><b>Full Name:</b> <?php echo $M_Last_Name." ".$M_First_Name." ".$M_MI; ?></p>
                                        <p><b>Occupation:</b> <?php echo $M_Occupation; ?></p>
                                        <p><b>Citizenship:</b> <?php echo $M_Citizenship; ?></p>
                                        <p><b>Religion:</b> <?php echo $M_Religion; ?></p>
                                        <p><b>Contact No:</b> <?php echo $M_Contact_No; ?></p>
                                        <p><b>Annual Income:</b> <?php echo $M_Income; ?></p>
                                    </div>
                                </div>
                                <div class="col" style="padding: 20px;">
                                <p id="title-name costum-title"><B>Father’s Name:</B></p>
                                    <div>
                                        <p><b>Full Name:</b> <?php echo $F_Last_Name." ".$F_First_Name." ".$F_MI; ?></p>
                                        <p><b>Occupation:</b> <?php echo $F_Occupation; ?></p>
                                        <p><b>Citizenship:</b> <?php echo $F_Citizenship; ?></p>
                                        <p><b>Religion:</b> <?php echo $F_Religion; ?></p>
                                        <p><b>Contact No:</b> <?php echo $F_Contact_No; ?></p>
                                        <p><b>Annual Income:</b> <?php echo $F_Income; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!------- EDUCATIONAL BACKGROUND ------>
                <?php
                        $gpa = $C_GPA; // Example GPA value, replace this with your actual GPA value from the database

                        // Determine the status based on GPA
                        if ($gpa >= 1.00 && $gpa <= 1.50) {
                            $status = "PASSED";
                            $color = "#25A55F"; // Green
                        } elseif ($gpa >= 1.75 && $gpa <= 2.25) {
                            $status = "ACCEPTABLE";
                            $color = "#FFA500"; // Orange
                        } else {
                            $status = "FAILED";
                            $color = "#FF0000"; // Red
                        }
                        ?>

                    <div class="row">
                        <div class="col-sm-12">
                            <p id="title-name costum-title"><B>EDUCATIONAL BACKGROUND</B></p>
                            <hr>
                            <div class="row">
                                <div class="col" style="padding: 20px;">
                                    <div>
                                        <p><b>Elementary:</b> <?php echo $Elem_Name_of_school; ?></p>
                                        <p><b>Junior High:</b> <?php echo $JH_Name_of_school; ?></p>
                                        <p><b>Senior High:</b> <?php echo $SH_Name_of_school; ?></p>
                                        <p><b>College:</b> <?php echo $C_Name_of_school; ?></p>
                                        <p><b>Degree Course:</b> <?php echo $C_Degree_Course; ?></p>
                                        <p><b>Unit</b>: <?php echo $C_Degree_Unit; ?></p>
                                        <p><b>GPA:</b> <?php echo $C_GPA; ?><b style="color: <?= $color; ?>;"><?= $status; ?></b></p>
                                    </div>
                                </div>
                                <div class="col" style="padding: 20px;">
                                    <div>
                                        <p><?php echo $Elem_Year_graduated; ?></p>
                                        <p><?php echo $JH_Year_graduated; ?></p>
                                        <p><?php echo $SH_Year_graduated; ?></p>
                                        <p><?php echo $C_Year_graduated; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <p id="title-name costum-title"><B>LIST OF ATTACHMENT FILE</B></p>
                            <hr>
                            <div class="row">
                                <div class="col-sm-11 " style="padding-top: 20px; text-align: right;">
                                    
                                    <form action="" method="post" enctype="multipart/form-data">
                                    <label><b>PSA:</b> </label>
                                        <span style="font-size: 12px;"><button name="view-psa" class="button" style="padding: 7px 30px 7px 30px;">See Attachment File</button></span>
                                    </form>
                                </div>
                                <?php 
                            

                            $sql = "SELECT tbl_requirements.req_name, 
                                    tbl_req_attachment.Name_Attachment,
                                    tbl_req_attachment.no_req
                                    FROM tbl_requirements 
                                    LEFT JOIN tbl_req_attachment  
                                    ON tbl_requirements.no_req = tbl_req_attachment.no_req 
                                    WHERE tbl_requirements.scholarship_no = $Application_scholarship_no AND tbl_req_attachment.Student_No = $Application_Student_No AND tbl_req_attachment.scholarship_no = $Application_scholarship_no";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $Name_Attachment = $row['Name_Attachment'];
                                            $no_req = $row['no_req'];
                                            $req_name = $row['req_name'];
                                            echo'<div class="col-sm-11" style="padding-top: 20px; text-align: right;">
                                                    <form action="" method="post" enctype="multipart/form-data">
                                                    <label><b>'.$req_name.':</b> </label>
                                                        <input type="hidden" name="no_req" value="' . htmlspecialchars($no_req) . '">
                                                        <input type="hidden" name="Name_Attachment" value="' . htmlspecialchars($Name_Attachment) . '">
                                                        <span style="font-size: 12px;"><button name="view-attach" class="button" style="padding: 7px 30px 7px 30px;">See Attachment File</button></span>
                                                    </form>
                                                </div>';
                                        }
                                    }
                            ?>
                            </div>
                            
                        </div>
                    </div><br><br>

                </div>
            </div>

            <div class="col-lg-4">

                <div class="main-container" style="max-height: none; margin: 30px 30px 0px 30px; ">

                    <div class="col" style="display:flex; justify-content:center; align-items: center;">
                            <div class="img-cont" style="width: 200px; height: 200px; background-color: #ECECEC; ">
                                <a href="#" style="text-decoration: none;">
                                    <?php 
                                    $sql_img = "SELECT * FROM tb_id_picture WHERE Student_No = $Application_Student_No";
                                    $res = mysqli_query($conn, $sql_img);
                                    if (mysqli_num_rows($res) > 0) {
                                        while($images = mysqli_fetch_assoc($res)) {
                                            $file_url = $images['img_url'];
                                            $file_ext = pathinfo($file_url, PATHINFO_EXTENSION);

                                            if (in_array($file_ext, ['jpg', 'jpeg', 'png'])) {
                                                echo '<div class="alb">
                                                    <img src="../stdntside/UPLOAD_files/'.$file_url.'" alt="" width="200" height="200">
                                                </div>';
                                            } 
                                        }
                                    }
                                    ?>
                                </a>
                            </div>
                        </div>

                </div>
                

                <div class="main-container" style="max-height: none; margin: 30px 30px 0px 30px;">
                    <div class="row">
                    <div class="col-lg-12 " style="background-color: white; color: #346473; margin-top: 20px; padding: 20px; border-radius:10px; max-height: 760px">
                            <p><B>Qualifications</B></p>
                            <?php
                                    $sql = "SELECT * FROM tbl_scholarship WHERE scholarship_no = $Application_scholarship_no";
                                    $result = $conn->query($sql);
                        
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $qualifications = $row['qualifications'];
                                            echo"<p>$qualifications</p>";
                                        }
                                    }

                                ?>
                        </div>
                        <div class="col-lg-12 " style="background-color: white; color: #346473; margin-top: 20px; padding: 20px; border-radius:10px; max-height: 760px">
                            <p><B>Requirements</B></p>
                            <?php
                                    $sql = "SELECT * FROM tbl_requirements WHERE scholarship_no = $Application_scholarship_no";
                                    $result = $conn->query($sql);
                        
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $scholarship_no = $row['scholarship_no'];
                                            $no_req = $row['no_req'];
                                            $req_name = $row['req_name'];
                                            echo"<p>$no_req. $req_name</p>";
                                        }
                                    }

                                ?>
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

        
    </script>
    
</body>
</html>
