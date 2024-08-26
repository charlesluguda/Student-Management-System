<?php

include 'session.php';
include './Includes/database.php';

// Initialize variables
$show_form = false;
$access_granted = false;
$result_students = null;
$selected_class = null;
$attendance_table_name = ''; // Define the variable in global scope

// Check if the "Add marks" button is clicked
if (isset($_POST['make_attendance'])) {
    // Show the form to choose class
    $show_form = true;
}

// Retrieve the email of the logged-in teacher from the session
$teacher_email = $_SESSION['Email'];
$teacherID = $_SESSION['teacherID'];

// Query to retrieve the teacherID and classteacher based on the email
$sql_teacher_id = "SELECT teacherID, classteacher FROM teachers WHERE email = ?";
$stmt_teacher_id = $conn->prepare($sql_teacher_id);
$stmt_teacher_id->bind_param("s", $teacher_email);
$stmt_teacher_id->execute();
$stmt_teacher_id->bind_result($teacherID, $classteacher);
$stmt_teacher_id->fetch();
$stmt_teacher_id->close();

// Define classes array from 1 to 7
$classes = range(1, 7);

// Check if the form to choose class is submitted
if (isset($_POST['choose_class'])) {
    // Retrieve the selected class
    $selected_class = $_POST['class'];

    // Check if the teacher is allowed to make attendance for the selected class
    if ($classteacher == $selected_class) {
        // The teacher is allowed to make attendance for the selected class
        $access_granted = true;

        // Get the appropriate table name based on the selected class
        $attendance_table_name = 'attendance' . $selected_class; // Dynamically setting the table name

        // Query to fetch the student results from the specific class table
        $sql_students = "SELECT studentID, CONCAT(firstname, ' ', middlename, ' ', lastname) AS fullname FROM students WHERE class = ?";
        $stmt_students = $conn->prepare($sql_students);
        $stmt_students->bind_param("s", $selected_class);
        $stmt_students->execute();
        $result_students = $stmt_students->get_result();
        $stmt_students->close();
    } else {
        // The teacher doesn't have access to make attendance for the selected class
        $access_granted = false;
    }
}

// Adjusted code for inserting attendance data
if (isset($_POST['submit_attendance'])) {
    if (!empty($_POST['attendance_table_name'])) { // Retrieve the table name from the form input
        $attendance_table_name = $_POST['attendance_table_name'];
        $selected_class = $_POST['selected_class'];
        $attendance_date = $_POST['attendance_date'];

        foreach ($_POST['attendance_status'] as $studentID => $status) {
            // Insert attendance data
            $sql_insert = "INSERT INTO $attendance_table_name (teacherID, studentID, attendance_status, uploaded_date, created_at) VALUES (?, ?, ?, ?, NOW())";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("ssss", $teacherID, $studentID, $status, $attendance_date);

            // Execute the insertion query
            $stmt_insert->execute();
        }
    } else {
        echo "Error: Attendance table name is not defined.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Attendance</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
        }
        .form-container {
            max-width: 600px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 5px 7px 33px 1px rgba(0,0,0,0.57); 
        }
        .form-container h2 {
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 20px;
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
        .form-container button {
            padding: 10px 20px;
            background-color: #4f9354eb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-container button:hover {
            background-color: #45a049;
        }
        .student-list-container {
            margin: auto;
            overflow-x: auto;
            align-items: center;
        }
        .student-list-container table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
        }
        .student-list-container th,
        .student-list-container td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .student-list-container th {
            background-color: #4f9354eb;
        }
        .student-list-container input[type="date"] {
            width: 80%;
            padding: 10px;
            margin-left: 120px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        td button{
            padding: 10px 10px;
            cursor: pointer;
            background: #4f9354eb;
            color: white;
            border-radius: 5px;
            border: none;
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
    <h2>STUDENT ATTENDANCE</h2>
    <button onclick="window.location.href='dashboard.php'">BACK</button>
</div>
<div class="form-container">
    <h2>PANEL MAKE STUDENT ATTENDANCE</h2>

    <form action="" method="POST">
        <button type="submit" name="make_attendance">View Students</button>
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
                <button type="submit" name="choose_class">Submit</button>
            </div>
        </form>
        <?php
    }

    if ($access_granted === false && isset($_POST['choose_class'])) {
        echo "<p>You don't have access to make attendance for that class.</p>";
    }
    ?>
</div>

<?php
if ($result_students && $result_students->num_rows > 0) {
    ?>
    <div class="student-list-container">
        <form action="" method="POST">
            <input type="hidden" name="selected_class" value="<?php echo $selected_class; ?>">
            <input type="hidden" name="attendance_table_name" value="<?php echo $attendance_table_name; ?>"> <!-- Hidden input for table name -->
            <input type="date" name="attendance_date" required>
            <table>
                <thead>
                <tr>
                    <th>S/No</th>
                    <th>Student Name</th>
                    <th>Attendance Status</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $serial_number = 1;
                while ($row = $result_students->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $serial_number; ?></td>
                        <td><?php echo $row['fullname']; ?></td>
                        <td>
                            <select name="attendance_status[<?php echo $row['studentID']; ?>]">
                                <option value="Present">Present</option>
                                <option value="Absent">Absent</option>
                                <option value="Permission">Permission</option>
                            </select>
                        </td>
                    </tr>
                    <?php
                    $serial_number++;
                } ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3">
                        <button type="submit" name="submit_attendance">Submit Attendance</button>
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
