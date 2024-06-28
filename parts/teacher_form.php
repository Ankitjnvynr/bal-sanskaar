<?php

require_once '../config/_db.php';

// SQL to create table
$sql_create_table = "CREATE TABLE IF NOT EXISTS teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_type VARCHAR(50) NOT NULL,
    name VARCHAR(100) NOT NULL,
    dob DATE,
    phone VARCHAR(20) unique,
    country VARCHAR(50),
    state VARCHAR(50),
    district VARCHAR(50),
    tehsil VARCHAR(50),
    center VARCHAR(50)
)";

if ($conn->query($sql_create_table) === FALSE) {
  echo "Error creating table: " . $conn->error;
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare data for insertion
    $teacher_type = $_POST['type'];
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $tehsil = $_POST['tehsil'];
    $center = $_POST['center'];

    // SQL insert statement
    $sql_insert = "INSERT INTO teachers (teacher_type, name, dob, phone, country, state, district,tehsil, center)
                   VALUES ('$teacher_type', '$name', '$dob', '$phone', '$country', '$state', '$district','$tehsil', '$center')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "New record inserted successfully";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}
$conn->close();
?>
