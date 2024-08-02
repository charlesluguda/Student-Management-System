<?php
include 'session.php';
include 'database.php';

// Check if student_id is provided
if (isset($_GET['studentID'])) {
    // Retrieve student details from the database based on the provided student_id
    $student_id = $_GET['studentID'];
    $sql_student = "SELECT * FROM students WHERE studentID = $student_id";
    $result_student = $conn->query($sql_student);

    if ($result_student && $result_student->num_rows > 0) {
        // Fetch student details
        $student = $result_student->fetch_assoc();
        // Retrieve student results from the database based on the provided student_id
        $sql_results = "SELECT * FROM student_results WHERE studentID = $student_id";
        $result_results = $conn->query($sql_results);
    } else {
        // Redirect to an error page if student details are not found
        header("Location: error.php");
        exit();
    }
} else {
    // Redirect to an error page if student_id is not provided
    header("Location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Student Details</h2>
        <div class="student-info">
            <div class="student-profile">
                <img src="<?php echo $student['picture']; ?>" alt="Student Picture">
                <h3><?php echo $student['fullname']; ?></h3>
                <p>Class: <?php echo $student['class']; ?></p>
            </div>
            <div class="student-results">
                <h3>Results</h3>
                <?php if ($result_results && $result_results->num_rows > 0) : ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Marks</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result_results->fetch_assoc()) : ?>
                                <tr>
                                    <td><?php echo $row['subject']; ?></td>
                                    <td><?php echo $row['marks']; ?></td>
                                    <td><?php echo $row['grade']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p>No results found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
