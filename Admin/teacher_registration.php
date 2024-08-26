<?php
include 'session.php';
// Include the database connection file
include './Includes/database.php';

// Initialize error variable
$error = "";
$success_message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gather form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $class = $_POST['class'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        // Prepare SQL statement to check if the email already exists
        $checkEmailSQL = "SELECT * FROM teachers WHERE email = '$email'";

        // Execute the SQL statement
        $result = $conn->query($checkEmailSQL);

        // Check if the email already exists
        if ($result->num_rows > 0) {
            $error = "Email already exists.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Check if a file is selected
            if ($_FILES['picture']['name']) {
                // File upload path
                $targetDir = "teacher_uploads/";
                $fileName = basename($_FILES["picture"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                // Allow certain file formats
                $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
                if (in_array($fileType, $allowedTypes)) {
                    // Upload file to server
                    if (move_uploaded_file($_FILES["picture"]["tmp_name"], $targetFilePath)) {
                        // File uploaded successfully
                        //$success_message .= "Profile picture uploaded successfully.";
                    } else {
                        $error .= "Sorry, there was an error uploading your file.";
                    }
                } else {
                    $error .= "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
                }
            }

            // Prepare SQL statement to insert data into the database
            $sql = "INSERT INTO teachers (firstname, lastname, username, email, classteacher, password, picture) VALUES ('$firstName', '$lastName', '$username', '$email','$class', '$hashedPassword', '$fileName')";

            // Execute the SQL statement
            if ($conn->query($sql) === TRUE) {
                $success_message .= "New record created successfully";
                // Clear form fields
                $_POST = array();
            } else {
                $error = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Teacher Registration</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Include Font Awesome -->
<link rel="stylesheet" href="./css/teacher_registrastration.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet"></div>
</head>
<body>

<div class="back-card">
    <img src="images/logo.jpg" alt="Logo">
    <h2>Teacher Registration | Usajiri wa Mwalimu</h2>
    <button onclick="window.location.href='admin_dashboard.php'">BACK</button>
</div>

<div class="card">
  
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <input type="text" id="firstName" name="firstName" placeholder="First Name" value="<?php echo isset($_POST['firstName']) ? $_POST['firstName'] : ''; ?>" required>
    </div>
    <div class="form-group">
      <input type="text" id="lastName" name="lastName" placeholder="Last Name" value="<?php echo isset($_POST['lastName']) ? $_POST['lastName'] : ''; ?>" required>
    </div>
    <div class="form-group">
      <input type="text" id="username" name="username" placeholder="Username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required>
    </div>
    <div class="form-group">
      <input type="email" id="email" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
    </div>
    <div class="form-group">
            <select id="class" name="class">
                <option value="" disabled selected hidden>Select Class</option>
                <option value="1" <?php echo isset($_POST['class']) && $_POST['class'] == '1' ? 'selected' : ''; ?>>1</option>
                <option value="2" <?php echo isset($_POST['class']) && $_POST['class'] == '2' ? 'selected' : ''; ?>>2</option>
                <option value="3" <?php echo isset($_POST['class']) && $_POST['class'] == '3' ? 'selected' : ''; ?>>3</option>
                <option value="4" <?php echo isset($_POST['class']) && $_POST['class'] == '4' ? 'selected' : ''; ?>>4</option>
                <option value="5" <?php echo isset($_POST['class']) && $_POST['class'] == '5' ? 'selected' : ''; ?>>5</option>
                <option value="6" <?php echo isset($_POST['class']) && $_POST['class'] == '6' ? 'selected' : ''; ?>>6</option>
                <option value="7" <?php echo isset($_POST['class']) && $_POST['class'] == '7' ? 'selected' : ''; ?>>7</option>
            </select>
        </div>
    <div class="form-group">
      <input type="file" id="picture" name="picture" accept="image/*" required>
    </div>
    <div class="form-group">
      <input type="password" id="password" name="password" placeholder="Password" required>
    </div>
    <div class="form-group">
      <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
      <span class="error-message"><?php echo $error; ?></span>
      <span class="success-message"><?php echo $success_message; ?></span>
    </div>

    <input type="submit" value="Register" name="register">
  </form>
</div>

</body>
</html>
