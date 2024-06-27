<?php
$hostname = 'localhost'; // or your host
$username = 'root';
$password = '';
$database_name = 'balsanskaar';

// Create connection
$conn = new mysqli($hostname, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Create database if it does not exist
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $database_name";
if ($conn->query($sql_create_db) === FALSE) {
  echo "Error creating database: " . $conn->error;
}
$conn->close();

// Connect to the created database
$conn = new mysqli($hostname, $username, $password, $database_name);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
