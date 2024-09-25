<?php
session_start();
require_once '../config/_db.php';

// SQL to create table (if not exists)
$sql_create_table = "CREATE TABLE IF NOT EXISTS teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_type VARCHAR(50) NOT NULL,
    name VARCHAR(100) NOT NULL,
    dob DATE,
    phone VARCHAR(20) UNIQUE,
    qualification VARCHAR(100),  
    country VARCHAR(50),
    state VARCHAR(50),
    district VARCHAR(50),
    tehsil VARCHAR(50),
    address TEXT,
    center INT,
    userpassword VARCHAR(255)
)";

if ($conn->query($sql_create_table) === FALSE) {
    echo "Error creating table: " . $conn->error;
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $teacher_types = isset($_POST['type']) ? $_POST['type'] : ['Teacher']; // Default to 'Teacher'
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $qualification = $_POST['qualification'];
    $country = isset($_POST['country']) ? $_POST['country'] : $_SESSION['country'];
    $state = isset($_POST['state']) ? $_POST['state'] : $_SESSION['state'];
    $district = isset($_POST['district']) ? $_POST['district'] : $_SESSION['district'];
    $tehsil = isset($_POST['tehsil']) ? $_POST['tehsil'] : $_SESSION['tehsil'];
    $address = $_POST['address'];
    $center = null;
    $hash_pass = password_hash($phone, PASSWORD_DEFAULT);

    // Check if the phone number already exists
    $stmt_check = $conn->prepare("SELECT id FROM teachers WHERE phone = ?");
    $stmt_check->bind_param("s", $phone);
    $stmt_check->execute();
    $stmt_check->store_result();
    
    if ($stmt_check->num_rows > 0) {
        // If phone number exists, throw an error
        echo "Error: Phone number already exists!";
        $stmt_check->close();
        exit;
    }
    $stmt_check->close();

    // Handle teacher type and center assignment
    foreach ($teacher_types as $teacher_type) {
        // If the type is 'Teacher', assign a new center number
        if ($teacher_type === 'Teacher') {
            $result = $conn->query("SELECT MAX(center) as max_center FROM teachers WHERE teacher_type='Teacher'");
            if ($result) {
                $row = $result->fetch_assoc();
                $max_center = $row['max_center'];
                $center = ($max_center !== NULL ? (int)$max_center : 0) + 1;
            } else {
                echo "Error fetching center number: " . $conn->error;
                exit;
            }
        }

        // Insert data for the first teacher type and phone number once
        $stmt = $conn->prepare("INSERT INTO teachers (teacher_type, name, dob, phone, qualification, country, state, district, tehsil, address, center, userpassword) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error;
            exit;
        }

        $stmt->bind_param("ssssssssssis", $teacher_type, $name, $dob, $phone, $qualification, $country, $state, $district, $tehsil, $address, $center, $hash_pass);

        if (!$stmt->execute()) {
            echo "Error inserting record: " . $stmt->error;
            $stmt->close();
            exit;
        }

        // Only insert the record once
        break;
    }

    // Close the statement
    $stmt->close();

    // Redirect after successful insertion
    if ($_SESSION['isAdmin']) {
        header('Location: ../admin/dashboard.php?data=teacher'); 
    } else {
        header('Location: ../login/dashboard.php?data=teacher');
    }
    exit;
}

$conn->close();
?>
