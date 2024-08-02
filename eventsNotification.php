<!DOCTYPE html>
<html>
<head>
    <title>Add Event</title>
</head>
<body>
    <h1>Add Event</h1>
    <form action="add_event.php" method="post">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required></textarea><br>
        <label for="date">Date:</label><br>
        <input type="datetime-local" id="date" name="date" required><br><br>
        <input type="submit" value="Add Event">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        include 'database.php';
        
 // Get POST parameters
 $title = $_POST['title'];
 $description = $_POST['description'];
 $date = $_POST['date'];

 // Validate input
 if (empty($title) || empty($description) || empty($date)) {
     echo "<p style='color: red;'>All fields are required.</p>";
 } else {
     // Prepare and bind
     $stmt = $conn->prepare("INSERT INTO events (title, description, date) VALUES (?, ?, ?)");
     $stmt->bind_param("sss", $title, $description, $date);

     if ($stmt->execute()) {
         echo "<p style='color: green;'>Event added successfully.</p>";
     } else {
         echo "<p style='color: red;'>Error adding event: " . $stmt->error . "</p>";
     }

     $stmt->close();
 }

 $conn->close();
}
?>
</body>
</html>