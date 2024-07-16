<?php
session_start();
require_once '../config/_db.php';

// SQL to create table
$sql_create_table = "CREATE TABLE IF NOT EXISTS teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_type VARCHAR(50) NOT NULL,
    name VARCHAR(100) NOT NULL,
    dob DATE,
    phone VARCHAR(20) UNIQUE,
    country VARCHAR(50),
    state VARCHAR(50),
    district VARCHAR(50),
    tehsil VARCHAR(50),
    center VARCHAR(50),
    userpassword VARCHAR(255)
)";

if ($conn->query($sql_create_table) === FALSE) {
    echo "Error creating table: " . $conn->error;
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    $hash_pass = password_hash($phone, PASSWORD_DEFAULT);

    // Use prepared statement
    $stmt = $conn->prepare("INSERT INTO teachers (teacher_type, name, dob, phone, country, state, district, tehsil, center, userpassword) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Check if preparation was successful
    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }
    
    $stmt->bind_param("ssssssssss", $teacher_type, $name, $dob, $phone, $country, $state, $district, $tehsil, $center, $hash_pass);

    if ($stmt->execute()) {
        echo "New record inserted successfully";
        if ($_SESSION['userType'] == 'admin') {
            header('location:../admin/dashboard.php?data=teacher');
            exit;
        } else {
            header('location:../login/dashboard.php?data=teacher');
            exit;
        }
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
