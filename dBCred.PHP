<?php
   
// Set up connection constants
// Using default username and password for AMPPS  
define("SERVER_NAME","localhost");
define("DBF_USER_NAME", "root");
define("DBF_PASSWORD", "mysql");
define("DATABASE_NAME", "mydatabase");

// Create connection object
$conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
else
?>

 