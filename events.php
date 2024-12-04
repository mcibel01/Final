<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Header Section -->
    <div id="header-container"></div>

    <main>
        <h1>Upcoming Events</h1>
        <div class="event-list">
            <?php
            require 'vendor/autoload.php'; // Include MongoDB PHP library

            // Connect to MongoDB
            try {
                $client = new MongoDB\Client("mongodb://localhost:27017");
                $collection = $client->myDatabase->events;

                // Query events
                $events = $collection->find();

                // Display events
                foreach ($events as $event) {
                    echo "<div class='event'>";
                    echo "<h2>" . htmlspecialchars($event['name']) . "</h2>";
                    echo "<p>Date: " . htmlspecialchars($event['dates']['start']['localDate']) . "</p>";
                    echo "<p>Location: " . htmlspecialchars($event['_embedded']['venues'][0]['name']) . "</p>";
                    echo "</div>";
                }
            } catch (Exception $e) {
                echo "<p class='error'>Unable to connect to the database. Please try again later.</p>";
            }
            ?>
        </div>
    </main>

    <!-- Footer Section -->
    <div id="footer-container"></div>

    <!-- Include Header and Footer -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            fetch('header.html')
                .then(response => response.text())
                .then(data => document.getElementById('header-container').innerHTML = data);

            fetch('footer.html')
                .then(response => response.text())
                .then(data => document.getElementById('footer-container').innerHTML = data);
        });
    </script>
</body>
</html>
