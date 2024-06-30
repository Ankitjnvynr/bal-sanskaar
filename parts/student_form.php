<?php

require_once '../config/_db.php';

// SQL to create table for student details
$sql_create_table = "CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    dob DATE,
    father_name VARCHAR(100),
    father_phone VARCHAR(20),
    father_dob DATE,
    mother_name VARCHAR(100),
    mother_phone VARCHAR(20),
    mother_dob DATE,
    country VARCHAR(50),
    state VARCHAR(50),
    district VARCHAR(50),
    tehsil VARCHAR(50),
    center VARCHAR(50)
)";

if ($conn->query($sql_create_table) === FALSE) {
  echo "Error creating table: " . $conn->error;
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare data for insertion
    
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $father_name = $_POST['father-name'];
    $father_phone = $_POST['father-phone'];
    $father_dob = $_POST['father-dob'];
    $mother_name = $_POST['mother-name'];
    $mother_phone = $_POST['mother-phone'];
    $mother_dob = $_POST['mother-dob'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $tehsil = $_POST['tehsil'];
    $center = $_POST['center'];

    // SQL insert statement
    $sql_insert = "INSERT INTO students (name, dob, father_name, father_phone, father_dob, mother_name, mother_phone, mother_dob, country, state, district, tehsil, center)
                   VALUES ('$name', '$dob', '$father_name', '$father_phone', '$father_dob', '$mother_name', '$mother_phone', '$mother_dob', '$country', '$state', '$district', '$tehsil', '$center')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "New record inserted successfully";
        header('location:../success.php');
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}
$conn->close();
?>
