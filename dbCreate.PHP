<?php
// Include files
require_once("dBCred.PHP");
require_once("dbFunctions.php");
////////////////////////////////


// Progromatic way to create and test your local database.
// When the index page is accessed this code checks for a capstone db, drops it and 
// recreates it with this code.
// This is only for testing and and example of how we will query the db.
// If we are only using dummy data we can leave it and hard code the db so it refreshes to 
// a default every time. 
$sql = "DROP DATABASE " . DATABASE_NAME;
runQuery($sql, "DROP " . DATABASE_NAME, true);// function from "dbFunctions.php" 

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS " . DATABASE_NAME;

if ($conn->query($sql) === TRUE) {
    echo "The database " . DATABASE_NAME . " exists or was created successfully!<br />";
} else {
    echo "Error creating database " . DATABASE_NAME . ": " . $conn->error;
    echo "<br />";
}

// Select the database
$conn->select_db(DATABASE_NAME);

// Quick snippet I made to test my DB connection.
$sql = "CREATE TABLE IF NOT EXISTS category (
    category_id     INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    category_name   VARCHAR(25) NOT NULL
    )";
runQuery($sql, "category:item", false);

 


?>
