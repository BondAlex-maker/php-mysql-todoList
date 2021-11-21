<?php
require_once('../../db_config/connection.php');
session_start();
    $id = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    $sql = "UPDATE todos SET isDone='1' WHERE id= '$id'";
    $con->query($sql);

        header("location:../welcome.php");
?>