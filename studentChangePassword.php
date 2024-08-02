<?php
header('Content-Type: application/json');
include 'database.php'; // Ensure you have your database connection script included

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['studentID'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Log the inputs for debugging
    error_log("student_id: " . $student_id);
    error_log("current_password: " . $current_password);
    error_log("new_password: " . $new_password);
    error_log("confirm_password: " . $confirm_password);

    // Validate inputs
    if (empty($student_id) || empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $response['message'] = 'All fields are required.';
        echo json_encode($response);
        exit();
    }

    if ($new_password !== $confirm_password) {
        $response['message'] = 'New passwords do not match.';
        echo json_encode($response);
        exit();
    }

    // Check if the current password is correct
    $sql = "SELECT password FROM students WHERE studentID= ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        $response['message'] = 'Database error.';
        echo json_encode($response);
        exit();
    }
    $stmt->bind_param('i', $student_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (!$hashed_password || !password_verify($current_password, $hashed_password)) {
        $response['message'] = 'Current password is incorrect.';
        echo json_encode($response);
        exit();
    }

    // Update the password
    $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
    $sql = "UPDATE students SET password = ? WHERE studentID = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        $response['message'] = 'Database error.';
        echo json_encode($response);
        exit();
    }
    $stmt->bind_param('si', $new_hashed_password, $student_id);

    if ($stmt->execute()) {
        $response['message'] = 'Password changed successfully.';
    } else {
        $response['message'] = 'Error updating password.';
    }

    $stmt->close();
} else {
    // Log the request method for debugging
    error_log("Invalid request method: " . $_SERVER['REQUEST_METHOD']);
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
?>
