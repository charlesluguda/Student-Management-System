<?php
// Include the database connection file
include 'database.php';

// Check if event ID is provided
if(isset($_GET['eventID'])) {
    $event_id = $_GET['eventID'];

    // Delete the event from the database
    $delete_event_query = "DELETE FROM events WHERE eventID = $event_id";
    if ($conn->query($delete_event_query) === TRUE) {
        // Redirect to a success page or display a success message
        header("refresh:1; url=view_event.php");
        exit();
    } else {
        // Handle errors if any
        echo "Error: " . $delete_event_query . "<br>" . $conn->error;
    }
} else {
    // If event ID is not provided, redirect to an error page or display an error message
    header("Location: error.php");
    exit();
}
?>
