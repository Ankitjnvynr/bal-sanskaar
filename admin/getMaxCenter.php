<?php
$id = $_POST['id'];
$type = $_POST['type'];
include("../config/_db.php");

$response = array(); // Initialize response array

$center = null;
if ($type === 'Teacher') {
    // Fetch maximum center for teachers
    $result = $conn->query("SELECT MAX(center) as max_center FROM teachers WHERE teacher_type='Teacher'");
    if ($result) {
        $row = $result->fetch_assoc();
        $max_center = isset($row['max_center']) ? (int)$row['max_center'] : 0; // Cast max_center to an integer
        $center = $max_center + 1;
        // Return max center value directly in response
        $response['status'] = 'success';
        $response['max_center'] = $max_center; // Return only the maximum center value
        echo json_encode($response);
        exit;
    } else {
        $response['status'] = 'error';
        $response['message'] = "Error fetching center number: " . $conn->error;
        echo json_encode($response);
        exit;
    }
} else {
    $center = 0; // Default center value for non-teachers, adjust if necessary
}

// No update query needed

echo json_encode($response); // Return response in JSON format

$conn->close();
