<?php
// Assuming you have a connection to your MySQL database in $conn
include '../config/_db.php';
if (isset($_GET['id']))
{
    $id = intval($_GET['id']);

    $sql = "DELETE FROM `centers` WHERE `centers`.`id` = '$id'";

    if ($conn->query($sql))
    {
        echo "Center with ID $id has been deleted.";
        header('location:addTeacher.php');
    } else
    {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else
{
    echo "No ID specified.";
}

$conn->close();
?>