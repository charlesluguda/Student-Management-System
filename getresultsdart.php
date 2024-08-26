<?php

include './Includes/database.php';

// Receive student ID and class from Flutter
$studentID = $_POST['studentID'];
$studentClass = $_POST['studentClass'];

// Select the appropriate table based on the class
$tableName = 'std' . $studentClass . '_results';

// Query the database to fetch results
$sql = "SELECT * FROM $tableName WHERE studentID = $studentID";
$result = $conn->query($sql);

$response = array();

if ($result->num_rows > 0) {
    // Initialize an array to store multiple rows of results
    $resultsArray = array();
    
    // Fetch and format each row of results
    while($row = $result->fetch_assoc()) {
        $resultItem = array(
            'fullname' => $row['fullname'],
            'kiswahili' => $row['kiswahili'],
            'history' => $row['history'],
            'science' => $row['science'],
            'english' => $row['english'],
            'totalmarks' => $row['total_marks'],
            'grade' => $row['grade'],
            'average' => $row['average'],
            'position' => $row['position'],
            'semester' => $row['semester'],
            'month' => $row['month']
        );
        // Push each row to the results array
        $resultsArray[] = $resultItem;
    }
    
    // Add the results array to the response
    $response['results'] = $resultsArray;
} else {
    $response['error'] = 'No results uploaded yet';
}

// Encode and send the response
echo json_encode($response);

$conn->close();
?>
