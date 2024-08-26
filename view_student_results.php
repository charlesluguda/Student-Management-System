<?php
include 'session.php';
include './Includes/database.php';

// Initialize variables
$show_form = false;
$access_granted = false;
$result_students = null;
$selected_class = null;
$selected_subject = null;

// Check if the "Add marks" button is clicked
if (isset($_POST['add_marks'])) {
    // Show the form to choose class and subject
    $show_form = true;
}

// Retrieve the email of the logged-in teacher from the session
$teacher_email = $_SESSION['Email'];

// Fetch classes and subjects data from the database for the logged-in teacher
$sql_classes = "SELECT DISTINCT class FROM subjects WHERE email = '$teacher_email'";
$result_classes = $conn->query($sql_classes);
$classes = [];
if ($result_classes && $result_classes->num_rows > 0) {
    while ($row = $result_classes->fetch_assoc()) {
        $classes[] = $row['class'];
    }
}

$sql_subjects = "SELECT DISTINCT subject_name FROM subjects WHERE email = '$teacher_email'";
$result_subjects = $conn->query($sql_subjects);
$subjects = [];
if ($result_subjects && $result_subjects->num_rows > 0) {
    while ($row = $result_subjects->fetch_assoc()) {
        $subjects[] = $row['subject_name'];
    }
}

// Check if the form to choose class and subject is submitted
if (isset($_POST['choose_class_subject'])) {
    // Retrieve the selected class and subject
    $selected_class = $_POST['class'];
    $selected_subject = $_POST['subject'];

    // Query to check if the teacher has access to the selected subject of the selected class
    $sql_access_check = "SELECT * FROM subjects WHERE email = '$teacher_email' AND class = '$selected_class' AND subject_name = '$selected_subject'";
    $result_access_check = $conn->query($sql_access_check);

    if ($result_access_check && $result_access_check->num_rows > 0) {
        // The teacher has access to the selected subject of the selected class
        $access_granted = true;

        // Get the appropriate table name based on the selected class
        $table_name = 'std' . $selected_class . '_results';

        // Query to fetch the student results from the specific class table
        $sql_students = "SELECT fullname, $selected_subject FROM $table_name";
        $result_students = $conn->query($sql_students);
    } else {
        // The teacher doesn't have access to the selected subject of the selected class
        $access_granted = false;
    }
}


