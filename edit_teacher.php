<?php
// Include session.php and database.php
include 'session.php';
include 'database.php';

// Fetch teacher data based on ID
if (isset($_GET['teacherID']) && !empty($_GET['teacherID'])) {
    $teacher_id = $_GET['teacherID'];
    $sql = "SELECT * FROM teachers WHERE teacherID = $teacher_id";
    $result = $conn->query($sql);

    // Check if teacher data exists
    if ($result->num_rows > 0) {
        $teacher = $result->fetch_assoc();
    } else {
        // Redirect to view_teachers.php if teacher data not found
        header("Location: view_teachers.php?error=Teacher not found.");
        exit();
    }
} else {
    // Redirect to view_teachers.php if teacher ID is not provided
    header("Location: view_teachers.php");
    exit();
}

// Handle form submission for updating teacher data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gather form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
   
    // Check if a new picture is uploaded
    $newPicture = $teacher['picture']; // Initialize with existing picture
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
                $newPicture = $fileName; // Update picture name
            } else {
                header("Location: view_teachers.php?error=Sorry, there was an error uploading your file.");
                exit();
            }
        } else {
            header("Location: view_teachers.php?error=Sorry, only JPG, JPEG, PNG, and GIF files are allowed.");
            exit();
        }
    }

    // Prepare SQL statement to update teacher data
    $updateSQL = "UPDATE teachers SET firstname='$firstName', lastname='$lastName', username='$username', picture='$newPicture' WHERE teacherID=$teacher_id";

    // Execute the SQL statement
    if ($conn->query($updateSQL) === TRUE) {
        // Redirect to view_teachers.php with success message
        header("Location: view_teachers.php?message=Teacher updated successfully.");
        exit();
    } else {
        // Redirect to view_teachers.php with error message
        header("Location: view_teachers.php?error=Error updating teacher: " . $conn->error);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Teacher</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
  }

  h2 {
    text-align: center;
  }

  form {
    width: 50%;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  label {
    display: block;
    margin-bottom: 10px;
  }

  input[type="text"],
  input[type="file"],
  input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
  }

  input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  input[type="submit"]:hover {
    background-color: #0056b3;
  }
</style>
</head>
<body>

<h2>Edit Teacher</h2>

<form action="<?php echo $_SERVER['PHP_SELF'] . '?teacherID=' . $teacher_id; ?>" method="POST" enctype="multipart/form-data">
  <label for="firstName">First Name:</label><br>
  <input type="text" id="firstName" name="firstName" value="<?php echo $teacher['firstname']; ?>"><br>
  <label for="lastName">Last Name:</label><br>
  <input type="text" id="lastName" name="lastName" value="<?php echo $teacher['lastname']; ?>"><br>
  <label for="username">Username:</label><br>
  <input type="text" id="username" name="username" value="<?php echo $teacher['username']; ?>"><br>
  <label for="picture">Profile Picture:</label><br>
  <input type="file" id="picture" name="picture" accept="image/*"><br>
  <br>
  <input type="submit" value="Update">
</form>

</body>
</html>
