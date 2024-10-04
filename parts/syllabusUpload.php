<?php
require_once '../config/_db.php'; // Including the database connection

// Function to ensure the target directory exists or create it
function ensureDirectoryExists($dir)
{
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true); // Create the directory with proper permissions
    }
}

// Function to insert data (title, subtitle, file name) into the database
function insertIntoDatabase($title, $subtitle, $fileName)
{
    global $conn; // Use the existing database connection from _db.php

    try {
        // Insert the data directly into the query
        $query = "INSERT INTO syllabus (title, subtitle, file_name, dt) VALUES ('$title', '$subtitle', '$fileName', NOW())";

        // Execute the query and check if it's successful
        if ($conn->query($query)) {
            return true; // Success
        } else {
            echo json_encode(['error' => 'Database insert failed.']);
            return false;
        }
    } catch (Exception $e) {
        // Output any exceptions for debugging
        echo json_encode(['error' => 'Exception: ' . $e->getMessage()]);
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required fields are present
    if (isset($_FILES['file']) && isset($_POST['title']) && isset($_POST['subtitle'])) {
        // File details
        $file = $_FILES['file'];
        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];

        // File upload configuration
        $targetDir = '../imgs/syllabus/'; // Target directory for file uploads
        ensureDirectoryExists($targetDir); // Ensure the directory exists or create it
        $fileName = uniqid() . '-' . basename($file['name']); // Rename the file with a unique ID
        $targetFile = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check file type (allow only PDFs)
        if ($fileType !== 'pdf') {
            echo json_encode(['error' => 'Only PDF files are allowed.']);
            http_response_code(400); // Bad Request
            exit;
        }

        // Move uploaded file to the target directory
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            // Insert data into the database (only storing the file name, not the full path)
            if (insertIntoDatabase($title, $subtitle, $fileName)) {
                echo json_encode(['success' => 'File uploaded and data stored successfully.']);
            } else {
                // Database error already handled in the insert function
                http_response_code(500); // Internal Server Error
            }
        } else {
            echo json_encode(['error' => 'Failed to upload file.']);
            http_response_code(500); // Internal Server Error
        }
    } else {
        echo json_encode(['error' => 'Required data is missing.']);
        http_response_code(400); // Bad Request
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
    http_response_code(405); // Method Not Allowed
}
