<?php

include 'database.php';

// Check if the required POST parameters are set
if (isset($_POST['studentID'])) {
    // Receive student ID from Flutter
    $studentID = $_POST['studentID'];

    // Prepare the SQL query with parameters to prevent SQL injection
    $sql = "SELECT * FROM comments WHERE studentID = ?";

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $studentID);

    // Execute the query
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Initialize the response array
    $response = array();

    if ($result->num_rows > 0) {
        // Initialize an array to store multiple rows of comment records
        $commentArray = array();

        // Fetch and format each row of comment records
        while ($row = $result->fetch_assoc()) {
            $commentItem = array(
                'comment' => $row['comment'],
                'dateCreated' => $row['dateCreated'],
            );
            // Push each row to the comment array
            $commentArray[] = $commentItem;
        }

        // Add the comment array to the response
        $response['comments'] = $commentArray;
    } else {
        $response['error'] = 'No comment records found';
    }

    // Encode and send the response
    echo json_encode($response);

    // Close the statement
    $stmt->close();
} else {
    // If the required parameters are not set, return an error response
    $response['error'] = 'Missing parameter (studentID)';
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>
