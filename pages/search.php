
<form name="f1" method="post" action="search.php">
    <input type="search" name="search_q"/></br>
    </br>
    <input type="submit" value="Поиск по категории"/></br>
</form>

<?php
require_once('../db_config/connection.php');
session_start();
$search_q = $_POST['search_q'];
$search_q = trim($search_q);
$search_q = strip_tags($search_q);
$sql = "SELECT `id`, `category`,`date`, `title`, `description` FROM `todos` WHERE `category` LIKE '%$search_q%'";
$res_data = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($res_data)){
    $id = $row['id'];
    // Выводим логин пользователя
    echo '<form action="components/process_is_done.php?'.$id.'" method="post">'.
        '<a href="todo.php?'.$id.'">'. $row['category'],' ', $row['date'],' ', $row['title']. '</a>'.'<br/>'.
        '<p><input type="submit" /></p>'.
        '</form>';
}
echo '<a href="components/main.php?main">Main page</a>';
mysqli_free_result($q);
mysqli_close($con);
?>