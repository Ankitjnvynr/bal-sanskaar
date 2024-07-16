<?php
session_start();
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
    // Prepare data for insertion or update
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $father_name = $_POST['father-name'];
    $father_phone = $_POST['father-phone'];
    $father_dob = $_POST['father-dob'];
    $mother_name = $_POST['mother-name'];
    $mother_phone = $_POST['mother-phone'];
    $mother_dob = $_POST['mother-dob'];
    $country = isset($_POST['country']) ? $_POST['country'] : $_SESSION['country'];
    $state = isset($_POST['state']) ? $_POST['state'] : $_SESSION['state'];
    $district = isset($_POST['district']) ? $_POST['district'] : $_SESSION['district'];
    $tehsil = isset($_POST['tehsil']) ? $_POST['tehsil'] : $_SESSION['tehsil'];
    $center = isset($_POST['center']) ? $_POST['center'] : $_SESSION['userCenter'];

    if (isset($_POST['delete'])) {
        // SQL delete statement
        $sql_delete = "DELETE FROM students WHERE id = ?";
        $stmt = $conn->prepare($sql_delete);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Record deleted successfully";
            $redirect = ($_SESSION['userType'] == 'admin' && $_SESSION['insertType'] == 'student') ? '../admin/dashboard.php?data=student' : '../login/dashboard.php?data=student';
            header("location:$redirect");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    } elseif ($id) {
        // SQL update statement
        $sql_update = "UPDATE students SET name = ?, dob = ?, father_name = ?, father_phone = ?, father_dob = ?, mother_name = ?, mother_phone = ?, mother_dob = ?, country = ?, state = ?, district = ?, tehsil = ?, center = ? WHERE id = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("sssssssssssssi", $name, $dob, $father_name, $father_phone, $father_dob, $mother_name, $mother_phone, $mother_dob, $country, $state, $district, $tehsil, $center, $id);

        if ($stmt->execute()) {
            echo "Record updated successfully";
            $redirect = ($_SESSION['userType'] == 'admin' && $_SESSION['insertType'] == 'student') ? '../admin/dashboard.php?data=student' : '../login/dashboard.php?data=student';
            header("location:$redirect");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        // SQL insert statement
        $sql_insert = "INSERT INTO students (name, dob, father_name, father_phone, father_dob, mother_name, mother_phone, mother_dob, country, state, district, tehsil, center) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("sssssssssssss", $name, $dob, $father_name, $father_phone, $father_dob, $mother_name, $mother_phone, $mother_dob, $country, $state, $district, $tehsil, $center);

        if ($stmt->execute()) {
            echo "New record inserted successfully";
            $redirect = ($_SESSION['userType'] == 'admin' && $_SESSION['insertType'] == 'student') ? '../admin/dashboard.php?data=student' : '../login/dashboard.php?data=student';
            header("location:$redirect");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}

$conn->close();
?>
<script>
  // Load student data for update
  function loadStudentData() {
    const studentId = document.getElementById('student-id').value;
    if (studentId) {
      // Fetch the student data based on the student ID (this example uses a placeholder function)
      fetch(`../parts/get_student.php?id=${studentId}`)
        .then(response => response.json())
        .then(data => {
          document.getElementById('name').value = data.name;
          document.getElementById('dob').value = data.dob;
          document.getElementById('father-name').value = data.father_name;
          document.getElementById('father-phone').value = data.father_phone;
          document.getElementById('father-dob').value = data.father_dob;
          document.getElementById('mother-name').value = data.mother_name;
          document.getElementById('mother-phone').value = data.mother_phone;
          document.getElementById('mother-dob').value = data.mother_dob;
          document.getElementById('countrySelect').value = data.country;
          document.getElementById('stateSelect').value = data.state;
          document.getElementById('districtSelect').value = data.district;
          document.getElementById('tehsil').value = data.tehsil;
          document.getElementById('center').value = data.center;
        });
    } else {
      alert('Please enter a valid student ID to load data');
    }
  }

  // Delete student
  <?php
session_start();
require_once '../config/_db.php';

// if ($_SESSION['userType'] != 'admin') {
//     // Only allow admin to delete records
//     header('Location: ../login/dashboard.php');
//     exit;
// }

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if ($id > 0) {
        // SQL to delete record
        $sql_delete = "DELETE FROM students WHERE id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $id);

        if ($stmt_delete->execute()) {
            echo "Record deleted successfully";
            header('Location: ../admin/dashboard.php?data=student');
            exit;
        } else {
            echo "Error deleting record: " . $stmt_delete->error;
        }

        $stmt_delete->close();
    } else {
        echo "Invalid ID";
    }
} else {
    echo "ID not set";
}

$conn->close();
?>
