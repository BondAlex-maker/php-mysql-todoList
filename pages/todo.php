<form name="f1" method="post" action="search.php">
    <input type="search" name="search_q"/></br>
    </br>
    <input type="submit" value="Поиск по категории"/></br>
</form>
<?php
require_once('../db_config/connection.php');
session_start();

$id = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_QUERY);
$sql = "SELECT `description` FROM `todos` WHERE `id` LIKE '%$id%' ";
$res_data = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($res_data)){
    $id = $row['id'];
    echo '<p>'. $row['description']. '</p>';
}
mysqli_close($con);
echo '<a href="components/logout.php?logout">Logout</a>';
echo '<a href="components/main.php?main">Main page</a>'
?>