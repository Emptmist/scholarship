<?php 
        session_start();

        $conn = new mysqli('localhost','root','','db_scholarship_system');

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

                // Change the directory
        require '../vendor/autoload.php';
        require '../vendor/phpmailer/phpmailer/src/Exception.php';
        require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require '../vendor/phpmailer/phpmailer/src/SMTP.php';
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
    <link rel="stylesheet" href="superadmin_announcement.css">

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
            <li >
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
            <li>
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
            <li style="border-radius: 5px;
background: rgba(244, 244, 244, 0.20);
box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.25);">
                <a href="superadmin_announcement.php">
                    <i class='bx bxs-megaphone'></i>
                    <span class="link_name">ANNOUNCEMENT</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">ANNOUNCEMENT</a></li>
                </ul>
            </li>
            <li>
                <a href="#" id="logout-link">
                    <i class='bx bxs-log-out'></i>
                    <span class="link_name ">LOG OUT</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">LOG OUT</a></li>
                </ul>
            </li>            
        </ul>
    </div>
    <section class="home-section" style="height: auto;">  
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <span class=" ms-4 fw-bold">ANNOUNCEMENT</span>
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
                    <form id="announcementForm" action="superadmin_announcement.php" method="post" enctype="multipart/form-data">
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
                                                <option value="all_students">Students</option>
                                                <option value="all_coordinator">Coordinator</option>
                                            </select>

                                            <label for="post_to" class="form-label fs-6" style="float:right; margin-right :1%;margin-top:0.5%;">Post to all: </label>
                                            <textarea class="form-control" id="title" name="title" rows="3" maxlength="80" oninput="updateCharCount()" placeholder="Announcement Title" style="margin-top: 1%;" required></textarea>
                                            <div id="charCount" class="mt-2">0 / 80 characters</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="body" class="form-label fs-5">Body</label>
                                    <textarea class="form-control" id="body" name="body" rows="100" style="overflow-y: scroll; max-height: 50vh;" placeholder="Announcement Body" required></textarea>
                                </div>

                                <div class="position-relative d-flex">
                                <div class="file-wrapper">
                                
                                    <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*" class="file-input" onchange="showFileName(this)">
                                    <button type="button" class="file-button" onclick="document.getElementById('image').click()">
                                        Upload &nbsp;<img src="upimg.png" style="height:20px;width:25px;">
                                    </button>
                                    <span id="file-name" class="file-name"></span>
                                </div>
                        
                                <button type="submit" class="btn position-absolute btn-lg post-btn shadow" style="right: 5px; background-color: #346473; color: white;" name="submit">Post</button>

                            

                                
                                </div>
                            </div>
                      
                    </form>

                    <?php
                        if (isset($_POST['submit'])) {
                            $selection = $_POST['posted_to'];
                            $title = $_POST['title'];
                            $body = $_POST['body'];
                            
                        
                            // Initialize PHPMailer
                            $mail = new PHPMailer(true);
                        
                            try {
                                // Server settings
                                $mail->isSMTP();
                                $mail->Host       = 'smtp.gmail.com';
                                $mail->SMTPAuth   = true;
                                $mail->Username   = 'scholarshipsystem1@gmail.com';
                                $mail->Password   = 'tmpn yszw tasf wfue';
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                $mail->Port       = 587;
                        
                                // Sender info
                                $mail->setFrom("scholarshipsystem1@gmail.com", "Scholarship System");
                        
                            
                        
                                // Fetch all email addresses at once
                                if ($selection === 'all_students'){

                                    if (!isset($_FILES["fileToUpload"]["name"]) || empty($_FILES["fileToUpload"]["name"])){
                                        $sql_query = "SELECT Email_Address FROM `tbl_student_acc`";
                                        $result = $conn->query($sql_query);
                                
                                        if ($result->num_rows > 0) {

                                            $recipients = [];
                                            while ($row = $result->fetch_assoc()) {
                                                $recipients[] = $row["Email_Address"];
                                            }
                                
                                            // Send email to all recipients in one go using BCC
                                            foreach ($recipients as $email) {
                                                $mail->addBCC($email);
                                            }
                                
                                            $mail->isHTML(true);    
                                            $mail->Subject = "Scholarship System - Super Admin";
                                            $mail->Body    = "<h2><b>$title</b></h2><h5>$body</h5>";
                                            
                                
                                            // Send the email to all recipients
                                            $mail->send();

                                        } else {
                                            echo "No students found.";
                                        }
                                    }else {
                                        $sql_query = "SELECT Email_Address FROM `tbl_student_acc`";
                                        $result = $conn->query($sql_query);
                                
                                        if ($result->num_rows > 0) {
                                            $recipients = [];
                                            while ($row = $result->fetch_assoc()) {
                                                $recipients[] = $row["Email_Address"];
                                            }
                                
                                            // Send email to all recipients in one go using BCC
                                            foreach ($recipients as $email){
                                                $mail->addBCC($email);
                                            }
                                            
                                            $mail->isHTML(true);    
                                            $mail->Subject = "Scholarship System - Super Admin";
                                            $mail->Body    = "<h2><b>$title</b></h2><h5>$body</h5>";
                                            $mail->addAttachment($_FILES["fileToUpload"]["tmp_name"], $_FILES["fileToUpload"]["name"]);
                                
                                            // Send the email to all recipients
                                            $mail->send();

                                        } else {
                                            echo "No students found.";
                                        }

                                    }
                                } elseif ($selection === 'all_coordinator') {
                                    if (!isset($_FILES["fileToUpload"]["name"]) || empty($_FILES["fileToUpload"]["name"])){
                                        $sql_query = "SELECT Email FROM `tbl_admin_account`";
                                        $result = $conn->query($sql_query);
                                
                                        if ($result->num_rows > 0) {

                                            $recipients = [];
                                            while ($row = $result->fetch_assoc()) {
                                                $recipients[] = $row["Email"];
                                            }
                                
                                            // Send email to all recipients in one go using BCC
                                            foreach ($recipients as $email) {
                                                $mail->addBCC($email);
                                            }
                                
                                            $mail->isHTML(true);    
                                            $mail->Subject = "Scholarship System - Super Admin";
                                            $mail->Body    = "<h2><b>$title</b></h2><h5>$body</h5>";
                                            
                                
                                            // Send the email to all recipients
                                            $mail->send();

                                        } else {
                                            echo "No Admin found.";
                                        }
                                    }else {
                                        $sql_query = "SELECT Email FROM `tbl_admin_account`";
                                        $result = $conn->query($sql_query);
                                
                                        if ($result->num_rows > 0) {
                                            $recipients = [];
                                            while ($row = $result->fetch_assoc()) {
                                                $recipients[] = $row["Email"];
                                            }
                                
                                            // Send email to all recipients in one go using BCC
                                            foreach ($recipients as $email){
                                                $mail->addBCC($email);
                                            }
                                            
                                            $mail->isHTML(true);    
                                            $mail->Subject = "Scholarship System - Super Admin";
                                            $mail->Body    = "<h2><b>$title</b></h2><h5>$body</h5>";
                                            $mail->addAttachment($_FILES["fileToUpload"]["tmp_name"], $_FILES["fileToUpload"]["name"]);
                                
                                            // Send the email to all recipients
                                            $mail->send();

                                        } else {
                                            echo "No Admin found.";
                                        }

                                    }
                                }
                                    
                        
                            } catch (Exception $e) {
                                echo "Mailer Error: {$mail->ErrorInfo}";
                            } finally {
                                // Close SMTP connection
                                $mail->smtpClose();
                            }
                        }
                    ?>




    </section>


  




    <script>

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

        function updateCharCount() {
            const textarea = document.getElementById('title');
            const charCountDisplay = document.getElementById('charCount');
            const currentLength = textarea.value.length;
            const maxLength = textarea.maxLength;
            charCountDisplay.textContent = `${currentLength} / ${maxLength} characters`;
        }

        function showFileName(input) {
        const fileName = input.files[0]?.name || "No file chosen";
        document.getElementById('file-name').textContent = fileName;
}

    </script>
    
</body>

</html>
