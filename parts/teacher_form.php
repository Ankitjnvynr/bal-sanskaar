<?php
session_start();
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

if ($conn->query($sql_create_table) === FALSE)
{
    echo "Error creating table: " . $conn->error;
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Prepare data for insertion
    $teacher_type = isset($_POST['type']) ? $_POST['type'] : 'Teacher';
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $country = isset($_POST['country']) ? $_POST['country'] : $_SESSION['country'];
    $state = isset($_POST['state']) ? $_POST['state'] : $_SESSION['state'];
    $district = isset($_POST['district']) ? $_POST['district'] : $_SESSION['district'];
    $tehsil = isset($_POST['tehsil']) ? $_POST['tehsil'] : $_SESSION['tehsil'];
    $center = isset($_POST['center']) ? $_POST['center'] : $_SESSION['center'];

    // SQL insert statement
    $sql_insert = "INSERT INTO teachers (teacher_type, name, dob, phone, country, state, district,tehsil, center)
                   VALUES ('$teacher_type', '$name', '$dob', '$phone', '$country', '$state', '$district','$tehsil', '$center')";

    if ($conn->query($sql_insert) === TRUE)
    {
        echo "New record inserted successfully";
        if ($_SESSION['userType'] == 'admin')
        {
            header('location:../admin/dashboard.php?data=teacher');
            exit;
        } else
        {
            header('location:../login/dashboard.php?data=teacher');
        }

    } else
    {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}
$conn->close();
?>