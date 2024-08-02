<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Password Reset</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
  }
  
  .container {
    max-width: 500px;
    margin: 50px auto;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    border: 1px solid #ccc;
  }
  
  h2 {
    text-align: center;
    margin-bottom: 20px;
  }
  
  .form-group {
    margin-bottom: 20px;
  }
  
  input[type="email"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
  }

  input[type="submit"] {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    background-color: #007bff;
    color: #ffffff;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  input[type="submit"]:hover {
    background-color: #0056b3;
  }

  .error-message {
    color: red;
    font-size: 14px;
  }
</style>
</head>
<body>

<div class="container">
  <h2>Forgot Password</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <div class="form-group">
      <input type="email" id="email" name="email" placeholder="Enter your email" required>
    </div>
    <div class="form-group">
      <input type="submit" value="Reset Password" name="reset">
    </div>
    <div class="form-group">
      <span class="error-message"><?php echo isset($error) ? $error : ''; ?></span>
    </div>
  </form>
</div>

<?php
session_start();
include 'database.php'; // Include your database connection file
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'deogratiusshayo99@gmail.com'; // Replace with your email
        $mail->Password = 'tcdc iker sjpk dzki'; // Replace with your App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port = 587; // TCP port to connect to

        // Get the email address from the form submission
        $email = isset($_POST['email']) ? $_POST['email'] : '';

        if (!empty($email)) {
            // Check if email exists in the teachers table
            $checkEmailQuery = "SELECT * FROM teachers WHERE email = '$email'";
            $result = $conn->query($checkEmailQuery);

            if ($result->num_rows > 0) {
                // Email exists, proceed with password reset
                // Generate a random password
                $new_password = generateRandomPassword();

                // Hash the new password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update hashed password in database
                $sql = "UPDATE teachers SET password = '$hashed_password' WHERE email = '$email'";
                if ($conn->query($sql) === TRUE) {
                    // Send email with new password to user
                    $mail->setFrom('deogratiusshayo99@gmail.com', 'School-Password Reset'); // Replace with your email and name
                    $mail->addAddress($email); // Email of recipient
                    $mail->isHTML(true);
                    $mail->Subject = 'Password Reset';
                    $mail->Body = 'Dear , Your new password is: ' . $new_password. 'use it to login and your can change it later. <br><br>Regards,<br>Your School';

                    // Send the email and check for errors
                    if ($mail->send()) {
                        // Password reset successful, redirect after 5 seconds
                        header("refresh:5;url=teacher_login.php");
                        echo 'Password reset successful. Check your email for the new password.';
                        exit();
                    } else {
                        echo 'Password reset successful but email could not be sent. Please contact support.';
                        echo 'Error: ' . $mail->ErrorInfo;
                    }
                } else {
                    echo 'Password reset failed. Please try again.';
                    echo 'SQL Error: ' . $conn->error;
                }
            } else {
                echo 'Email not found in the database.';
            }
        } else {
            echo 'Invalid email provided.';
        }

        $conn->close(); // Close the database connection
    } catch (Exception $e) {
        echo 'Password reset failed. Please try again.';
        echo 'Error: ' . $e->getMessage();
    }
}
?>
</body>
</html>
