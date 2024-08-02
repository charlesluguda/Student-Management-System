<?php
// Include session.php and database.php
include 'session.php';
include 'database.php';

// Fetch subject data based on ID
if (isset($_GET['subject_id']) && !empty($_GET['subject_id'])) {
    $subjectID = $_GET['subject_id'];
    $sql = "SELECT * FROM subjects WHERE subject_id = $subjectID";
    $result = $conn->query($sql);

    // Check if subject data exists
    if ($result->num_rows > 0) {
        $subject = $result->fetch_assoc();
    } else {
        // Redirect to view_subjects.php if subject data not found
        header("Location: view_subjects.php?error=Subject not found.");
        exit();
    }
} else {
    // Redirect to view_subjects.php if subject ID is not provided
    header("Location: view_subjects.php");
    exit();
}

// Handle form submission for updating subject data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gather form data
    $subjectName = $_POST['subjectName'];
    $class = $_POST['class'];

    // Prepare SQL statement to update subject data
    $updateSQL = "UPDATE subjects SET subject_name='$subjectName', class='$class' WHERE subject_id=$subjectID";

    // Execute the SQL statement
    if ($conn->query($updateSQL) === TRUE) {
        // Redirect to view_subjects.php with success message
        header("Location: view_subjects.php?message=Subject updated successfully.");
        exit();
    } else {
        // Redirect to view_subjects.php with error message
        header("Location: view_subjects.php?error=Error updating subject: " . $conn->error);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Subject</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
  }

  h2 {
    text-align: center;
    margin-top: 20px;
  }

  form {
    width: 90%; /* Set the form width to 90% of the viewport width */
    max-width: 600px; /* Set maximum width for larger screens */
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
  }

  input[type="text"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    margin-bottom: 10px;
  }

  input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  input[type="submit"]:hover {
    background-color: #0056b3;
  }
</style>
</head>
<body>

<h2>Edit Subject</h2>

<form action="<?php echo $_SERVER['PHP_SELF'] . '?subject_id=' . $subjectID; ?>" method="POST">
  <label for="subjectName">Subject Name:</label>
  <input type="text" id="subjectName" name="subjectName" value="<?php echo $subject['subject_name']; ?>">

  <label for="class">Class:</label>
  <input type="text" id="class" name="class" value="<?php echo $subject['class']; ?>">

  <br>
  <input type="submit" value="Update">
</form>

</body>
</html>


