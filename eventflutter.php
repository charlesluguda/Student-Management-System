<?php
include 'database.php';

header('Content-Type: application/json');

// Fetch events from the database
$query = "SELECT * FROM events";
$result = $conn->query($query);

$events = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

echo json_encode($events);

$conn->close();
?>
