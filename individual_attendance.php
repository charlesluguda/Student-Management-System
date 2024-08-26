<?php
// Include the database connection file
include 'session.php';
include './Includes/database.php';

// Retrieve the studentID from the URL parameter
$studentID = $_GET['studentID'];

// Query the database to retrieve the student's full name, picture path, and attendance data
$student_query = "SELECT CONCAT(firstname, ' ', COALESCE(middlename, ''), ' ', lastname) AS full_name, picture FROM students WHERE studentID = ?";
$stmt = $conn->prepare($student_query);
$stmt->bind_param("i", $studentID);
$stmt->execute();
$student_result = $stmt->get_result();
$student_row = $student_result->fetch_assoc();
$full_name = $student_row['full_name'];
$picture_path = $student_row['picture'];

// Query the database to retrieve the attendance data for the student
$attendance_query = "SELECT attendance_date, attendance_status FROM attendance WHERE studentID = ?";
$stmt = $conn->prepare($attendance_query);
$stmt->bind_param("i", $studentID);
$stmt->execute();
$attendance_result = $stmt->get_result();

// Initialize variables to count present, absent, and permission days
$count_present = 0;
$count_absent = 0;
$count_permission = 0;

// Loop through the attendance data to count present, absent, and permission days
while ($attendance_row = $attendance_result->fetch_assoc()) {
    switch ($attendance_row['attendance_status']) {
        case 'PRESENT':
            $count_present++;
            break;
        case 'ABSENT':
            $count_absent++;
            break;
        case 'PERMISSION':
            $count_permission++;
            break;
        // Add more cases for additional statuses if needed
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Individual Attendance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 10px auto;
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            padding: 10px;
            border-radius: 8px;
            margin-top: 10px;
        }

        h3 {
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .student-picture {
            display: block;
            margin: 0 auto;
            width: 130px;
            height: 130px;
            border-radius: 50%;
            overflow: hidden;
            background-color: #ddd; /* Background color for the picture */
        }

        .student-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Individual Attendance</h2>
        <?php if (!empty($picture_path)): ?>
            <div class="student-picture">
                <img src="uploads/<?php echo $picture_path; ?>" alt="Student Picture">
            </div>
        <?php endif; ?>
        <h3><?php echo $full_name; ?></h3>
        <table>
            <thead>
                <tr>
                    <th>Attendance Date</th>
                    <th>Attendance Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Reset the pointer of the attendance result set
                mysqli_data_seek($attendance_result, 0);
                while ($attendance_row = $attendance_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $attendance_row['attendance_date']; ?></td>
                        <td><?php echo $attendance_row['attendance_status']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div style="margin-top: 20px; text-align: center;">
            <p style="font-size: 18px; color: #4CAF50;">Total Present Days: <?php echo $count_present; ?></p>
            <p style="font-size: 18px; color: #FF0000;">Total Absent Days: <?php echo $count_absent; ?></p>
            <p style="font-size: 18px; color: #007bff;">Total Permission Days: <?php echo $count_permission; ?></p>
        </div>
    </div>
</body>
</html>
