<?php

// Database configuration
$host = "localhost"; // e.g., localhost
$username = "root";
$password = "";
$database = "login_register";

// Create a database connection
$link = new mysqli($host, $username, $password, $database);

// Check the connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

?>
