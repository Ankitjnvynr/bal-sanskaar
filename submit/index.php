<link rel="stylesheet" href="../css/header.css">

<?php
$logoPath = '../imgs/logo.png';
include '../parts/_header.php';
if(isset($_GET['type'])){
    if($_GET['type'] == 'Student'){
        include 'form.php';
    }else{
        include 'teacherForm.php';
    }
}else{
    header('Location: ../');
    exit(); // Ensure no further code is executed after redirection
}
?>
