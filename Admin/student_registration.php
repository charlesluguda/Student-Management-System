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
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $phoneNumber = $_POST['phoneNumber'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $class = $_POST['class'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // File upload handling
    $picture = $_FILES['picture']['name'];
    $target_dir = "uploads/"; // Directory where the file will be stored
    $target_file = $target_dir . basename($_FILES["picture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check file type
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedExtensions)) {
        $error = "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check file size (maximum 5MB)
    $maxFileSize = 5 * 1024 * 1024; // 5 MB in bytes
    if ($_FILES["picture"]["size"] > $maxFileSize) {
        $error = "Sorry, your file is too large. Maximum file size allowed is 5MB.";
        $uploadOk = 0;
    }

    // Proceed with file upload if everything is OK
    if ($uploadOk == 1) {
        if (!move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
            $error = "Sorry, there was an error uploading your file.";
        }
    }

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement to check if the username already exists
        $checkUsernameSQL = "SELECT * FROM students WHERE username = '$username'";
        $result = $conn->query($checkUsernameSQL);

        // Check if the username already exists
        if ($result->num_rows > 0) {
            $error = "Username already exists.";
        } else {
            // Prepare SQL statement to check if the email already exists
            $checkEmailSQL = "SELECT * FROM students WHERE email = '$email'";
            $result = $conn->query($checkEmailSQL);

            // Check if the email already exists
            if ($result->num_rows > 0) {
                $error = "Email already exists.";
            } else {
                // Prepare SQL statement to insert data into the database
                $sql = "INSERT INTO students (firstname, middlename, lastname, gender, phone, username, email, dateOfbirth, picture, class, password) 
                VALUES ('$firstName', '$middleName', '$lastName', '$gender', '$phoneNumber', '$username','$email', '$dateOfBirth', '$picture', '$class', '$hashedPassword')";

                // Execute the SQL statement
                if ($conn->query($sql) === TRUE) {
                    $success_message = "New record created successfully";
                    // Clear form fields
                    $_POST = array();

                    // Redirect to dashboard
                    header("refresh:1; url = view_students.php");
                    exit(); // stop further execution
                } else {
                    $error = "Error: " . $sql . "<br>" . $conn->error;
                }
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
    <title>Student Registration</title>
    
    <script>
    function validatePhoneNumber() {
        var phoneNumberInput = document.getElementById('phoneNumber');
        var phoneNumber = phoneNumberInput.value.trim();

        // Check if the phone number starts with '+255'
        if (!phoneNumber.startsWith('+255')) {
            alert('Phone number must start with +255.');
            phoneNumberInput.focus();
            return false;
        }

        // Additional validation logic can be added here
        
        return true;
    }

    // Add event listener to the form submit button
    document.getElementById('registrationForm').addEventListener('submit', function(event) {
        if (!validatePhoneNumber()) {
            event.preventDefault(); // Prevent form submission
        }
    });
</script>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <style>
        *{
            font-family: "Ubuntu", sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
    max-width: 90vw;
    margin: 100px auto;
    background-color: #ffffff;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    padding: 30px;
    position: relative;
}

.form-container {
    padding-bottom: 20px;
}


        .header-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 100px;
            border-radius: 8px;
            margin-right: 20px;
        }


        h2 {
            text-align: center;
            color: #6b2121;
        }
        form-grid{
            display: grid;
            grid-template-columns: repeat(2, 1fr);
        }
        form{
            align-items: center;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="password"],
        input[type="file"],
        input[type="date"],
        input[type="email"],
        select {
            width: calc(100% - 20px);
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: #f5f5f5;
            color: #333;
        }
/* Add font size for placeholder text */
input[type="text"]::placeholder,
        input[type="password"]::placeholder,
        input[type="email"]::placeholder,
        input[type="file"]::placeholder,
        input[type="date"]::placeholder,
        input[type="genter"]::placeholder,
        select::placeholder {
            font-size: 13px; /* Adjust the font size as needed */
        }

        input[type="submit"] {
            width: 80%;
            /* margin: auto; */
            padding: 10px;
            border: none;
            font-size: 18px;
            border-radius: 5px;
            background-color: #4f9354eb;
            color: #ffffff;
            cursor: pointer;
            margin: auto;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s ease;
        }

        img {
            display: block;
            margin: 0 auto 20px;
            max-width: 200px;
            border-radius: 8px;
        }

        .error-message {
            color: red;
            font-size: 14px;
        }

        .success-message {
            color: green;
            font-size: 14px;
        }

.back-card {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 70px;
    display: flex;
    background-color: #4f9354eb;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding-bottom: 10px;
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
    margin-right: 10px;
    cursor: pointer;
    font-weight: 600;
    transition: background-color 0.3s ease;
}

@media (max-width: 768px) {
            .container {
                width: 90%;
                max-width: 90%;
            }
        }

        .separator {
            border: 1px solid green;
            border-radius: 10px;
            height: 2px;
            background-color: #4f9354eb;
            margin: 20px 0;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.1);
        }
    </style>
</head>
<body>

<div class="back-card">
    <img src="images/logo.jpg" alt="Logo">
    <h2>Student Registration</h2>

    <button onclick="window.location.href='admin_dashboard.php'">BACK</button>
</div>

<div class="container">
    <div class="header-container">
   
    </div>
    <hr class="separator">

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
        <form-grid>
        <div class="form-group-left">
        <div class="form-group">
            <input type="text" id="firstName" name="firstName" placeholder="First Name" value="<?php echo isset($_POST['firstName']) ? $_POST['firstName'] : ''; ?>" required>
        </div>
        <div class="form-group">
            <input type="text" id="middleName" name="middleName" placeholder="Middle Name" value="<?php echo isset($_POST['middleName']) ? $_POST['middleName'] : ''; ?>" required>
        </div>
        <div class="form-group">
            <input type="text" id="lastName" name="lastName" placeholder="Last Name" value="<?php echo isset($_POST['lastName']) ? $_POST['lastName'] : ''; ?>" required>
        </div>

        <div class="form-group">
            <select id="gender" name="gender" required>
                <option value="" disabled selected hidden>Select Gender</option>
                <option value="Male" <?php echo isset($_POST['gender']) && $_POST['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo isset($_POST['gender']) && $_POST['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                <option value="Other" <?php echo isset($_POST['gender']) && $_POST['gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
            </select>
        </div>

        <div class="form-group">
            <input type="text" id="username" name="username" placeholder="Username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required>
        </div>
        <div class="form-group">
            <input type="email" id="email" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
        </div>
        </div>
        <div class="form-group-right">
        <div class="form-group">
            <input type="date" id="dateOfBirth" name="dateOfBirth" placeholder="Date of Birth" value="<?php echo isset($_POST['dateOfBirth']) ? $_POST['dateOfBirth'] : ''; ?>" required>
        </div>
        <div class="form-group">
        <input type="text" id="phoneNumber" name="phoneNumber" placeholder="Phone Number" value="<?php echo isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : '+255    '; ?>" required>
        </div>

        <div class="form-group">
            <input type="file" id="picture" name="picture" accept="image/*" required>
        </div>
        <div class="form-group">
            <select id="class" name="class" required>
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
            <input type="password" id="password" name="password" placeholder="Password" required>
        </div>
        <div class="form-group">
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
            <span class="error-message"><?php echo $error; ?></span>
            <span class="success-message"><?php echo $success_message; ?></span>
        </div>
        </div>
        </form-grid>

        <div class="form-group btn">
            <input type="submit" value="Register" name="register">
        </div>
    </form>
</div>

</body>
</html>

