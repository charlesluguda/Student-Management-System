<?php
include '../session.php';
// Include the database connection file
include '../Includes/database.php';
// Retrieve events from the database
$events_query = "SELECT * FROM events";
$events_result = $conn->query($events_query);

// Initialize serial number counter
$serial_number = 1;
?>

<?php
// Include the database connection file
include '../Includes/database.php';

// Retrieve events from the database
$events_query = "SELECT * FROM events";
$events_result = $conn->query($events_query);

// Initialize serial number counter
$serial_number = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Events</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="./css/view_event.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

</head>
<body>
<div class="back-card">
        <img src="images/logo.jpg" alt="Logo">
        <h2>All Events Organized</h2>
        <button onclick="window.location.href='admin_dashboard.php'">BACK</button>
    </div>
    <div class="container">
        <?php if ($events_result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>S/No</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Location</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each event and display its details in a row
                while($event_row = $events_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $serial_number . "</td>";
                    echo "<td>" . $event_row['title'] . "</td>";
                    echo "<td>" . $event_row['date'] . "</td>";
                    echo "<td>" . $event_row['time'] . "</td>";
                    echo "<td>" . $event_row['location'] . "</td>";
                    echo "<td>" . $event_row['description'] . "</td>";
                    echo "<td class='actions'>";
                    echo "<a href='edit_event.php?eventID=" . $event_row['eventID'] . "' class='edit-btn'><i class='fas fa-edit'></i>Edit</a>";
                    echo "<a href='delete_event.php?eventID=" . $event_row['eventID'] . "' class='delete-btn' onclick='return confirmDelete()'><i class='fas fa-trash-alt'></i>Delete</a>";
                    echo "<a href='view_event_details.php?eventID=" . $event_row['eventID'] . "' class='view-btn'><i class='fas fa-eye'></i>View</a>";

                    echo "</td>";
                    echo "</tr>";
                    // Increment the serial number counter
                    $serial_number++;
                }
                ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>No results found.</p>
        <?php endif; ?>
    </div>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this event?");
        }
    </script>
</body>
</html>

