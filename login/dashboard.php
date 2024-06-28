
<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true)
{
    header("location: index.php");
    exit;
}

if($_GET['data'] == 'student'){
    include 'studentdata.php';
}else{
    include 'teacherdata.php';
}
?>