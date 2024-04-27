<?php
// Database connection parameters
$servername = "localhost/XE"; // Change this to your database server hostname and service name
$username = "SYSTEM";
$password = "2024DIZON"; // Change this to your database password

// Create connection
$conn = oci_connect($username, $password, $servername);

// Check connection
if (!$conn) {
    $error = oci_error();
    die("Connection failed: " . $error['message']);
}
?>
