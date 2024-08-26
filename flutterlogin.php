<?php

include './Includes/database.php';

// Get username and password from Flutter
$username = $_POST['username'];
$password = $_POST['password'];

// Fetch user from database
$sql = "SELECT * FROM students WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // User found, check password
  $row = $result->fetch_assoc();
  $hashed_password = $row['password']; // Assuming the hashed password is stored in the 'password' column

  if (password_verify($password, $hashed_password)) {
    // Password matches, send student ID, class, and user details back to Flutter
    $studentID = $row['studentID'];
    $studentClass = $row['class'];
    $firstName = $row['firstname']; // Assuming these fields exist in your database
    $middleName = $row['middlename'];
    $lastName = $row['lastname'];
    $picture = $row['picture'];
    
    $response = array(
        'success' => true,
        'studentID' => $studentID,
        'studentClass' => $studentClass,
        'firstname' => $firstName,
        'middlename' => $middleName,
        'lastname' => $lastName,
        'picture' => $picture
    );
    echo json_encode($response);
  } else {
    // Password does not match
    echo json_encode(array('success' => false, 'message' => 'Incorrect password'));
  }
} else {
  // User not found
  echo json_encode(array('success' => false, 'message' => 'User not found'));
}

$conn->close();
?>
