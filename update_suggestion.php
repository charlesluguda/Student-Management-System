<?php
include 'database.php'; // Assuming you have a file named 'database.php' for database connection

if (isset($_GET['id'])) {
    $stmt = $conn->prepare("UPDATE suggestions SET is_read = 'Read' WHERE suggestionID = ?");
    $stmt->bind_param("i", $_GET['id']);
    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error updating suggestion status.";
    }
    $stmt->close();
}

$conn->close();
?>
