<?php
$servername = "localhost";
$username = "kigabit";
$password = "sniperdark";
$dbname = "todoList";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$sqlUsers = "CREATE TABLE users (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(30) NOT NULL UNIQUE,
password varchar(255) DEFAULT NULL,
isAdmin BOOLEAN DEFAULT FALSE,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

$sqlList = "CREATE TABLE todos (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
category VARCHAR(30) NOT NULL,
title VARCHAR(30) NOT NULL,
date DATETIME NOT NULL,
description varchar(255) DEFAULT NULL,
isDone BOOLEAN DEFAULT FALSE 
)";

$sql = "INSERT INTO users (username, password, isAdmin)
VALUES ('admin', 'admin', true);";
$sql .= "INSERT INTO users (username, password)
VALUES ('user', 'user');";
$sql .= "INSERT INTO users (username, password)
VALUES ('test', 'test')";

if ($conn->multi_query($sqlUsers) === TRUE) {
    echo "Table users created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
if ($conn->multi_query($sqlList) === TRUE) {
    echo "Table todos created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

if ($conn->multi_query($sql) === TRUE) {
    echo "seeds inserted successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>