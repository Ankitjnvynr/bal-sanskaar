<?php
session_start();
include '../config/_db.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $id = $_POST['id'];
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $tehsil = $_POST['tehsil'];
    $center = $_POST['center'];

    $sql = "UPDATE teachers SET name=?, dob=?, phone=?, country=?, state=?, district=?, tehsil=?, center=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssi", $name, $dob, $phone, $country, $state, $district, $tehsil, $center, $id);

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
header("Location: dashboard.php?data=teacher");
exit();
?>