<?php
session_start();
require_once '../config/_db.php';

// if ($_SESSION['userType'] != 'admin')
// {
//     // Only allow admin to delete records
//     header('Location: ../login/dashboard.php');
//     exit;
// }

if (isset($_GET['id']))
{
    $id = intval($_GET['id']);

    if ($id > 0)
    {
        // SQL to delete record
        $sql_delete = "DELETE FROM teachers WHERE id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $id);

        if ($stmt_delete->execute())
        {
            echo "Record deleted successfully";
            header('Location: ../admin/dashboard.php?data=teacher');
            exit;
        } else
        {
            echo "Error deleting record: " . $stmt_delete->error;
        }

        $stmt_delete->close();
    } else
    {
        echo "Invalid ID";
    }
} else
{
    echo "ID not set";
}

$conn->close();
?>