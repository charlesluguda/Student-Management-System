<?php
// Include the database connection file
include 'database.php';

// Check if event ID is provided
if(isset($_GET['eventID'])) {
    $event_id = $_GET['eventID'];

    // Retrieve form data
    $title = $_POST['title'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    // Update the event in the database
    $update_event_query = "UPDATE events SET title='$title', date='$date', time='$time', location='$location', description='$description' WHERE eventID = $event_id";
    if ($conn->query($update_event_query) === TRUE) {
        // Redirect to a success page or display a success message
        header("refresh:2; url=view_event.php");
        exit();
    } else {
        // Handle errors if any
        echo "Error: " . $update_event_query . "<br>" . $conn->error;
    }
}
?>
