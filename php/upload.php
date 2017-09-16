<?php
    session_start();
    
    if (($_FILES["fileToUpload"] && $_FILES["fileToUpload"]["name"] != "") && $_POST['submit_upload'] == "Upload Image")
    {
        $target_dir = "../page/home/no_cam/";
        $target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false)
            {
                $_SESSION['error_info'] = "File is an image - " . $check[0] . " x ".$check[1];
                $uploadOk = 1;
            }
            else
            {
                $_SESSION['error_info'] = "File is not an image.";
                $uploadOk = 0;
            }
        }
        if ($_FILES["fileToUpload"]["size"] > 50000000)
        {
            $_SESSION['error_info'] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg")
        {
            $_SESSION['error_info'] = "Sorry, only JPG, JPEG & PNG files are allowed.";
            $uploadOk = 0;
        }
        if ($uploadOk == 0)
        {
            $_SESSION['error_info'] = "Sorry, your file was not uploaded.";
            header('Location: ../page/home/no_cam');
        }
        else if ($uploadOk == 1)
        {
            if ($_FILES["fileToUpload"]["tmp_name"])
            {
                $res = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
                if ($res == TRUE)
                    rename($target_file, $target_dir.$_SESSION['id_user'].".png");
            }
            header('Location: ../page/home/no_cam');
        }
    }
    else
        header('Location: ../page/home/no_cam');
?>
