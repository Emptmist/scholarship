<?php
session_start();
ob_start();

$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');



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
    <link href="reset_pass.css" rel="stylesheet">

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
    
     

    

    if (isset($_POST["pass"]) && isset($_POST["confirm_pass"])) {
        $pass = $_POST["pass"];
        $confirm_pass = $_POST["confirm_pass"];

        if ($pass != $confirm_pass) {
            echo '<script>
                Swal.fire({
                    title: "MISMATCH",
                    text: "Passwords do not match",
                    icon: "error",
                    confirmButtonColor: "#346473"
                }).then(() => {
                    window.history.back();
                });
            </script>';
        } else {

            $otp_ref = $_SESSION['ref_otp'];

            $hash_pass = password_hash($pass, PASSWORD_BCRYPT);

            $otp_query = $conn->prepare("UPDATE tbl_student_acc SET Password = ? WHERE OTP_password = ?");
            $otp_query->bind_param("ss", $hash_pass, $otp_ref);
            $otp_query->execute();

            $_SESSION['status'] = '<script>
                
            const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
            });
            Toast.fire({
            icon: "Success",
            title: "Password Change!"
            });
            
            </script>';
            header("Location: login_page.php");
            exit(0);
           
        }
    }



    
    
    ?>



    <!-- Login Form -->

    <?php
    
    if (isset($_SESSION['status'])){
        echo $_SESSION['status']; 
        unset($_SESSION['status']);
    }
    
    ?>
    

    <div class="form-container" >
        <div class="form-content" style="width: 50%;">
            <form action="" method="post" style="width: 100%;" id="signup-form">
                <h4 style="padding-left:2px; font-family:Inter; color:#25A55F;">Reset Password</h4>
                <p style="color: #25A55F;">Enter your New password</p>

                <label for="psw">New Password:</label>
                <div class="sign_input-container" style="width:95%; padding-bottom:5px;">
                    <input type="password" id="psw1" placeholder="Enter your New password" name="pass" required>
                </div>
                <label for="con_psw">Confirm Password:</label>
                <div class="sign_input-container" style="width:95%; padding-bottom:5px;">
                        <input type="password" id="psw2" placeholder="Confirm your password" name="confirm_pass" required>
                </div>

                <div id="password-feedback" style="color: red; font-size: 12px; padding-top: 5px; padding-bottom: 0;"></div>

                <input type="checkbox" onclick="myFunction()"><span style="color: #25A55F;"> Show Password</span><br><br>
                <button type="submit" name="change" style="margin: 0px;" id="signup-btn" >CHANGE</button>
            </form>
        </div>
    </div>
</body>

<!-- javascript  -->
<script src="bootstrap.bundle.min.js"></script>
<script src="bootstrap.min.js"></script>
<script>

    const passwordInput1 = document.getElementById('psw1');
    const passwordInput2 = document.getElementById('psw2');   
    const passwordFeedback = document.getElementById('password-feedback');
    const signupButton = document.getElementById('signup-btn');
    const signupForm = document.getElementById('signup-form'); // Make sure to add this line if the form element wasn't declared earlier

    //show pass
    function myFunction() {
        var x = document.getElementById("psw1");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }

        var y = document.getElementById("psw2");
        if (y.type === "password") {
            y.type = "text";
        } else {
            y.type = "password";
        }

    }
    

    function validatePassword(password) {
        const criteria = {
            hasUpperCase: /[A-Z]/.test(password),
            hasLowerCase: /[a-z]/.test(password),
            hasNumber: /\d/.test(password),
            hasSymbol: /[!@#$%^&*(),.?":{}|<>]/.test(password), // Optional
            isLongEnough: password.length >= 8
        };

        let feedback = '';

        if (!criteria.hasUpperCase) feedback += 'Must contain an uppercase letter. ';
        if (!criteria.hasLowerCase) feedback += 'Must contain a lowercase letter. ';
        if (!criteria.hasNumber) feedback += 'Must contain a number. ';
        if (!criteria.hasSymbol) feedback += 'Should contain a symbol. '; // Optional
        if (!criteria.isLongEnough) feedback += 'Should be at least 8 characters. '; // Optional

        return {
            isValid: criteria.hasUpperCase && criteria.hasLowerCase && criteria.hasNumber && criteria.isLongEnough,
            feedback
        };
    }

    passwordInput1.addEventListener('input', function() {
        const { isValid, feedback } = validatePassword(passwordInput1.value);
        passwordFeedback.textContent = feedback;
        passwordFeedback.style.color = feedback === '' ? 'green' : 'red';
    });

    passwordInput2.addEventListener('input', function() {
        const { isValid, feedback } = validatePassword(passwordInput2.value);
        passwordFeedback.textContent = feedback;
        passwordFeedback.style.color = feedback === '' ? 'green' : 'red';
    });

    signupForm.addEventListener('submit', function(event) {
    const { isValid: isValid1, feedback: feedback1 } = validatePassword(passwordInput1.value);
    const { isValid: isValid2, feedback: feedback2 } = validatePassword(passwordInput2.value);

    if (!isValid1 || !isValid2) {
        event.preventDefault(); // Prevent form submission
        Swal.fire({
            title: "Invalid Password",
            text: isValid1 ? feedback2 : feedback1,
            icon: "error",
            confirmButtonColor: "#346473"
        });
    }

    if (!validateForm()) {
        event.preventDefault(); // Prevent form submission if passwords do not match
    }
    });
    function validateForm() {
            const pass = document.getElementById('psw1').value;
            const confirm_pass = document.getElementById('psw2').value;

            // Validate password match
            if (pass !== confirm_pass) {
                Swal.fire({
                    title: "MISMATCH",
                    text: "Passwords do not match",
                    icon: "error",
                    confirmButtonColor: "#346473"
                });
                return false;
            }

           

            // If all validations pass, proceed with form submission
            return true;
        }
</script>

</html>