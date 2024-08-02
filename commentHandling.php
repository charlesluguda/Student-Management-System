<?php
include 'database.php'; // Include your database connection file
require 'vendor/autoload.php'; // Include Composer's autoloader for PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    $studentID = $_POST['studentID'];
    $comment = $_POST['comment_text'];

    // Prepare the SQL query to insert the comment into the database
    $query = "INSERT INTO comments (studentID, comment) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $studentID, $comment);

    // Execute the query to insert the comment
    if ($stmt->execute()) {
        // Comment insertion successful

        // Send email notification to the student
        $studentEmailQuery = "SELECT email, firstName, middleName, lastName FROM students WHERE studentID = ?";
        $stmtEmail = $conn->prepare($studentEmailQuery);
        $stmtEmail->bind_param("i", $studentID);
        $stmtEmail->execute();
        $resultEmail = $stmtEmail->get_result();

        if ($resultEmail->num_rows > 0) {
            $rowEmail = $resultEmail->fetch_assoc();
            $studentEmail = $rowEmail['email'];
            $firstName = $rowEmail['firstName'];
            $middleName = $rowEmail['middleName'];
            $lastName = $rowEmail['lastName'];

            // Use PHPMailer to send the email
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
                $mail->setFrom('deogratiusshayo99@gmail.com', 'School-App Comment'); // Replace with your email and name
                $mail->addAddress($studentEmail); // Email of recipient
                $mail->isHTML(true);
                $mail->Subject = 'New Comment Notification';
                $mail->Body = 'Dear ' . $middleName . ' ' . $lastName . ',<br><br>A new comment has been added to your profile:<br><br>Comment: ' . $comment . '<br>Login to the app to view it.<br><br>Regards,<br>Your School';

                // Send the email
                $mail->send();

                // Show a JavaScript alert after successful email sending
                echo '<script>alert("Comment added and email sent successfully!"); window.location.href = "comments.php";</script>';
            } catch (Exception $e) {
                // Email sending failed
                echo 'Email notification failed: ' . $mail->ErrorInfo;
            }
        }
        $stmtEmail->close();
    } else {
        // Comment insertion failed
        echo 'Comment insertion failed.';
    }
    $stmt->close();
} else {
    // Invalid request method or comment not set
    echo 'Invalid request or comment not provided.';
}
?>
