<?php
    include './Includes/database.php'; // Assuming you have a file named 'database.php' for database connection

// Check if 'name' and 'suggestion' are set in the POST data
if(isset($_POST['name']) && isset($_POST['suggestion'])) {
    // Retrieve suggestion data from POST request
    $name = $_POST['name'];
    $suggestion = $_POST['suggestion'];

    // Validate and sanitize data (you can use filter_var(), mysqli_real_escape_string(), etc.)
    $name = htmlspecialchars($name);
    $suggestion = htmlspecialchars($suggestion);

    // Connect to MySQL database

    // Prepare and execute SQL statement
    $stmt = $conn->prepare("INSERT INTO suggestions (name, suggestion) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $suggestion);

    if ($stmt->execute()) {
        echo "Suggestion added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Error: 'name' and 'suggestion' fields are not set in POST data";
}
?>
