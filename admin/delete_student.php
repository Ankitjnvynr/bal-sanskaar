<?php
session_start();
include '../config/_db.php'; // include the database connection

if (isset($_GET['id']))
{
    $id = $_GET['id'];

    // Delete student record
    $sql = "DELETE FROM students WHERE id = $id";
    if ($conn->query($sql) === TRUE)
    {
        echo "Record deleted successfully";
    } else
    {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
    header("Location: dashboard.php?data=student"); // Redirect to the main page
    exit;
} else
{
    echo "Invalid request";
    exit;
}
?>