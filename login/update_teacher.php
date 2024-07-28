<?php
session_start();
include '../config/_db.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $id = $_POST['id'];
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $qualification = $_POST['qualification'];
    $country = isset($_POST['country']) ? $_POST['country'] : $_SESSION['country'];
    $state = isset($_POST['state']) ? $_POST['state'] : $_SESSION['state'];
    $district = isset($_POST['district']) ? $_POST['district'] : $_SESSION['district'];
    $tehsil = isset($_POST['tehsil']) ? $_POST['tehsil'] : $_SESSION['tehsil'];
    $center = isset($_POST['center']) ? $_POST['center'] : $_SESSION['center'];
    $page = isset($_POST['page']) ? $_POST['page'] : 1;

    // Retrieve the existing phone number from the database
    $sql = "SELECT phone FROM teachers WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($existing_phone);
    $stmt->fetch();
    $stmt->close();

    // Determine whether to update the password
    $update_password = false;
    if ($phone !== $existing_phone)
    {
        $new_password = password_hash($phone, PASSWORD_DEFAULT);
        $update_password = true;
    }

    // Update the teacher's information
    if ($update_password)
    {
        $sql = "UPDATE teachers SET name=?, dob=?, phone=?, qualification=?, country=?, state=?, district=?, tehsil=?, center=?, userpassword=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssi", $name, $dob, $phone, $qualification, $country, $state, $district, $tehsil, $center, $new_password, $id);
    } else
    {
        $sql = "UPDATE teachers SET name=?, dob=?, phone=?, qualification=?, country=?, state=?, district=?, tehsil=?, center=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssi", $name, $dob, $phone, $qualification, $country, $state, $district, $tehsil, $center, $id);
    }

    if ($stmt->execute())
    {
        $_SESSION['message'] = "Record updated successfully";
    } else
    {
        $_SESSION['message'] = "Error updating record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else
{
    $_SESSION['message'] = "Invalid request";
}

// Redirect back to the main page
header("Location: dashboard.php?data=teacher&page={$page}");
exit();
?>