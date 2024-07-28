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
    $qualification = $_POST['qualification'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $tehsil = $_POST['tehsil'];
    $center = $_POST['center'];

    // Check existing phone number
    $sql_check_phone = "SELECT phone FROM teachers WHERE id = ?";
    $stmt_check_phone = $conn->prepare($sql_check_phone);
    $stmt_check_phone->bind_param("i", $id);
    $stmt_check_phone->execute();
    $stmt_check_phone->bind_result($existing_phone);
    $stmt_check_phone->fetch();
    $stmt_check_phone->close();

    // Determine if phone number has changed
    $update_password = ($phone !== $existing_phone);

    // Prepare SQL update statement
    if ($update_password)
    {
        // Phone number has changed, update userpassword as well
        $hash_pass = password_hash($phone, PASSWORD_DEFAULT);
        $sql_update = "UPDATE teachers 
                       SET teacher_type = ?, name = ?, dob = ?, phone = ?, qualification = ?, country = ?, state = ?, district = ?, tehsil = ?, center = ?, userpassword = ?
                       WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sssssssssssi", $teacher_type, $name, $dob, $phone, $qualification, $country, $state, $district, $tehsil, $center, $hash_pass, $id);
    } else
    {
        // Phone number has not changed, do not update userpassword
        $sql_update = "UPDATE teachers 
                       SET teacher_type = ?, name = ?, dob = ?, phone = ?, qualification = ?, country = ?, state = ?, district = ?, tehsil = ?, center = ?
                       WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssssssssssi", $teacher_type, $name, $dob, $phone, $qualification, $country, $state, $district, $tehsil, $center, $id);
    }

    // Execute the update statement
    if ($stmt_update->execute())
    {
        echo "Record updated successfully";
        if ($_SESSION['isAndmin'])
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