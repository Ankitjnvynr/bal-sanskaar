<?php
session_start();
require_once '../config/_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll = isset($_POST['roll']) ? $_POST['roll'] : null;
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $dob = isset($_POST['dob']) ? $_POST['dob'] : null;
    $father_name = isset($_POST['father-name']) ? $_POST['father-name'] : null;
    $father_phone = isset($_POST['father-phone']) ? $_POST['father-phone'] : null;
    $father_dob = isset($_POST['father-dob']) ? $_POST['father-dob'] : null;
    $mother_name = isset($_POST['mother-name']) ? $_POST['mother-name'] : null;
    $mother_phone = isset($_POST['mother-phone']) ? $_POST['mother-phone'] : null;
    $mother_dob = isset($_POST['mother-dob']) ? $_POST['mother-dob'] : null;

    // Check for country, state, district, tehsil, and center from session only if POST values are not set
    $country = isset($_POST['country']) ? $_POST['country'] : ($_SESSION['country'] ?? null);
    $state = isset($_POST['state']) ? $_POST['state'] : ($_SESSION['state'] ?? null);
    $district = isset($_POST['district']) ? $_POST['district'] : ($_SESSION['district'] ?? null);
    $tehsil = isset($_POST['tehsil']) ? $_POST['tehsil'] : ($_SESSION['tehsil'] ?? null);
    $center = isset($_POST['center']) ? $_POST['center'] : ($_SESSION['userCenter'] ?? null);
    $address = isset($_POST['address']) ? $_POST['address'] : null;

    // Handle FOC registration options
    $register_option = isset($_POST['registerOption']) ? $_POST['registerOption'] : null;
    $foc_details = isset($_POST['focDetails']) ? $_POST['focDetails'] : null;

    // Prepare and execute the INSERT statement using prepared statements for security
    $sql_insert = "INSERT INTO students (rollno, name, dob, father_name, father_phone, father_dob, mother_name, mother_phone, mother_dob, country, state, district, tehsil, address, center, register_option) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    try {
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("isssssssssssssss", $roll, $name, $dob, $father_name, $father_phone, $father_dob, $mother_name, $mother_phone, $mother_dob, $country, $state, $district, $tehsil, $address, $center, $register_option);
        $stmt->execute();

        echo "New record inserted successfully";

        // Redirect to appropriate dashboard
        $redirect = ($_SESSION['userType'] == 'admin' && $_SESSION['insertType'] == 'student') ? '../admin/dashboard.php?data=student' : '../login/dashboard.php?data=student';
        header("location:$redirect");
        exit;
    } catch (Exception $e) {
        echo "Error inserting record: " . $e->getMessage();
    } finally {
        $stmt->close(); // Close the prepared statement
        $conn->close(); // Close the database connection
    }
}
?>
