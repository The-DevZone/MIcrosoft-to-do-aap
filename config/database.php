<?php
session_start();
// Database connection settings
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'todolistdata';
// Create connection
$conn = new mysqli($host, $username, $password, $dbname);
// Check connection

if ($conn) {

} else {
    echo "connection not successfully";
}
?>