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
    $subjectName = $_POST['subjectName'];
    $class = $_POST['class'];
    $teacherName = $_POST['teacher']; // Store the selected teacher's name

    // Retrieve teacherID and email based on the selected teacher's full name
    $retrieveTeacherInfoSQL = "SELECT teacherID, email FROM teachers WHERE CONCAT(firstname, ' ', lastname) = '$teacherName'";
    $result = $conn->query($retrieveTeacherInfoSQL);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $teacherID = $row['teacherID'];
        $teacherEmail = $row['email']; // Get teacher's email

        // Check if the subject and class combination already exists
        $checkSubjectSQL = "SELECT * FROM subjects WHERE subject_name = '$subjectName' AND class = '$class'";
        $checkResult = $conn->query($checkSubjectSQL);
        if ($checkResult->num_rows > 0) {
            // Update the existing record
            $updateSQL = "UPDATE subjects SET teacherID = '$teacherID', teacher_name = '$teacherName', email = '$teacherEmail' WHERE subject_name = '$subjectName' AND class = '$class'";
            if ($conn->query($updateSQL) === TRUE) {
                $success_message = "Subject updated successfully";
            } else {
                $error = "Error updating subject: " . $conn->error;
            }
        } else {
            // Insert a new record
            $insertSQL = "INSERT INTO subjects (subject_name, class, teacherID, teacher_name, email) VALUES ('$subjectName', '$class', '$teacherID', '$teacherName', '$teacherEmail')";
            if ($conn->query($insertSQL) === TRUE) {
                $success_message = "Subject registered successfully";
            } else {
                $error = "Error registering subject: " . $conn->error;
            }
        }
    } else {
        $error = "Error: Teacher not found.";
    }
}

// Retrieve teachers from the database
$teachers = [];
$retrieveTeachersSQL = "SELECT teacherID, CONCAT(firstname, ' ', lastname) AS full_name, email FROM teachers";
$result = $conn->query($retrieveTeachersSQL);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $teachers[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Registration</title>
    <link rel="stylesheet" href="./css/register_subjects.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet"></div>
</head>
<body>
    <div class="back-card">
        <img src="images/logo.jpg" alt="Logo">
        <h2>Subjects Registration | Usajiri wa Masomo</h2>
        <button onclick="window.location.href='admin_dashboard.php'">BACK</button>
    </div>

    <div class="container">

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div>
                <label for="subjectName">Subject Name:</label>
                <input type="text" id="subjectName" name="subjectName" required>
            </div>
            <div>
                <label for="class">Class:</label>
                <select id="class" name="class" required>
                    <option value="" disabled selected>Select Class</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                </select>
            </div>
            <div>
                <label for="teacher">Teacher:</label>
                <select id="teacher" name="teacher" required>
                    <option value="" disabled selected>Select Teacher</option>
                    <?php foreach ($teachers as $teacher): ?>
                        <option value="<?php echo $teacher['full_name']; ?>"><?php echo $teacher['full_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit">Register Subject</button>
        </form>

        <?php
        // Display error or success message
        if (!empty($error)) {
            echo "<p class='error-message'>Error: $error</p>";
        } elseif (!empty($success_message)) {
            echo "<p class='success-message'>$success_message</p>";
        }
        ?>
    </div>
</body>
</html>
