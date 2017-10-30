<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="upfile.php" method="post" enctype="multipart/form-data">
            Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload Image" name="submit">

        </form>
        <?php
        if (isset($_POST["submit"])) {
            echo(var_dump($_FILES["fileToUpload"]));
            $target_dir = "../uploads/productos_img/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
            if (isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if ($check !== false) {
                    echo "<br>File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "<br>File is not an image.";
                    $uploadOk = 0;
                }
            }
            echo("<br><b>" . pathinfo($_FILES["fileToUpload"]["tmp_name"], PATHINFO_DIRNAME) . "   " . pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION) . "</b>");
            echo("<br><b>" . $_FILES["fileToUpload"]["tmp_name"] . "</b>");
// Check if file already exists
            if (file_exists($target_file)) {
                echo "<br>Sorry, file already exists.";
                $uploadOk = 0;
            }
// Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "<br>Sorry, your file is too large.";
                $uploadOk = 0;
            }
// Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo "<br>Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
// Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "<br>Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    echo "<br>The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
                } else {
                    echo "<br>Sorry, there was an error uploading your file.";
                }
            }
            echo("<br><b>" . $_FILES["fileToUpload"]["size"]);
        }
        exit();
        ?>
    </body>
</html>