<?php
session_start();
require_once '../config/_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $id = $_POST['id'];
    $teacher_type = $_POST['type'];
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $tehsil = $_POST['tehsil'];
    $center = $_POST['center'];

    // Update record
    $sql_update = "UPDATE teachers 
                   SET teacher_type = ?, name = ?, dob = ?, phone = ?, country = ?, state = ?, district = ?, tehsil = ?, center = ?
                   WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssssssssi", $teacher_type, $name, $dob, $phone, $country, $state, $district, $tehsil, $center, $id);

    if ($stmt_update->execute())
    {
        echo "Record updated successfully";
        if ($_SESSION['userType'] == 'admin')
        {
            header('Location: ../admin/dashboard.php?data=teacher');
            exit;
        } else
        {
            // header('Location: ../login/dashboard.php?data=teacher');
            exit;
        }
    } else
    {
        echo "Error updating record: " . $stmt_update->error;
    }
    $stmt_update->close();
}
$conn->close();
?>