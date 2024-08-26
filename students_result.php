<?php
include 'session.php';
include './Includes/database.php';

// Initialize variables
$show_form = false;
$access_granted = false;
$result_students = null;
$subject_already_inserted = false;
$semester_options = ["Mid Term", "Semi-Annually", "Annually"];
$month_options = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

// Check if the "Add marks" button is clicked
if (isset($_POST['add_marks'])) {
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
    $selected_class = $_POST['class'];
    $selected_subject = $_POST['subject'];
    $selected_semester = $_POST['semester']; // Assign value from form field
    $selected_month = $_POST['month']; // Assign value from form field

    // Query to check if the teacher has access to the selected subject of the selected class
    $sql_access_check = "SELECT * FROM subjects WHERE email = '$teacher_email' AND class = '$selected_class' AND subject_name = '$selected_subject'";
    $result_access_check = $conn->query($sql_access_check);

    if ($result_access_check && $result_access_check->num_rows > 0) {
        $access_granted = true;

        // Get the appropriate table name based on the selected class
        $table_name = 'std' . $selected_class . '_results';

        // Query to fetch the students in the selected class taught by the logged-in teacher
        $sql_students = "SELECT *, CONCAT_WS(' ', firstname, middlename, lastname) AS fullname FROM students WHERE class = '$selected_class' ORDER BY firstname ASC";
        $result_students = $conn->query($sql_students);
    } else {
        $access_granted = false;
    }
}

// Insert marks into the appropriate table
if (isset($_POST['insert_marks'])) {
    $selected_class = $_POST['selected_class'];
    $selected_subject = $conn->real_escape_string($_POST['selected_subject']);
    $selected_semester = $_POST['semester'];
    $selected_month = $_POST['month'];
    $table_name = 'std' . $selected_class . '_results';

    foreach ($_POST as $key => $value) {
        if (strpos($key, 'student_') !== false) {
            $student_id = substr($key, strlen('student_'));
            $marks = (int)$value;

            // Check if the student already exists in the table
            $student_check_query = "SELECT CONCAT_WS(' ', firstname, middlename, lastname) AS fullname FROM students WHERE studentID = $student_id";
            $student_check_result = $conn->query($student_check_query);

            if ($student_check_result && $student_check_result->num_rows > 0) {
                $student_name = $student_check_result->fetch_assoc()['fullname'];

                // Check if the student already has marks for the specific semester and month
                $marks_check_query = "SELECT * FROM $table_name WHERE studentID = $student_id AND semester = '$selected_semester' AND month = '$selected_month'";
                $marks_check_result = $conn->query($marks_check_query);

                if ($marks_check_result && $marks_check_result->num_rows > 0) {
                    // Marks already exist for the semester and month, update the marks for the specified subject
                    $update_query = "UPDATE $table_name SET $selected_subject = $marks WHERE studentID = $student_id AND semester = '$selected_semester' AND month = '$selected_month'";
                    $conn->query($update_query);
                } else {
                    // No marks exist for the semester and month, insert the marks
                    $insert_query = "INSERT INTO $table_name (studentID, fullname, $selected_subject, semester, month) VALUES ($student_id, '$student_name', $marks, '$selected_semester', '$selected_month')";
                    $conn->query($insert_query);
                }
            } else {
                // Student with the given ID does not exist
                echo "<script>alert('Student with ID $student_id not found.');</script>";
            }
        }
    }

    // Alert on successful insertion or update
    echo "<script>alert('Marks inserted/updated successfully.');</script>";
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <style>
        /* CSS styles for the form container */
.form-container {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-container .title {
    text-align: center;
    margin-bottom: 20px;
}

.form-container .title-text {
    font-size: 24px;
    font-weight: bold;
    color: #333;
}

.form-container .title-line {
    width: 50px;
    height: 2px;
    background-color: #333;
    margin: 0 auto;
    margin-bottom: 20px;
}

.form-container form {
    text-align: center;
}

.form-container label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}

.form-container select {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

.form-container button {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.form-container button:hover {
    background-color: #45a049;
}

/* CSS styles for the student list container */
.student-list-container {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.student-list-container h2 {
    text-align: center;
    margin-bottom: 20px;
}

.student-list-container ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.student-list-container li {
    margin-bottom: 10px;
}

.student-list-container input[type="number"] {
    width: 50px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}
    </style>
</head>
<body>

<div class="form-container">
    <div class="title">
        <span class="title-text">Panel to Upload Student Results</span>
        <div class="title-line"></div>
    </div>
    <form action="" method="POST">
        <button type="submit" name="add_marks">Add marks</button>
    </form>
    <?php
    if ($show_form) {
        ?>
        <form action="" method="POST">
            <div>
                <label for="class">Select Class:</label>
                <select id="class" name="class" required>
                    <option value="" disabled selected>Select Class</option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?php echo $class; ?>"><?php echo $class; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="subject">Select Subject:</label>
                <select id="subject" name="subject" required>
                    <option value="" disabled selected>Select Subject</option>
                    <?php foreach ($subjects as $subject): ?>
                        <option value="<?php echo $subject; ?>"><?php echo $subject; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="semester">Select Semester:</label>
                <select id="semester" name="semester" required>
                    <option value="" disabled selected>select semester</option>
                    <?php foreach ($semester_options as $option): ?>
                        <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="month">Select Month:</label>
                <select id="month" name="month" required>
                    <option value="" disabled selected>select month</option>
                    <?php foreach ($month_options as $option): ?>
                        <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <button type="submit" name="choose_class_subject">Submit</button>
            </div>
        </form>
        <?php
    }

    if ($access_granted === false && isset($_POST['choose_class_subject'])) {
        echo "<p>You don't have access to that subject of that class.</p>";
    }

    if ($subject_already_inserted) {
        echo "<p>You have already inserted marks for the selected subject, semester, and month.</p>";
    }
    ?>
</div>

<?php
if ($result_students && $result_students->num_rows > 0) {
    ?>
    <div class="student-list-container">
        <h2>Selected Students</h2>
        <form action="" method="POST">
            <input type="hidden" name="selected_class" value="<?php echo $selected_class; ?>">
            <input type="hidden" name="selected_subject" value="<?php echo $selected_subject; ?>">
            <input type="hidden" name="semester" value="<?php echo $selected_semester; ?>">
            <input type="hidden" name="month" value="<?php echo $selected_month; ?>">
            <ul>
                <?php while ($row = $result_students->fetch_assoc()) { ?>
                    <li>
                        <?php echo $row['firstname'] . ' ' . $row['lastname']; ?>:
                        <input type="number" name="<?php echo 'student_' . $row['studentID']; ?>" min="0" max="100" required>
                    </li>
                <?php } ?>
            </ul>
            <button type="submit" name="insert_marks">Insert Marks</button>
        </form>
    </div>
    <?php
}
?>

</body>
</html>
