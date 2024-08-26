<?php

include 'session.php';
include './Includes/database.php';

// Initialize variables
$show_form = false;
$access_granted = false;
$attendance_records = [];

// Check if the "View Students" button is clicked
if (isset($_POST['view_attendance'])) {
    // Show the form to choose class
    $show_form = true;
}

// Retrieve the email of the logged-in teacher from the session
$teacher_email = $_SESSION['Email'];
$teacherID = $_SESSION['teacherID'];

// Define classes from 1 to 7
$classes = range(1, 7);

// Query to fetch the classes taught by the teacher from the teachers table
$sql_teacher_classes = "SELECT classteacher FROM teachers WHERE teacherID = ?";
$stmt_teacher_classes = $conn->prepare($sql_teacher_classes);
$stmt_teacher_classes->bind_param("s", $teacherID);
$stmt_teacher_classes->execute();
$result_teacher_classes = $stmt_teacher_classes->get_result();
$teacher_classes = [];
while ($row = $result_teacher_classes->fetch_assoc()) {
    $teacher_classes[] = $row['classteacher'];
}
$stmt_teacher_classes->close();

// Check if the form to choose class is submitted
if (isset($_POST['choose_class'])) {
    // Retrieve the selected class
    $selected_class = $_POST['class'];

    // Check if the teacher has access to the selected class
    if (in_array($selected_class, $teacher_classes)) {
        // The teacher has access to the selected class
        $access_granted = true;

        // Get the appropriate table name based on the selected class
        $attendance_table_name = 'attendance' . $selected_class;

        // Query to fetch the attendance records from the specific class table
        $sql_attendance = "SELECT students.firstname, students.middlename, students.lastname, $attendance_table_name.attendance_status, $attendance_table_name.uploaded_date FROM $attendance_table_name INNER JOIN students ON $attendance_table_name.studentID = students.studentID WHERE students.class = ?";
        $stmt_attendance = $conn->prepare($sql_attendance);
        $stmt_attendance->bind_param("s", $selected_class);
        $stmt_attendance->execute();
        $result_attendance = $stmt_attendance->get_result();

        // Fetch attendance records into an array
        while ($row = $result_attendance->fetch_assoc()) {
            $attendance_records[] = $row;
        }
        $stmt_attendance->close();
    } else {
        // The teacher doesn't have access to the selected class
        $access_granted = false;
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
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        /* Form Container Styles */
        .form-container {
            max-width: 600px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
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

        /* Attendance Container Styles */
        .attendance-container {
            margin: 20px auto;
            overflow-x: auto;
        }
        .attendance-container table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }
        .attendance-container th,
        .attendance-container td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .attendance-container th {
            background-color: #f2f2f2;
        }

        /* Responsive Styles */
        @media only screen and (max-width: 600px) {
            .form-container,
            .attendance-container {
                max-width: 90%;
                margin: 20px auto;
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
    <h2>View Attendance Records</h2>

    <form action="" method="POST">
        <button type="submit" name="view_attendance">View Students</button>
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
        echo "<p>You don't have access to view attendance records for this class.</p>";
    } else if ($access_granted === true && empty($attendance_records)) {
        echo "<p>No attendance records uploaded yet for the selected class.</p>";
    }
    ?>
</div>

<?php
if (!empty($attendance_records)) {
    ?>
    <div class="attendance-container">
        <h3>Attendance Records</h3>

        <table>
            <thead>
            <tr>
                <th>Student Name</th>
                <th>Attendance Status</th>
                <th>Attendance Date</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($attendance_records as $record): ?>
                <tr>
                    <td><?php echo $record['firstname'] . ' ' . $record['middlename'] . ' ' . $record['lastname']; ?></td>
                    <td><?php echo $record['attendance_status']; ?></td>
                    <td><?php echo $record['uploaded_date']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php } ?>

</body>
</html>
