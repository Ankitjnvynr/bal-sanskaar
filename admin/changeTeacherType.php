<?php
$id = $_POST['id'];
$type = $_POST['type'];
include ("../config/_db.php");
$sql = "UPDATE `teachers` SET `teacher_type` = '$type' WHERE `teachers`.`id` = '$id'";
$result=$conn->query($sql);
if($result){
    echo 'Update Success';
}else{
    echo "eror" . $conn->error;
}
?>