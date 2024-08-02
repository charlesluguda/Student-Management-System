<?php

include 'database.php';

// Check if the required POST parameters are set
if (isset($_POST['studentID']) && isset($_POST['studentClass'])) {
    // Receive student ID and class from Flutter
    $studentID = $_POST['studentID'];
    $studentClass = $_POST['studentClass'];

    // Select the appropriate table based on the class
    $tableName = 'attendance' . $studentClass;

    // Prepare the SQL query with parameters to prevent SQL injection
    $sql = "SELECT * FROM $tableName WHERE studentID = ?";

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
        // Initialize an array to store multiple rows of attendance records
        $attendanceArray = array();

        // Fetch and format each row of attendance records
        while ($row = $result->fetch_assoc()) {
            $attendanceItem = array(
                'uploaded_date' => $row['uploaded_date'],
                'attendance_status' => $row['attendance_status'],
                
            );
            // Push each row to the attendance array
            $attendanceArray[] = $attendanceItem;
        }

        // Add the attendance array to the response
        $response['attendance'] = $attendanceArray;
    } else {
        $response['error'] = 'No attendance records found';
    }

    // Encode and send the response
    echo json_encode($response);

    // Close the statement
    $stmt->close();
} else {
    // If the required parameters are not set, return an error response
    $response['error'] = 'Missing parameters (studentID or studentClass)';
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>
