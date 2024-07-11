<?php

include '../config/_db.php';

if (isset($_POST['phone']))
{
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("SELECT COUNT(*) FROM teachers WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();

    echo json_encode(['exists' => $count > 0]);

    $stmt->close();
    $conn->close();
}
?>