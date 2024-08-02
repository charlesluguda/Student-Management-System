
<?php
session_start();
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gather form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL statement to fetch user data by email
    $checkEmailSQL = "SELECT * FROM teachers WHERE email = '$email'";

    // Execute the SQL statement
    $result = $conn->query($checkEmailSQL);

    // Check if the email exists
    if ($result->num_rows > 0) {
        // Fetch the user data
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['password'])) {
            $_SESSION['Email'] = $row['email'];
            $_SESSION['Username'] = $row['username'];
            $_SESSION['Profile'] = $row['picture'];
            $_SESSION['teacherID'] = $row['teacherID'];
            // Check the role
            if ($row['role'] == 'admin') {
                // Redirect to admin dashboard
                header("Location: Admin_dashboard.php");
                exit();
            } else {
                // Redirect to user dashboard
                header("Location: dashboard.php");
                exit();
            }
        } else {
            // Password is incorrect
            $error = "Incorrect password.";
        }
    } else {
        // Email does not exist
        $error = "Email not found.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Teacher Login</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Include Font Awesome -->
<link rel="stylesheet" href="./css/login.css">
<!-- ==================== BOOSTRAP ICONS ======================= -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<body>

<div class="container">
  <div class="header-container">
    <h2>Welcome Back</h2>
    <i class="bi bi-person-circle"></i>
    <p>Student Management System</p>
  </div>
  
  <form action="teacher_login.php" method="POST">
    <div class="form-group">
      <i class="fa fa-envelope"></i>
      <input type="email" id="email" name="email" placeholder="    Email" required> <!-- Added spaces before Email -->
    </div>
    <div class="form-group">
      <i class="fa fa-lock"></i>
      <input type="password" id="password" name="password" placeholder="    Password" required> <!-- Added spaces before Password -->
    </div>
    <div class="form-group">
      <input type="submit" value="Login" name="login" class="login">
    </div>
    <div class="form-group">
      <span class="error-message"><?php echo isset($error) ? $error : ''; ?></span>
    </div>
    <div class="forgot-password">
      <a href="Tpassword_reset.php">Forgot Password?</a>
    </div>
  </form>
</div>

</body>
</html>
