<?php
// Include the database connection file
include 'session.php';
include 'database.php';
require 'vendor/autoload.php'; // Include Composer's autoloader for PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the form is submitted
if(isset($_POST['submit'])) {
    // Retrieve form data
    $title = $_POST['title']; 
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    // Insert the event into the database
    $insert_event_query = "INSERT INTO events (title, date, time, location, description) VALUES ('$title', '$date', '$time', '$location', '$description')";
    if ($conn->query($insert_event_query) === TRUE) {
        // Send email notifications
        sendEmails($title, $date, $time, $location, $description);
        
        // Redirect to a success page or display a success message
        header("refresh:2; url=view_event.php");
        exit();
    } else {
        // Handle errors if any
        echo "Error: " . $insert_event_query . "<br>" . $conn->error;
    }
}

function sendEmails($title, $date, $time, $location, $description) {
    global $conn;

    // Get teachers' data (including names and emails)
    $teacherDataQuery = "SELECT firstName, lastName, email FROM teachers";
    $teacherResult = $conn->query($teacherDataQuery);
    $teacherEmails = array();
    if ($teacherResult->num_rows > 0) {
        while ($row = $teacherResult->fetch_assoc()) {
            $teacherName = $row['firstName'] . ' ' . $row['lastName'];
            $teacherEmail = $row['email'];
            $teacherEmails[] = array('name' => $teacherName, 'email' => $teacherEmail);
        }
    }

    // Get students' data (including names and emails)
    $studentDataQuery = "SELECT firstName, lastName, email FROM students";
    $studentResult = $conn->query($studentDataQuery);
    $studentEmails = array();
    if ($studentResult->num_rows > 0) {
        while ($row = $studentResult->fetch_assoc()) {
            $studentName = $row['firstName'] . ' ' . $row['lastName'];
            $studentEmail = $row['email'];
            $studentEmails[] = array('name' => $studentName, 'email' => $studentEmail);
        }
    }

    // Combine teacher and student data
    $allEmails = array_merge($teacherEmails, $studentEmails);

    // Send emails
    $mail = new PHPMailer(true); // Enable exceptions
    try {
        // Configure SMTP settings
        $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP host
    $mail->SMTPAuth = true;
    $mail->Username = 'deogratiusshayo99@gmail.com'; // Replace with your email
    $mail->Password = 'tcdc iker sjpk dzki'; // Replace with your App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
    $mail->Port = 587; // TCP port to connect to

        // Email content
        $mail->setFrom('deogratiusshayo99@gmail.com', 'School Events'); // Replace with your email and name
        foreach ($allEmails as $recipient) {
            $name = $recipient['name'];
            $email = $recipient['email'];
            $mail->addAddress($email); // Email of recipient
            $mail->isHTML(true);
            $mail->Subject = 'New Event Notification';
            $mail->Body = "Dear $name,<br><br>A new event has been added:<br><br>Title: $title<br>Date: $date<br>Time: $time<br>Location: $location<br>Description: $description<br><br>Regards,<br>Your School";
            
            // Send the email
            $mail->send();
            
            // Clear addresses for next iteration
            $mail->clearAddresses();
        }
    } catch (Exception $e) {
        // Email sending failed
        echo 'Email notification failed: ' . $mail->ErrorInfo;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <link rel="stylesheet" href="./css/add_event.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet"></div>
</head>
<body>
<div class="back-card">
    <img src="images/logo.jpg" alt="Logo">
    <h2>Add and Post Upcoming Events</h2>

    <button onclick="window.location.href='admin_dashboard.php'">BACK</button>
</div>
    <div class="container">
       
        <form action="add_event.php" method="post">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>
            
            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required>
            
            <label for="location">Location:</label>
            <input type="text" id="location" name="location">
            
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4"></textarea>
            
            <input type="submit" name="submit" value="Submit">
        </form>
    </div>
</body>
</html>

