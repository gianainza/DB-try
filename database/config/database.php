<?php
/**
 * Database Connection Configuration
 * Event Management & Ticketing System
 */

// Update your Host constant to include the port
define('DB_HOST', 'localhost:3307'); 
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'event_ticketing_db');

// Change line 13 to use these constants
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if (!mysqli_query($conn, $sql)) {
    die("Error creating database: " . mysqli_error($conn));
}

// Select database
mysqli_select_db($conn, DB_NAME);

// Set charset
mysqli_set_charset($conn, "utf8mb4");
?>