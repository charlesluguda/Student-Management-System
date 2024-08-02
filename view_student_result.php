<?php
include 'session.php';
include 'database.php';

$result_row = null; // Initialize $result_row to null

// Check if studentID is set and is a valid integer
if(isset($_GET['studentID']) && filter_var($_GET['studentID'], FILTER_VALIDATE_INT)) {
    $studentID = $_GET['studentID'];

    // Retrieve student details including picture from students table
    $student_sql = "SELECT * FROM students WHERE studentID = $studentID";
    $student_result = $conn->query($student_sql);
    
    if ($student_result && $student_result->num_rows > 0) {
        $student_row = $student_result->fetch_assoc();

        // Retrieve student results from results table including grades
        $result_sql = "SELECT *, (SELECT COUNT(*) FROM students) AS total_students,
                    CASE
                        WHEN mathematics >= 80 AND mathematics <= 100 THEN 'A'
                        WHEN mathematics >= 60 AND mathematics <= 79 THEN 'B'
                        WHEN mathematics >= 45 AND mathematics <= 59 THEN 'C'
                        WHEN mathematics >= 30 AND mathematics <= 44 THEN 'D'
                        ELSE 'F'
                    END AS math_grade,
                    CASE
                        WHEN science >= 80 AND science <= 100 THEN 'A'
                        WHEN science >= 60 AND science <= 79 THEN 'B'
                        WHEN science >= 45 AND science <= 59 THEN 'C'
                        WHEN science >= 30 AND science <= 44 THEN 'D'
                        ELSE 'F'
                    END AS science_grade,
                    CASE
                        WHEN english >= 80 AND english <= 100 THEN 'A'
                        WHEN english >= 60 AND english <= 79 THEN 'B'
                        WHEN english >= 45 AND english <= 59 THEN 'C'
                        WHEN english >= 30 AND english <= 44 THEN 'D'
                        ELSE 'F'
                    END AS english_grade,
                    CASE
                        WHEN history >= 80 AND history <= 100 THEN 'A'
                        WHEN history >= 60 AND history <= 79 THEN 'B'
                        WHEN history >= 45 AND history <= 59 THEN 'C'
                        WHEN history >= 30 AND history <= 44 THEN 'D'
                        ELSE 'F'
                    END AS history_grade,
                    CASE
                        WHEN geography >= 80 AND geography <= 100 THEN 'A'
                        WHEN geography >= 60 AND geography <= 79 THEN 'B'
                        WHEN geography >= 45 AND geography <= 59 THEN 'C'
                        WHEN geography >= 30 AND geography <= 44 THEN 'D'
                        ELSE 'F'
                    END AS geography_grade
                FROM results WHERE studentID = $studentID";

        $result_result = $conn->query($result_sql);
        if ($result_result && $result_result->num_rows > 0) {
            $result_row = $result_result->fetch_assoc();
        } else {
            // Handle no results found
            $result_row = null; // Set result_row to null if no results found
        }
    } else {
        // Handle no student found
        $student_row = null; // Set student_row to null if no student found
    }
} else {
    // Handle invalid or missing studentID parameter
    $student_row = null; // Set student_row to null if studentID parameter is missing or invalid
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Result</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        .student-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .student-info img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-right: 20px;
        }

        .student-info h2 {
            margin: 0;
        }

        .result-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .result-table th, .result-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .result-table th {
            background-color: #4CAF50;
            color: white;
        }

        .result-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .result-table tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if($student_row): ?>
            <div class="student-info">
                <img src="uploads/<?php echo $student_row['picture']; ?>" alt="Student Picture">
                <h2><?php echo $student_row['firstname'] . ' ' . $student_row['middlename'] . ' ' . $student_row['lastname']; ?></h2>
            </div>
        <?php endif; ?>
        <?php if($result_row): ?>
            <table class="result-table">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Score</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Mathematics</td>
                        <td><?php echo $result_row['mathematics']; ?></td>
                        <td><?php echo $result_row['math_grade']; ?></td>
                    </tr>
                    <tr>
                        <td>Science</td>
                        <td><?php echo $result_row['science']; ?></td>
                        <td><?php echo $result_row['science_grade']; ?></td>
                    </tr>
                    <tr>
                        <td>English</td>
                        <td><?php echo $result_row['english']; ?></td>
                        <td><?php echo $result_row['english_grade']; ?></td>
                    </tr>
                    <tr>
                        <td>History</td>
                        <td><?php echo $result_row['history']; ?></td>
                        <td><?php echo $result_row['history_grade']; ?></td>
                    </tr>
                    <tr>
                        <td>Geography</td>
                        <td><?php echo $result_row['geography']; ?></td>
                        <td><?php echo $result_row['geography_grade']; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3"><br></td>
                    </tr>
                    <tr>
                        <td><strong>Total Marks</strong></td>
                        <td colspan="2"><?php echo $result_row['total_marks']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Average</strong></td>
                        <td colspan="2"><?php echo $result_row['average']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Grade</strong></td>
                        <td colspan="2"><?php echo $result_row['grade']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Position</strong></td>
                        <td colspan="2"><?php echo $result_row['position']; ?> out of <?php echo $result_row['total_students']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Remark</strong></td>
                        <td colspan="2"><?php echo $result_row['remark']; ?></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <p>No results found for this student.</p>
        <?php endif; ?>
    </div>
</body>
</html>
