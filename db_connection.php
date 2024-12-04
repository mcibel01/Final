<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Require Composer's autoloader for MongoDB PHP library
require 'vendor/autoload.php';

// MongoDB connection string
$connectionString = "mongodb+srv://mariellecibella:<password>@cluster0.mongodb.net/ticketmaster?retryWrites=true&w=majority";

// Replace <password> with your actual MongoDB password
$connectionString = str_replace("<HBays2021>", "HBays2021", $connectionString);

try {
    // Create MongoDB client
    $client = new MongoDB\Client($connectionString);

    // Select the database
    $db = $client->ticketmaster;

    // Example collection
    $collection = $db->events;

    echo "Connected to MongoDB successfully!";
} catch (Exception $e) {
    die("Failed to connect to MongoDB: " . $e->getMessage());
}
?>
