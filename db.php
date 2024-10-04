<?php
include 'config/_db.php';

try {
    // SQL to create table if not exists
    $sql = "CREATE TABLE IF NOT EXISTS centers (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        country VARCHAR(255) NOT NULL,
        state VARCHAR(255) NOT NULL,
        district VARCHAR(255) NOT NULL,
        tehsil VARCHAR(255) NOT NULL,
        center VARCHAR(255) NOT NULL,
        UNIQUE KEY unique_location (country, state, district, tehsil, center)
    )";
    $conn->query($sql);
    echo "Table 'centers' created successfully or already exists.<br>";

    // Adding columns only if they don't exist
    $columns_check = $conn->query("SHOW COLUMNS FROM students LIKE 'register_option'");
    if ($columns_check->num_rows == 0) {
        $sql = "ALTER TABLE students ADD COLUMN register_option VARCHAR(255) DEFAULT NULL";
        if ($conn->query($sql) === TRUE) {
            echo "Column 'register_option' added successfully.<br>";
        }
    } else {
        echo "Column 'register_option' already exists.<br>";
    }

    // Updating the new column
    $sql_update = "UPDATE students SET register_option = 'default_value'";
    if ($conn->query($sql_update) === TRUE) {
        echo "Column 'register_option' updated successfully.<br>";
    } else {
        echo "Error updating column: " . $conn->error . "<br>";
    }

    // Adding other columns with similar checks
    $sql2 = "ALTER TABLE teachers ADD userpassword VARCHAR(500)";
    $add_qualification = "ALTER TABLE teachers ADD qualification VARCHAR(80) AFTER phone";
    $add_pic = "ALTER TABLE teachers ADD pic VARCHAR(80) AFTER phone";
    $add_dt = "ALTER TABLE teachers ADD COLUMN dt TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
    $add_address = "ALTER TABLE students ADD address TEXT AFTER tehsil, ADD rollno VARCHAR(100) AFTER id";
    $add_address_teacher = "ALTER TABLE teachers ADD address TEXT AFTER tehsil";

    // Function to add column if not exists
    function addColumnIfNotExists($conn, $table, $column, $sql) {
        $columns_check = $conn->query("SHOW COLUMNS FROM $table LIKE '$column'");
        if ($columns_check->num_rows == 0) {
            if ($conn->query($sql) === TRUE) {
                echo "Column '$column' added successfully.<br>";
            } else {
                echo "Error adding column '$column': " . $conn->error . "<br>";
            }
        } else {
            echo "Column '$column' already exists.<br>";
        }
    }

    // Add columns with checks
    addColumnIfNotExists($conn, 'teachers', 'userpassword', $sql2);
    addColumnIfNotExists($conn, 'teachers', 'qualification', $add_qualification);
    addColumnIfNotExists($conn, 'teachers', 'pic', $add_pic);
    addColumnIfNotExists($conn, 'teachers', 'dt', $add_dt);
    addColumnIfNotExists($conn, 'students', 'address', $add_address);
    addColumnIfNotExists($conn, 'teachers', 'address', $add_address_teacher);

    // SQL query to create the syllabus table
    $sql = "CREATE TABLE IF NOT EXISTS syllabus (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        subtitle TEXT NOT NULL,
        file_name VARCHAR(255) NOT NULL,
        dt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    if ($conn->query($sql) === TRUE) {
        echo "Table 'syllabus' created successfully.<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn->close();
?>
