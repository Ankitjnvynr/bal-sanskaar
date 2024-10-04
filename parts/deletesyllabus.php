<?php
require_once '../config/_db.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    
    // SQL query to select the file name before deletion
    $sql = "SELECT file_name FROM syllabus WHERE id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($file_name);
        $stmt->fetch();
        $stmt->close();

        // Proceed only if a file name is retrieved
        if ($file_name) {
            // Construct the file path (assumes files are stored in the 'uploads' directory)
            $file_path = '../imgs/syllabus/' . $file_name;

            // Check if the file exists and delete it
            if (file_exists($file_path)) {
                if (unlink($file_path)) {
                    // File deleted successfully
                    // Now delete the record from the database
                    $sql = "DELETE FROM syllabus WHERE id = ?";
                    if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param("i", $id);
                        if ($stmt->execute()) {
                            echo "Record and file deleted successfully.";
                        } else {
                            echo "Error deleting record: " . $conn->error;
                        }
                        $stmt->close();
                    } else {
                        echo "Error preparing statement for record deletion: " . $conn->error;
                    }
                } else {
                    echo "Error deleting file.";
                }
            } else {
                echo "File does not exist.";
            }
        } else {
            echo "No file associated with this record.";
        }
    } else {
        echo "Error preparing statement for file selection: " . $conn->error;
    }
} else {
    echo "Invalid ID.";
}

$conn->close();
?>
