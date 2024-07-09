<?php
include 'config/_db.php';

try
{


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

    // Use exec() because no results are returned
    $conn->query($sql);
    echo "Table locations created successfully";
} catch (PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}

// Close connection
$conn = null;
?>