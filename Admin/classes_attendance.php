<?php
include '../session.php';
include '../Includes/database.php';

// Initialize variables
$access_granted = false;
$attendance_records = [];

// Function to sanitize user input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_class = sanitize_input($_POST['class']);

    // Get the appropriate table name based on the selected class
    $attendance_table_name = 'attendance' . $selected_class;

    // Initialize search parameters
    $search_student = isset($_POST['search_student']) ? sanitize_input($_POST['search_student']) : '';
   

    // Construct the SQL query with search parameters
    $sql_attendance = "SELECT students.firstname, students.middlename, students.lastname, $attendance_table_name.attendance_status, $attendance_table_name.uploaded_date FROM $attendance_table_name INNER JOIN students ON $attendance_table_name.studentID = students.studentID WHERE students.class = ?";
    // Add selected class as a parameter
    $params = array($selected_class);

    // Add search conditions if any
    if (!empty($search_student)) {
        $sql_attendance .= " AND CONCAT(students.firstname, ' ', students.middlename, ' ', students.lastname) LIKE ?";
        $params[] = "%$search_student%";
    }
   

    // Prepare and execute the SQL query
    $stmt_attendance = $conn->prepare($sql_attendance);
    $stmt_attendance->bind_param(str_repeat("s", count($params)), ...$params); // Bind all parameters
    $stmt_attendance->execute();
    $result_attendance = $stmt_attendance->get_result();

    // Fetch attendance records into an array
    while ($row = $result_attendance->fetch_assoc()) {
        $attendance_records[] = $row;
    }
    $stmt_attendance->close();

    // Set access granted flag to true
    $access_granted = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance Records</title>
     <link rel="stylesheet" href="./css/classes_attendance.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>
<body>
<div class="back-card">
        <img src="images/logo.jpg" alt="Logo">
        <h2>Attendance Record's</h2>
        <button onclick="window.location.href='admin_dashboard.php'">BACK</button>
</div>
<div class="attendance-container">
    <h2>View Attendance Records</h2>

    <!-- Form for selecting class and searching student and subject -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="search-form">
        <select id="class" name="class" required>
            <option value="" disabled selected>Select Class</option>
            <?php for ($i = 1; $i <= 7; $i++) : ?>
                <option value="<?php echo $i; ?>"><?php echo "Class $i"; ?></option>
            <?php endfor; ?>
        </select>

        <input type="text" name="search_student" placeholder="Search Student Name" value="<?php echo isset($search_student) ? $search_student : ''; ?>">
        
        <button type="submit" name="select_class">Submit</button>
    </form>

    <!-- Display attendance records -->
    <?php if ($access_granted && !empty($attendance_records)) : ?>
        <h3 style="text-align: center;">Attendance Records for Class <?php echo $selected_class; ?></h3>
        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Attendance Status</th>
                    <th>Attendance Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attendance_records as $record) : ?>
                    <tr>
                        <td><?php echo $record['firstname'] . ' ' . $record['middlename'] . ' ' . $record['lastname']; ?></td>
                        <td><?php echo $record['attendance_status']; ?></td>
                        <td><?php echo $record['uploaded_date']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($access_granted && empty($attendance_records)) : ?>
        <p>No attendance records found for Class <?php echo $selected_class; ?></p>
    <?php endif; ?>
</div>

</body>
</html>
