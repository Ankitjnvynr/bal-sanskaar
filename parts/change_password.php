<?php
session_start();
require_once '../config/_db.php';

$response = ["success" => false, "message" => ""];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
        $response["message"] = "User not logged in.";
        echo json_encode($response);
        exit;
    }

    $userId = $_SESSION['id'];
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        $response["message"] = "New password and confirm password do not match.";
        echo json_encode($response);
        exit;
    }

    $stmt = $conn->prepare("SELECT userpassword FROM teachers WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($currentPassword, $hashedPassword)) {
        $response["message"] = "Current password is incorrect.";
        echo json_encode($response);
        exit;
    }

    $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE teachers SET userpassword = ? WHERE id = ?");
    $stmt->bind_param("si", $newHashedPassword, $userId);

    if ($stmt->execute()) {
        $response["success"] = true;
        $response["message"] = "Password changed successfully.";
    } else {
        $response["message"] = "Error updating password.";
    }

    $stmt->close();
    $conn->close();
}

echo json_encode($response);
?>
