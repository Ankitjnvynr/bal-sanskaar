<?php
session_start();
require_once '../config/_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $roll = $_POST['roll'];
    $name = $_POST['name'];
    $dob = $_POST['dob']; // Assuming date format is handled appropriately
    $father_name = $_POST['father-name'];
    $father_phone = $_POST['father-phone'];
    $father_dob = $_POST['father-dob']; // Assuming date format is handled appropriately
    $mother_name = $_POST['mother-name'];
    $mother_phone = $_POST['mother-phone'];
    $mother_dob = $_POST['mother-dob']; // Assuming date format is handled appropriately
    $country = isset($_POST['country']) ? $_POST['country'] : $_SESSION['country'];
    $state = isset($_POST['state']) ? $_POST['state'] : $_SESSION['state'];
    $district = isset($_POST['district']) ? $_POST['district'] : $_SESSION['district'];
    $tehsil = isset($_POST['tehsil']) ? $_POST['tehsil'] : $_SESSION['tehsil'];
    $center = isset($_POST['center']) ? $_POST['center'] : $_SESSION['userCenter'];
    $address = $_POST['address']; // Assuming validation for address

    // Prepare and execute the INSERT statement using prepared statements for security
    $sql_insert = "INSERT INTO students (rollno, name, dob, father_name, father_phone, father_dob, mother_name, mother_phone, mother_dob, country, state, district, tehsil, address, center) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    try
    {
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("issssssssssssss", $roll, $name, $dob, $father_name, $father_phone, $father_dob, $mother_name, $mother_phone, $mother_dob, $country, $state, $district, $tehsil, $address, $center);
        $stmt->execute();

        echo "New record inserted successfully";

        // Redirect to appropriate dashboard (logic should be adapted as needed)
        $redirect = ($_SESSION['userType'] == 'admin' && $_SESSION['insertType'] == 'student') ? '../admin/dashboard.php?data=student' : '../login/dashboard.php?data=student';
        header("location:$redirect");
        exit;
    } catch (Exception $e)
    {
        echo "Error inserting record: " . $e->getMessage();
    } finally
    {
        $stmt->close(); // Close the prepared statement
        $conn->close(); // Close the database connection
    }
}
?>