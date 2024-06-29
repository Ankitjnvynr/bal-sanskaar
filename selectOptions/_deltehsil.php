<?php
require ("../config/_db.php");
if (isset($_POST['delid']))
{
    $delid = $_POST['delid'];
    $sql = "DELETE FROM `allselect` WHERE id = $delid";
    if($conn->query($sql)){
        echo "deleted";
    }else{
        $conn->error;
    }
}
?>