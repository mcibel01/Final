$(document).ready(function() {
    const apiKey = 'your_api_key_here'; // Replace with your API key
    const apiUrl = `https://app.ticketmaster.com/discovery/v2/events.json?size=50&apikey=${apiKey}`;
    let allEvents = []; // To store fetched events

    // Fetch events from the API
    $.ajax({
        type: "GET",
        url: apiUrl,
        async: true,
        dataType: "json",
        success: function(json) {
            if (json._embedded && json._embedded.events) {
                allEvents = json._embedded.events;
                populateGenres(allEvents);
                displayEvents(allEvents); // Initially display all events
            } else {
                $('#event-data').html('<p>No events found.</p>');
            }
        },
        error: function(xhr, status, err) {
            console.error('Error fetching events:', err);
            $('#event-data').html('<p>Failed to fetch events. Please try again later.</p>');
        }
    });

    // Populate the genres dropdown
    function populateGenres(events) {
        const genres = new Set();
        events.forEach(event => {
            if (event.classifications && event.classifications[0].genre) {
                genres.add(event.classifications[0].genre.name);
            }
        });

        genres.forEach(genre => {
            $('#genre-select').append(`<option value="${genre}">${genre}</option>`);
        });
    }

    // Display filtered events
    function displayEvents(events) {
        if (events.length === 0) {
            $('#event-data').html('<p>No events available for the selected genre.</p>');
            return;
        }

        let html = '<ul>';
        events.forEach(event => {
            html += `
                <li>
                    <h2>${event.name}</h2>
                    <p>Date: ${event.dates.start.localDate}</p>
                    <p>Location: ${event._embedded.venues[0].name}</p>
                    <p>Genre: ${event.classifications[0].genre.name}</p>
                </li>
            `;
        });
        html += '</ul>';
        $('#event-data').html(html);
    }

    // Handle genre selection change
    $('#genre-select').on('change', function() {
        const selectedGenre = $(this).val();
        const filteredEvents = selectedGenre
            ? allEvents.filter(event => event.classifications &&
                                         event.classifications[0].genre &&
                                         event.classifications[0].genre.name === selectedGenre)
            : allEvents;
        displayEvents(filteredEvents);
    });
});
