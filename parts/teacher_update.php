<?php
session_start();
require_once '../config/_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Handle multiple roles
    $teacher_types = isset($_POST['teacher_type']) ? $_POST['teacher_type'] : [];
    // Convert to a comma-separated string and convert special characters to HTML entities
    $teacher_type = htmlspecialchars(implode(',', $teacher_types), ENT_QUOTES, 'UTF-8');

    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $qualification = $_POST['qualification'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $tehsil = $_POST['tehsil'];
    $address = $_POST['address'];
    $center = $_POST['center'];
    $dt = $_POST['dt'];

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
    if ($update_password) {
        // Phone number has changed, update user password as well
        $hash_pass = password_hash($phone, PASSWORD_DEFAULT);
        $sql_update = "UPDATE teachers 
                       SET teacher_type = ?, name = ?, dob = ?, phone = ?, qualification = ?, country = ?, state = ?, district = ?, tehsil = ?, center = ?, dt = ?, userpassword = ?, address = ?
                       WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sssssssssssssi", $teacher_type, $name, $dob, $phone, $qualification, $country, $state, $district, $tehsil, $center, $dt, $hash_pass, $address, $id);
    } else {
        // Phone number has not changed, do not update user password
        $sql_update = "UPDATE teachers 
                       SET teacher_type = ?, name = ?, dob = ?, phone = ?, qualification = ?, country = ?, state = ?, district = ?, tehsil = ?, center = ?, dt = ?, address = ?
                       WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssssssssssssi", $teacher_type, $name, $dob, $phone, $qualification, $country, $state, $district, $tehsil, $center, $dt, $address, $id);
    }

    // Execute the update statement
    if ($stmt_update->execute()) {
        echo "Record updated successfully";
        if ($_SESSION['isAdmin']) {
            header('Location: ../admin/dashboard.php?data=teacher');
            exit;
        } else {
            header('Location: ../login/dashboard.php?data=teacher');
            exit;
        }
    } else {
        echo "Error updating record: " . $stmt_update->error;
    }
    $stmt_update->close();
}
$conn->close();
