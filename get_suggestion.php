<?php
include 'database.php'; // Assuming you have a file named 'database.php' for database connection

if (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT suggestion FROM suggestions WHERE suggestionID = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $stmt->bind_result($suggestionText);
    if ($stmt->fetch()) {
        echo $suggestionText;
    } else {
        echo "No suggestion found.";
    }
    $stmt->close();
}

$conn->close();
?>
