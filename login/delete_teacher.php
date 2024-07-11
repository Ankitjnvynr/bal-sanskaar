<?php
session_start(); // Ensure session is started

include '../config/_db.php'; // Include the database connection

if (isset($_GET['id']))
{
    $teacherId = $_GET['id'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("DELETE FROM teachers WHERE id = ?");
    $stmt->bind_param("i", $teacherId);

    // Execute the statement
    if ($stmt->execute())
    {
        $_SESSION['message'] = "Record deleted successfully";
        header("Location: dashboard.php?data=teacher&page=" . $_GET['page']);
    } else
    {
        $_SESSION['message'] = "Error deleting record: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else
{
    $_SESSION['message'] = "Invalid request";
}

// Redirect back to the main page
// header("Location: dashboard.php?data=teacher&page=". $_GET['page']);
exit();
?>