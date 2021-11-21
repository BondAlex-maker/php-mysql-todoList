<?php
require_once('../../db_config/connection.php');
session_start();
$target_dir = "../../files/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$textFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Allow certain file formats
if($textFileType != "txt") {
    echo "Sorry, only TXT files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $file = fopen(''.$target_file.'', 'r');

        while (!feof($file)){
            $content = fgets($file);
            $splitArray = explode(';', $content);
            $description = $splitArray[1];
            $mainArr = explode(' ' ,$splitArray[0]);
            $category = $mainArr[0];
            $date = $mainArr[1];
            $title = implode(' ',array_splice($mainArr, 2));
            $exist = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `todos` WHERE `category` = '$category' AND  
            `title`='$title' AND `description` = '$description'"));
            $existId = $exist['id'];
            if ($exist) {
                $con->query("UPDATE `todos` SET `date` = '$date', `isDone` = 0 WHERE `id` = '$existId'");
            } else {
                $sql = "INSERT INTO `todos` (`category`,`title`, `date`, `description`)
                VALUES ('$category', '$title', '$date', '$description')";
                $con->query($sql);
            }
        }
        fclose($file);
        echo '<a href="logout.php?logout">Logout</a>';
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded and parsed.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>