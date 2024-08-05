<?php
$id = $_POST['id'];
$type = $_POST['type'];
include("../config/_db.php");

$response = array(); // Initialize response array

$center = null;
if ($type === 'Teacher') {
    $result = $conn->query("SELECT MAX(center) as max_center FROM teachers WHERE teacher_type='Teacher'");
    if ($result) {
        $row = $result->fetch_assoc();
        $max_center = isset($row['max_center']) ? (int)$row['max_center'] : 0; // Cast max_center to an integer
        $center = $max_center + 1;
        // Debugging information
        error_log("Max center value: " . $max_center);
        error_log("New center value: " . $center);
    } else {
        $response['status'] = 'error';
        $response['message'] = "Error fetching center number: " . $conn->error;
        echo json_encode($response);
        exit;
    }
} else {
    $center = 0; // Default center value for non-teachers, adjust if necessary
}

$sql = "UPDATE `teachers` SET `teacher_type` = ?, `center` = ? WHERE `teachers`.`id` = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    $response['status'] = 'error';
    $response['message'] = "Error preparing statement: " . $conn->error;
    echo json_encode($response);
    exit;
}
$stmt->bind_param('sii', $type, $center, $id);
$response['centertobeset'] = $center;
if ($stmt->execute()) {
    $response['status'] = 'success';
    $response['message'] = 'Update Success';
    $response['center'] = $center; // Include the new center value
} else {
    $response['status'] = 'error';
    $response['message'] = "Error: " . $stmt->error;
}
$stmt->close();

echo json_encode($response); // Return response in JSON format

$conn->close();
