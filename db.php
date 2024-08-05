<?php
include 'config/_db.php';

try {


    // SQL to create table
    $sql = "CREATE TABLE IF NOT EXISTS centers (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        country VARCHAR(255) NOT NULL,
        state VARCHAR(255) NOT NULL,
        district VARCHAR(255) NOT NULL,
        tehsil VARCHAR(255) NOT NULL,
        center VARCHAR(255) NOT NULL,
        UNIQUE KEY unique_location (country, state, district, tehsil, center)
    )";

    $sql2 = "ALTER TABLE teachers ADD userpassword VARCHAR(500)";
    $add_qualification = "ALTER TABLE teachers ADD qualification VARCHAR(80) AFTER phone";
    $add_pic = "ALTER TABLE teachers ADD pic VARCHAR(80) AFTER phone";
    $add_dt = "ALTER TABLE teachers ADD COLUMN dt TIMESTAMP DEFAULT CURRENT_TIMESTAMP";

    $add_address = "ALTER TABLE students ADD address TEXT AFTER tehsil,ADD rollno VARCHAR(100) AFTER id ";

    // Execute the query



    // Use exec() because no results are returned
    $conn->query($sql);
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
try {
    if ($conn->query($sql2) === TRUE) {
        echo "Column added successfully";
    } else {
        echo "Error adding column: " . $conn->error;
    }
} catch (\Throwable $th) {
    echo $th;
}
// Close connection
try {
    if ($conn->query($add_qualification) === TRUE) {
        echo "Column qualification added successfully";
    } else {
        echo "Error adding column: " . $conn->error;
    }
} catch (\Throwable $th) {
    echo $th;
}
try {
    if ($conn->query($add_address) === TRUE) {
        echo "Column address added successfully";
    } else {
        echo "Error adding column: " . $conn->error;
    }
} catch (\Throwable $th) {
    echo $th;
}
try {
    if ($conn->query($add_pic) === TRUE) {
        echo "Column pic added successfully";
    } else {
        echo "Error adding column: " . $conn->error;
    }
} catch (\Throwable $th) {
    echo $th;
}
try {
    if ($conn->query($add_dt) === TRUE) {
        echo "Column join date as dt added successfully";
    } else {
        echo "Error join date as dt column: " . $conn->error;
    }
} catch (\Throwable $th) {
    echo $th;
}
$conn = null;