<?php
include './Includes/database.php';
// Fetch latest events
$sql = "SELECT id, title, description, date, created_at FROM events WHERE created_at > NOW() - INTERVAL 5 MINUTE";
$result = $conn->query($sql);

$events = array();
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($events);
?>
