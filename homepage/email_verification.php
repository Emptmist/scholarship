

<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

if(isset($_GET['token'])){
    $token = $_GET['token'];
    $verify_token = "SELECT Verification_Token, Verification_Status FROM tbl_student_acc WHERE Verification_Token = '$token' LIMIT 1";
    $verify_query_run = mysqli_query($conn, $verify_token);

    if(mysqli_num_rows($verify_query_run) > 0){
        
        $row = mysqli_fetch_array($verify_query_run);

        if($row['Verification_Status'] == "0"){
            $verify_token = $row['Verification_Token'];
            $update_verification_status = "UPDATE tbl_student_acc SET Verification_Status = 1 WHERE Verification_Token = '$verify_token' LIMIT 1";
            $update_run = mysqli_query($conn, $update_verification_status);

            if($update_run){
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
                icon: "success",
                title: "Email Verified Successfully"
                });
                
                </script>';
                header("Location: login_page.php");
                exit(0);

            }else{
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
                icon: "Error",
                title: "Email Verification Failed"
                });
                
                </script>';
                header("Location: login_page.php");
                exit(0);
            }


        }else{
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
                title: "Email Already verified"
                });
                
                </script>';
                header("Location: login_page.php");
                exit(0);
        }

    }else{
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
                icon: "error",
                title: "Token does not exist"
                });
                
                </script>';
        header("Location: login_page.php");
        exit(0);
    }

}else{
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
                icon: "error",
                title: "Email not Allowed"
                });
                
                </script>';
    header("Location: login_page.php");
    exit(0);
}




?>