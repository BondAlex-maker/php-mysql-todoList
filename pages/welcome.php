<html>
<head>
    <title>Pagination</title>
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<main style="width: 1150px; display: flex; flex-direction: column; margin: 0 auto; border: 10px solid gray; padding: 10px">
<h1>Weclome to "To do list"</h1>
<h2>Search by category</h2>
<form name="f1" class="form-group"  method="post" action="search.php">
    <input type="search" class="form-control" name="search_q"/></br>
    </br>
    <input type="submit" class="btn" value="Поиск по категории"/></br>
</form>
<?php
require_once('../db_config/connection.php');
session_start();

if(isset($_SESSION['User']))
{
    if (isset($_GET['pageno'])) {

        $pageno = $_GET['pageno'];
    } else { // Иначе

        $pageno = 1;
    }
    $size_page = 5;

    $offset = ($pageno-1) * $size_page;
    $count_sql = "SELECT COUNT(*) FROM `todos` WHERE `isDone` = '0'";
    $result = mysqli_query($con, $count_sql);
    $total_rows = mysqli_fetch_array($result)[0];
    $total_pages = ceil($total_rows / $size_page);
    $sql = "SELECT * FROM `todos` WHERE `isDone` = '0' LIMIT $offset, $size_page";
    $res_data = mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($res_data)){
        $id = $row['id'];
        echo '<form style="display: flex; align-items: center;" action="components/process_is_done.php?'.$id.'" method="post">'.
        '<a style="margin-right: 20px; color: gray" href="todo.php?'.$id.'">'. $row['category'],' ', $row['date'],' ', $row['title']. '</a>'.'<br/>'.
        '<p><input class="btn" type="submit" value="done" /></p>'.
        '</form>';
    }

    $query_is_admin = "select `isAdmin` from users where `username`='".$_SESSION['User']."'";
    $result_is_admin = mysqli_query($con,$query_is_admin);
    $rowUser = mysqli_fetch_array($result_is_admin);
        if ($rowUser['isAdmin'] === '1'){
            echo '<form action="components/upload.php" method="post" enctype="multipart/form-data">' .
                'Select file to upload:'.
                '<label class="form-label" for="customFile">Todos file input for .txt files</label>'.
                '<input class="form-control form-control-lg" style="margin: 10px 0 10px" type="file" name="fileToUpload" id="fileToUpload" accept="text/plain"/>'.
                '<input class="btn" type="submit" value="Upload File" name="submit">'.
                '</form>';
         }
    mysqli_close($con);
}
else
{
    header("location:index.php");
}

?>
<ul class="pagination">
    <li><a href="?pageno=1">First</a></li>
    <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
        <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
    </li>
    <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
        <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
    </li>
    <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
</ul>
    <a style="color: red" href="components/logout.php?logout">Logout</a>
</main>
</body>
</html>
