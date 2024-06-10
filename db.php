<?php
// Database configuration
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'online_Exam';

// Create a database connection
$db = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check for connection errors
if ($db->connect_error) {
    die('Connection failed: ' . $db->connect_error);
}
?>
