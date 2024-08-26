<?php
include './Includes/database.php'; // Include your database connection file
require 'vendor/autoload.php'; // Include Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to generate a random password
function generateRandomPassword($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

$mail = new PHPMailer(true); // Enable exceptions
$response = array();

try {
    //Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP host
    $mail->SMTPAuth = true;
    $mail->Username = 'deogratiusshayo99@gmail.com'; // Replace with your email
    $mail->Password = 'tcdc iker sjpk dzki'; // Replace with your App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
    $mail->Port = 587; // TCP port to connect to

    // Enable verbose debug output
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = function($str, $level) {
        // Capture the debug output
        global $response;
        $response['debug'][] = $str;
    };

    // Get the email address from the Flutter app
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    if (!empty($email)) {
        // Check if email exists in the students table
        $checkEmailQuery = "SELECT * FROM students WHERE email = '$email'";
        $result = $conn->query($checkEmailQuery);

        if ($result->num_rows > 0) {
            // Email exists, proceed with password reset
            // Generate a random password
            $new_password = generateRandomPassword();

            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update hashed password in database
            $sql = "UPDATE students SET password = '$hashed_password' WHERE email = '$email'";
            if ($conn->query($sql) === TRUE) {
                // Send email with new password to user
                $mail->setFrom('deogratiusshayo99@gmail.com', 'School'); // Replace with your email and name
                $mail->addAddress($email); // Email of recipient
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset';
                $mail->Body = 'Dear, Your new password is: <b style="color: red;">' . $new_password . '</b>. Use it to login and you can change it later. <br><br>Regards,<br>Your School';



                // Send the email and check for errors
                if ($mail->send()) {
                    $response['message'] = 'Password reset successful. Check your email for the new password.';
                } else {
                    $response['message'] = 'Password reset successful but email could not be sent. Please contact support.';
                    $response['mail_error'] = $mail->ErrorInfo;
                }
            } else {
                $response['message'] = 'Password reset failed. Please try again.';
                $response['sql_error'] = $conn->error;
            }
        } else {
            $response['message'] = 'Email not found in the database.';
        }
    } else {
        $response['message'] = 'Invalid email provided.';
    }

    $conn->close(); // Close the database connection
} catch (Exception $e) {
    $response['message'] = 'Password reset failed. Please try again.';
    $response['error'] = $e->getMessage();
}

// Make sure no other output is sent before this
header('Content-Type: application/json');
echo json_encode($response);
?>
