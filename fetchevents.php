<?php
// Include the MongoDB connection file
require 'db_connection.php';

// Query the events collection
try {
    $events = $collection->find(); // Fetch all events

    // Loop through and display events
    foreach ($events as $event) {
        echo "<p>Event Name: " . $event['name'] . "</p>";
    }
} catch (Exception $e) {
    die("Error fetching events: " . $e->getMessage());
}
?>
