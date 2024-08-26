<?php
include 'session.php'; // Include the session file for session management
include './Includes/database.php';// Include the database connection file

// Initialize error and success messages
$error = "";
$success_message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gather form data
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    // Validate form inputs
    if (empty($oldPassword) || empty($newPassword) || empty($confirmNewPassword)) {
        $error = "All fields are required.";
    } elseif ($newPassword !== $confirmNewPassword) {
        $error = "New password and confirm password do not match.";
    } else {
        // Check if the old password matches the one in the database
        $teacherID = $_SESSION['teacherID']; // Assuming user ID is stored in the session
        $checkPasswordSQL = "SELECT password FROM teachers WHERE teacherID = '$teacherID'";
        $result = $conn->query($checkPasswordSQL);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];

            if (password_verify($oldPassword, $hashedPassword)) {
                // Hash the new password
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the password in the database
                $updatePasswordSQL = "UPDATE teachers SET password = '$hashedNewPassword' WHERE teacherID= '$teacherID'";
                if ($conn->query($updatePasswordSQL) === TRUE) {
                    header("refresh:1;url=teacher_login.php");
                } else {
                    $error = "Error updating password: " . $conn->error;
                }
            } else {
                $error = "Old password is incorrect.";
            }
        } else {
            $error = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: "Ubuntu", sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .back-card {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            background-color: #4f9354eb;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 10px;
            box-sizing: border-box;
            z-index: 1000;
        }

        .back-card img {
            width: 50px;
            border-radius: 50px;
            margin-left: 10px;
        }

        .back-card h2 {
            text-align: center;
            color: #ffffff;
            font-size: 30px;
            margin: 0;
            flex-grow: 1;
        }

        .back-card button {
            background-color: #fff;
            color: #000;
            border: none;
            height: 40px;
            border-radius: 8px;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .container {
            width: 80%;
            margin: 150px auto;
            justify-content: center;
            align-items: center;
            display: flex;
            flex-direction: column;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 5px 7px 33px 1px rgba(0,0,0,0.57);
            border: 1px solid #ccc;
            padding: 20px;
        }

        
        .card-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        input[type="password"] {
            width: 500px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: #f5f5f5;
            padding-left: 35px;
            transition: border-color 0.3s ease;
        }

        input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
        }

        .fa {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 10px;
            color: #999999;
        }

        .error-message,
        .success-message {
            display: block;
            margin-top: 5px;
            font-size: 14px;
        }

        .error-message {
            color: red;
        }

        .success-message {
            color: green;
        }

        input[type="submit"] {
            width: 500px;
            padding: 10px;
            margin: auto;
            border: none;
            border-radius: 5px;
            background-color:#5fa161;
            color: #ffffff;
            cursor: pointer;
            font-size: 15px;
            font-weight : 600;
            transition: background-color 0.3s ease;
        }
    
        input[type="password"]::placeholder,
        
        select::placeholder {
            font-size: 15px; /* Adjust the font size as needed */
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

</head>
<body>
    <div class="back-card">
        <img src="images/logo.jpg" alt="Logo">
        <h2>Change Password</h2>
        <button onclick="window.location.href='admin_dashboard.php'">BACK</button>
    </div>

    <div class="container">
      

        <div class="card-body">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="form-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" id="oldPassword" name="oldPassword" placeholder="Old Password" required>
                </div>
                <div class="form-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" id="newPassword" name="newPassword" placeholder="New Password" required>
                </div>
                <div class="form-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" id="confirmNewPassword" name="confirmNewPassword" placeholder="Confirm New Password" required>
                    <span class="error-message"><?php echo $error; ?></span>
                    <span class="success-message"><?php echo $success_message; ?></span>
                </div>

                <input type="submit" value="Change Password" name="changePassword">
            </form>
        </div>
    </div>
</body>
</html>
