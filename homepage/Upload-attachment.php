<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <link href="bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap.bundle.min.js"></script>
    <script src="bootstrap.min.js"></script>

</head>
<body>
<?php
    $conn = new mysqli('localhost','root','','stud-system');
    $pdf_path = 'IMG-666bf0a6448a61.93975301.pdf';
    ///////// notworkiing
    // echo '<div class="Externalfiles">';
    // echo '<iframe src="'.$pdf_path.'" frameborder="0" width="100%" height="600px"></iframe>';
    // echo '</div>';

/////////workinggg
    // if(isset($_POST['view'])){
    //     header("content-type: application/pdf");
    //     readfile($pdf_path);
    // }

    // Handle file upload
    if(isset($_POST['submit']) && isset($_FILES['upload-file'])) {
        // echo "<pre>";
        // print_r($_FILES['upload-file']);
        // echo "</pre>";

        $img_name = $_FILES['upload-file']['name'];
        $img_size = $_FILES['upload-file']['size'];
        $tmp_name = $_FILES['upload-file']['tmp_name'];
        $error = $_FILES['upload-file']['error'];

        if ($error === 0) {
            if ($img_size > 525000) {
                echo "File too large";
            } else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                $allowed_exs = array('jpg', 'jpeg', 'png', 'pdf');

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                    $img_upload_path = $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    // INSERT INTO DATABASE
                    $sql = "INSERT INTO img(img_url) VALUES('$new_img_name')";
                    mysqli_query($conn, $sql);
                } else {
                    echo "You can't upload this type of file";
                }
            }
        } else {
            echo "An error occurred during file upload";
        }
    } else {
        echo "No file uploaded";
    }

    // ?>
    
    <div class="row">
        <div class="col-lg-12">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="file" name="upload-file">
                <input type="submit" value="upload" name="submit">
                <button name="view">View PDF</button>
            </form>
        </div>
        <div class="col-lg-12">
            <?php 
            $conn = new mysqli('localhost','root','','stud-system');
                // Display images and PDFs
                $sql_img = "SELECT * FROM img";
                $res = mysqli_query($conn, $sql_img);
                if (mysqli_num_rows($res) > 0) {
                    while($images = mysqli_fetch_assoc($res)) {
                        $file_url = $images['img_url'];
                        $file_ext = pathinfo($file_url, PATHINFO_EXTENSION);

                        if (in_array($file_ext, ['jpg', 'jpeg', 'png'])) {
                            echo '<div class="alb">
                                    <img src="'.$file_url.'" alt="" width="600" height="500">
                                </div>';
                        } elseif ($file_ext === 'pdf') {
                            echo '<div class="alb">
                                    <iframe src="'.$file_url.'" type="application/pdf" width="600" height="500" frameborder="0"></iframe>
                                </div>';
                        }
                    }
                }
            ?>
            
        </div>
    </div>
    
</body>
</html>