// Update marks in the appropriate table
if (isset($_POST['update_marks'])) {
    // Retrieve the selected class and subject
    $selected_class = $_POST['selected_class'];
    $selected_subject = $conn->real_escape_string($_POST['selected_subject']); // Escape subject name

    // Get the appropriate table name based on the selected class
    $table_name = 'std' . $selected_class . '_results';

    // Variable to track if any changes were made
    $changes_made = false;

    // Loop through each student to update their marks
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'student_') !== false) {
            $student_name = str_replace('_', ' ', substr($key, strlen('student_')));
            $marks = (int)$value; // Ensure marks are integers

            // Prepare the query to update marks in the table for existing records only
            $update_query = "UPDATE $table_name SET $selected_subject = ? WHERE fullname = ? AND $selected_subject IS NOT NULL";
            $stmt_update = $conn->prepare($update_query);
            $stmt_update->bind_param("is", $marks, $student_name);
            $stmt_update->execute();

            // Check if any rows were affected by the update operation
            if ($stmt_update->affected_rows > 0) {
                $changes_made = true;
            }
        }
    }

    // Check if any changes were made
    if ($changes_made) {
        echo "<script>alert('Marks updated successfully!');</script>";
    } else {
        echo "<script>alert('No changes were made.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <style>
        body {
            margin: 0; 
            padding: 0; 
        }

        .content-container {
            position: relative;
            z-index: 1;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            margin-top: 100px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
            text-align: center;
            box-shadow: 5px 7px 33px 1px rgba(0,0,0,0.57); 
        }

        .form-container h2 {
            text-transform: uppercase;
            text-decoration: underline;
            text-underline-position: under;
            text-underline-offset: 3px;
        }

        .form-container form {
            text-align: center;
        }

        .form-container label {
            display: block;
            margin-bottom: 10px;
        }

        .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .student-list-container {
            margin: 0 20px;
            overflow-x: auto; 
        }

        .form-container button {
            padding: 10px 20px;
            background-color: #4f9354eb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .student-list-container table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            margin-top: 20px;
            /* background-color: #d9a225; */
        }

        .student-list-container th,
        .student-list-container td {
            padding: 8px;
            border: 1px solid #ddd;
            color: black;
        }

        .student-list-container th {
            background-color: #4f9354eb;
            text-align: left;
            color: white;
        }

        .student-list-container input[type="number"] {
            width: 50px;
        }

        .student-list-container button {
            width: 100%;
            padding: 10px 20px;
            background-color: #4f9354eb;
            color: white;
            margin-top: 1%;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .student-list-container button:hover {
            background-color: #45a049;
        }

        .title-text {
            text-align: center;
            text-transform: uppercase;
            text-decoration: underline;
            text-underline-position: under;
            text-underline-offset: 3px;
        }
        @media screen and (max-width: 768px) {
            .form-container,
            .student-list-container {
                max-width: 100%;
                margin: 0 auto;
                padding: 10px;
            }

            .student-list-container table {
                margin-left: 0;
            }
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
    font-size: 28px;
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
    margin: 10px;
    transition: background-color 0.3s ease;
    }
    </style>
</head>
<body>
<div class="back-card">
    <img src="images/logo.jpg" alt="Logo">
    <h2>VIEW AND UPDATE STUDENT RESULTS</h2>
    <button onclick="window.location.href='dashboard.php'">BACK</button>
</div>
<div class="form-container">
    <h2 class="title-text">PANEL TO VIEW AND UPDATE STUDENT RESULTS</h2> <!-- Modified: Moved here -->

    <?php
    // Display the "Add marks" button
    ?>
    <form action="" method="POST">
        <button type="submit" name="add_marks">View Result</button>
    </form>
    <?php

    // Check if the form to choose class and subject should be displayed
    if ($show_form) {
        ?>
        <form action="" method="POST">
            <div>
                <label for="class">Select Class:</label>
                <select id="class" name="class" required>
                    <option value="" disabled selected>Select Class</option> <!-- Disabled and selected by default -->
                    <?php foreach ($classes as $class): ?>
                        <option value="<?php echo $class; ?>"><?php echo $class; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="subject">Select Subject:</label>
                <select id="subject" name="subject" required>
                    <option value="" disabled selected>Select Subject</option> <!-- Disabled and selected by default -->
                    <?php foreach ($subjects as $subject): ?>
                        <option value="<?php echo $subject; ?>"><?php echo $subject; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <button type="submit" name="choose_class_subject">Submit</button>
            </div>
        </form>
        <?php
    }
    ?>

    <?php
    // Display warning message if access is not granted
    if ($access_granted === false && isset($_POST['choose_class_subject'])) {
        echo "<p>You don't have access to that subject of that class.</p>";
    }
    ?>
</div>

<?php
// Display the student list if available
if ($result_students && $result_students->num_rows > 0) {
    ?>
    <div class="student-list-container">

        <form action="" method="POST">
            <input type="hidden" name="selected_class" value="<?php echo $selected_class; ?>">
            <input type="hidden" name="selected_subject" value="<?php echo $selected_subject; ?>">
            <table>
                <thead>
                <tr>
                    <th>S/No</th>
                    <th>Student Name</th>
                    <th><?php echo $selected_subject; ?> Marks</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $serial_number = 1; // Initialize serial number
                while ($row = $result_students->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $serial_number; ?></td>
                        <td><?php echo $row['fullname']; ?></td>
                        <td><input type="number" name="<?php echo 'student_' . str_replace(' ', '_', $row['fullname']); ?>" min="0" max="100" value="<?php echo $row[$selected_subject]; ?>" required></td>
                    </tr>
                    <?php
                    $serial_number++; // Increment serial number
                } ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3"> <!-- Span across all columns -->
                        <button type="submit" name="update_marks">Update Marks</button>
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
    <?php
}
?>


</body>
</html>



