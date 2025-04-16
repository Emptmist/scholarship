<?php
session_start();
ob_start();

$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

include "verification_sender.php";
include "OTP_generator.php"

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scholarships System</title>
    <!-- Bootstrap -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <!-- Icon website -->
    <link rel="icon" type="image/x-icon" href="logo.png">
    <!-- external -->
    <link href="forgot_pass.css" rel="stylesheet">
    <!--sweetalert2-->
    <script src="sweetalert2.all.min.js"></script>
    <link href="sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Navigation Bar -->
    <div class="row">
        <div class="col-sm-12 nav-fixed">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a href="homepage.php"><img src="logo.png" class="rounded float-start" alt="Logo" style="margin-left: 20px;"></a>
                    <a class="navbar-brand" href="homepage.php">SCHOLARSHIPS SYSTEM</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-left: 100px;">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="display: none;">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="homepage.php#REQUIREMENTS">REQUIREMENTS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="homepage.php#BENEFITS">BENEFITS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="homepage.php#ABOUTS">ABOUT US</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="homepage.php#FAQ">FAQ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="homepage.php#CONTACTUS">CONTACT US</a>
                            </li>
                        </ul>
                        <div class="d-grid gap-2 d-md-block" >
                            <a href="signup.php" style="display: none;">
                                <button class="btn btn-success" type="button">Sign Up</button>
                            </a>
                            <a href="login_page.php" style="display: none;" >
                                <button class="btn btn-success" type="button">Sign In</button>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Background Image -->
    <div class="bg-image"></div>

    <?php

    $email = '';
    
    if(isset($_POST['send_email'])){
        $email = $_POST['email'];

        $check_query = $conn->query("SELECT Email_Address FROM tbl_student_acc WHERE Email_Address = '$email';");

        if ($check_query->num_rows == 0) {
            // Email does not exist in the database
            $_SESSION['status'] = '<p style="color: red;">your Email is not existing</p>';

        } else {
            // Email exists
            $otp_value = generate_otp();

            $otp_query = $conn->prepare("UPDATE tbl_student_acc SET OTP_password = ? WHERE Email_Address = ?");
            $otp_query->bind_param("ss", $otp_value, $email);
            $otp_query->execute();

            
            $_SESSION['email'] = $email;

            otp_verification($otp_value, $email);

            

            

            header('location: OTP_verification.php');
        }

    }
    
    ?>



    <!-- Login Form -->

    

    <div class="form-container">
        <div class="form-content">
            <form action="" method="post">
                <h4 style="padding-left:2px; font-family:Inter; color:#25A55F;">Forgot Account?</h4>
                <p style="color: #838383;">Enter your email and we'll send you an mail to verify your account and reset your password</p>
                <label for="email">Email Address:</label>
                <div class="input-container">
                    <input type="text" id="email" placeholder="Enter your email address" value="<?php echo $email; ?>" name="email" required>
                    <!-- <img src="emaill.png" alt="Email Icon"> -->
                </div>
                <?php
    
                if (isset($_SESSION['status'])){
                    echo $_SESSION['status']; 
                    unset($_SESSION['status']);
                }
                
                ?>
                <button type="submit" name="send_email">SEND</button> <span style="padding: 15px; float: right;"><a href="login_page.php">Back to Login</a></span>
            </form>
        </div>
    </div>
</body>

<!-- javascript  -->
<script src="bootstrap.bundle.min.js"></script>
<script src="bootstrap.min.js"></script>
<script>
    //show pass
    function myFunction() {
        var x = document.getElementById("pass");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>

</html>