<?php

$con=mysqli_connect('localhost','kigabit','sniperdark','todoList');

if(!$con)
{
    die(' Please Check Your Connection'.mysqli_error($con));
}
?>