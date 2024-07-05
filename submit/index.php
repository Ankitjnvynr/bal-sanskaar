<link rel="stylesheet" href="../css/header.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?php
$logoPath = '../imgs/logo.png';
$loginBtnPath = '../admin/';
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

<script src="../js/selectOption.js"></script>