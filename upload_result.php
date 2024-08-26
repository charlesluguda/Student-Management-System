<?php
include 'session.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Student Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            width: 90%;
            max-width: 1500px;
            margin: 0px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

    .separator {
        background-color : #1e5eef;
        height:3px;
       width:420px;
       margin-left : 0px;
      
        }

        .container img {
            display: block;
            float: left;
            margin-right: 20px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .student-info {
            overflow: hidden;
        }

        .student-name {
            font-size: 24px;
            line-height: 100px;
        }

        form {
            margin-top: 20px;
            clear: both;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .dashboard-btn {
    max-width: 150px;
    margin: 10px 20px;
    padding: 5px;
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    display: inline-block;
    text-align: left;
    text-decoration: none;
}

        .dashboard-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <a href="dashboard.php" class="dashboard-btn">Go to Dashboard</a>
    <div class="container">
        <?php
        include './Includes/database.php';
        // Fetch student information from the database based on studentID
        $studentID = isset($_GET['studentID']) ? $_GET['studentID'] : 'Unknown';
        $student_info_sql = "SELECT * FROM students WHERE studentID = '$studentID'";
        $student_info_result = $conn->query($student_info_sql);

        if ($student_info_result->num_rows > 0) {
            $student_info_row = $student_info_result->fetch_assoc();
            $studentImage = 'uploads/' . $student_info_row['picture']; // Assuming 'picture' is the column name in the students table
            $studentName = $student_info_row['firstname'] . ' ' . $student_info_row['middlename'] . ' ' . $student_info_row['lastname'];
        } else {
            $studentName = 'Unknown Student';
        }
        ?>

        <div class="student-info">
            <img src="<?php echo $studentImage; ?>" alt="<?php echo $studentName; ?>">
            <div class="student-name"><?php echo $studentName; ?></div>
        </div>
        <hr class ="separator">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Hidden input field to capture studentID -->
            <input type="hidden" id="studentID" name="studentID" value="<?php echo $studentID; ?>">

            <!-- Form inputs -->
            <label for="mathematics">Mathematics:</label>
            <input type="number" id="mathematics" name="mathematics" required>

            <label for="science">Science:</label>
            <input type="number" id="science" name="science" required>

            <label for="english">English:</label>
            <input type="number" id="english" name="english" required>

            <label for="history">History:</label>
            <input type="number" id="history" name="history" required>

            <label for="geography">Geography:</label>
            <input type="number" id="geography" name="geography" required>

            <input type="submit" name="upload_results" value="Upload Results">
        </form>

        <?php
        include 'database.php';

        // Check if the form is submitted
        if (isset($_POST['upload_results'])) {
            // Retrieve form data
            $studentID = $_POST['studentID'];
            $mathematics = $_POST['mathematics'];
            $science = $_POST['science'];
            $english = $_POST['english'];
            $history = $_POST['history'];
            $geography = $_POST['geography'];

            // Check if results already exist for the student
            $existing_result_sql = "SELECT * FROM results WHERE studentID = '$studentID'";
            $existing_result_result = $conn->query($existing_result_sql);

            if ($existing_result_result->num_rows > 0) {
                echo "<script>alert('Results already uploaded for this student. You cannot upload again.'); window.location.href = 'students_result.php';</script>";
            } else {
                // Calculate sum
                $total_marks = $mathematics + $science + $english + $history + $geography;

                // Calculate average
                $average = $total_marks / 5;

                // Determine grade and remarks
                if ($average >= 80 && $average <= 100) {
                    $grade = 'A';
                    $remarks = 'Excellent';
                } elseif ($average >= 60 && $average <= 79) {
                    $grade = 'B';
                    $remarks = 'Very Good';
                } elseif ($average >= 50 && $average <= 59) {
                    $grade = 'C';
                    $remarks = 'Good';
                } elseif ($average >= 40 && $average <= 49) {
                    $grade = 'D';
                    $remarks = 'Average';
                } elseif ($average >= 30 && $average <= 39) {
                    $grade = 'E';
                    $remarks = 'Satisfactory';
                } else {
                    $grade = 'F';
                    $remarks = 'Fail';
                }

                // Assuming you have a table named 'results' with columns: studentID, mathematics, science, english, history, geography, total_marks, average, grade, remarks
                $insert_sql = "INSERT INTO results (studentID, mathematics, science, english, history, geography, total_marks, average, grade, remark) VALUES ('$studentID', '$mathematics', '$science', '$english', '$history', '$geography', '$total_marks', '$average', '$grade','$remarks')";

                if ($conn->query($insert_sql) === TRUE) {
                    // Calculate position
                    $position_sql = "SELECT studentID, average FROM results ORDER BY average DESC";
                    $position_result = $conn->query($position_sql);

                    // Initialize position counter
                    $position = 1;
                    $prev_average = null;

                    // Iterate through the results to assign positions
                    while ($row = $position_result->fetch_assoc()) {
                        if ($prev_average === null || $row['average'] !== $prev_average) {
                            $prev_average = $row['average'];
                            $update_position_sql = "UPDATE results SET position = '$position' WHERE studentID = '" . $row['studentID'] . "'";
                            $conn->query($update_position_sql);
                        }
                        $position++;
                    }
                    echo "<script>alert('Results uploaded successfully.'); window.location.href = 'students_result.php';</script>";
                } else {
                    echo "<script>alert('Failed to upload results.');</script>";
                }
            }
        }
        ?>
    </div>
</body>
</html>
