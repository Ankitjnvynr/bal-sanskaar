<?php
// User's password
$password = '7579079078';

// Hash the password using the default algorithm (currently BCRYPT)
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Store $hashedPassword in your database
echo $hashedPassword;
