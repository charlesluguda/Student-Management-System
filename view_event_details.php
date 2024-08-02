<?php
include 'session.php';
// Include the database connection file
include 'database.php';

// Check if eventID is provided
if(isset($_GET['eventID'])) {
    // Retrieve event details from the database
    $eventID = $_GET['eventID'];
    $event_query = "SELECT * FROM events WHERE eventID = '$eventID'";
    $event_result = $conn->query($event_query);

    if ($event_result->num_rows > 0) {
        // Fetch event details
        $event_details = $event_result->fetch_assoc();
    } else {
        // If event not found, redirect to view.php
        header("Location: view.php");
        exit();
    }
} else {
    // If eventID is not provided, redirect to view.php
    header("Location: view.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
@import url('https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap');
body {
    font-family: "Ubuntu", sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 95%; /* Set the container width to 90% of the viewport width */
    margin: 70px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
    position: relative; /* Add position relative to make the pseudo-element positioned relative to the h2 */
}

h2::after {
    content: ''; /* Empty content for the pseudo-element */
    display: block; /* Make it a block-level element */
    width: 100%; /* Make it full width */
    height: 3px; /* Set the height of the underline */
    background-color: #4CAF50; /* Color of the underline */
    position: absolute; /* Position it absolutely */
    bottom: -5px; /* Adjust the position to cover the bottom border of the h2 */
    left: 0; /* Align it to the left */
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}

th {
    background-color: #4f9354eb;
    color: white;
    
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

.back-to-dashboard {
    background-color: #4f9354eb;
    color: #fff;
    padding: 10px 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    text-decoration: none;
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 999;
}

.back-to-dashboard:hover {
    background-color: #45a049;
}
</style>
</head>
<body>
<a href="admin_dashboard.php" class="back-to-dashboard">Back to Dashboard</a>

<div class="container">
    <h2>Event Details</h2>
    <table>
        <tr>
            <th>Title</th>
            <td><?php echo $event_details['title']; ?></td>
        </tr>
        <tr>
            <th>Date</th>
            <td><?php echo $event_details['date']; ?></td>
        </tr>
        <tr>
            <th>Time</th>
            <td><?php echo $event_details['time']; ?></td>
        </tr>
        <tr>
            <th>Location</th>
            <td><?php echo $event_details['location']; ?></td>
        </tr>
        <tr>
            <th>Description</th>
            <td><?php echo $event_details['description']; ?></td>
        </tr>
    </table>
</div>
</body>
</html>



