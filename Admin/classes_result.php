<?php
include '../session.php';
include '../Includes/database.php';

// Initialize variables to store selected class, semester, and month
$selected_class = $selected_semester = $selected_month = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve selected class from the form
    $selected_class = $_POST['class'];
    // Construct the table name based on the selected class
    $table_name = 'std' . $selected_class . '_results';

    // Retrieve selected semester and month from the form
    $selected_semester = $_POST['semester'];
    $selected_month = $_POST['month'];

    // Fetch and display student results only if all selections are made
    if (!empty($selected_class) && !empty($selected_semester) && !empty($selected_month)) {
        // Fetch student results for the selected class, semester, and month
        $sql_results = "SELECT * FROM $table_name 
                        WHERE semester = '$selected_semester' AND month = '$selected_month'";
        $result_results = $conn->query($sql_results);

        // Check if query was successful
        if ($result_results && $result_results->num_rows > 0) {
            // Array to hold student results with calculated averages
            $students = [];
            
            // Loop through the results to calculate total marks, average, and grade for each student
            while ($row = $result_results->fetch_assoc()) {
                // Calculate total marks
                $total_marks = $row['kiswahili'] + $row['english'] + $row['history'] + $row['science'] + $row['mathematics'];
                // Calculate average
                $average = $total_marks / 5;
                // Calculate grade
                if ($average >= 80) {
                    $grade = 'A';
                } elseif ($average >= 60) {
                    $grade = 'B';
                } elseif ($average >= 40) {
                    $grade = 'C';
                } elseif ($average >= 21) {
                    $grade = 'D';
                } else {
                    $grade = 'F';
                }
                
                // Add student data to the array
                $students[] = [
                    'studentID' => $row['studentID'],
                    'fullname' => $row['fullname'],
                    'kiswahili' => $row['kiswahili'],
                    'english' => $row['english'],
                    'history' => $row['history'],
                    'science' => $row['science'],
                    'mathematics' => $row['mathematics'],
                    'total_marks' => $total_marks,
                    'average' => $average,
                    'grade' => $grade,
                    'semester' => $row['semester'],
                    'month' => $row['month']
                ];

                // Update the database with total marks, average, and grade
                $update_sql = "UPDATE $table_name 
                               SET total_marks = ?, average = ?, grade = ? 
                               WHERE studentID = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("dssi", $total_marks, $average, $grade, $row['studentID']);
                $update_stmt->execute();
                $update_stmt->close();
            }

            // Sort students by average in descending order
            usort($students, function($a, $b) {
                return $b['average'] <=> $a['average'];
            });

            // Display results table
            echo "<div class='container'>";
            echo "<h2>Student Results</h2>";
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>S/NO</th>";
            echo "<th>Full Name</th>";
            echo "<th>Kiswahili</th>";
            echo "<th>English</th>";
            echo "<th>History</th>";
            echo "<th>Science</th>";
            echo "<th>Mathematics</th>";
            echo "<th>Total Marks</th>";
            echo "<th>Average</th>";
            echo "<th>Grade</th>";
            echo "<th>Position</th>";
            echo "<th>Semester</th>";
            echo "<th>Month</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            
            $position = 1;
            $last_average = null;
            $last_position = 0;

            // Prepare a statement for updating the position in the database
            $update_position_stmt = $conn->prepare("UPDATE $table_name SET position = ? WHERE studentID = ?");

            // Assign positions and display the student details
            foreach ($students as $student) {
                if ($student['average'] == $last_average) {
                    $student_position = $last_position;
                } else {
                    $student_position = $position;
                }

                $last_average = $student['average'];
                $last_position = $student_position;

                // Update the database with the calculated position
                $update_position_stmt->bind_param("ii", $student_position, $student['studentID']);
                $update_position_stmt->execute();

                // Display the student details in the table row
                echo "<tr>";
                echo "<td>$position</td>";
                echo "<td>{$student['fullname']}</td>";
                echo "<td>{$student['kiswahili']}</td>";
                echo "<td>{$student['english']}</td>";
                echo "<td>{$student['history']}</td>";
                echo "<td>{$student['science']}</td>";
                echo "<td>{$student['mathematics']}</td>";
                echo "<td>" . number_format($student['total_marks'], 1) . "</td>";
                echo "<td>" . number_format($student['average'], 1) . "</td>";
                echo "<td>{$student['grade']}</td>";
                echo "<td>$student_position</td>";
                echo "<td>{$student['semester']}</td>";
                echo "<td>{$student['month']}</td>";
                echo "</tr>";
                $position++;
            }

            echo "</tbody>";
            echo "</table>";
            echo "</div>";

            // Close the prepared statement
            $update_position_stmt->close();
        } else {
            // If no results found, display message
            echo "<div class='container'>";
            echo "<h2>Student Results</h2>";
            echo "<p>No results found for Class $selected_class, Semester $selected_semester, Month $selected_month</p>";
            echo "</div>";
        }
    } else {
        // If any of the selections are empty, display a message
        echo "<div class='container'>";
        echo "<h2>Student Results</h2>";
        echo "<p>Please select Class, Semester, and Month</p>";
        echo "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Results</title>

    <link rel="stylesheet" href="./css/classes_results.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>
<body>
<div class="back-card">
        <img src="images/logo.jpg" alt="Logo">
        <h2>Student's Results</h2>
        <button onclick="window.location.href='admin_dashboard.php'">BACK</button>
</div>
<div class="container">
    <h2>View Student Results</h2>
    <!-- Form for selecting class, semester, and month -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <!-- Select Class -->
        <div class="form-group">
        <label for="class">Select Class:</label>
        <select id="class" name="class" required>
            <option value="" disabled <?php if (empty($selected_class)) echo "selected"; ?>>Select Class</option>
            <?php for ($i = 1; $i <= 7; $i++) : ?>
                <option value="<?php echo $i; ?>" <?php if ($selected_class == $i) echo "selected"; ?>><?php echo "Class $i"; ?></option>
            <?php endfor; ?>
        </select>
        </div>

        <!-- Select Semester -->
        <div class="form-group">
        <label for="semester">Select Semester:</label>
        <select id="semester" name="semester" required>
            <option value="" disabled <?php if (empty($selected_semester)) echo "selected"; ?>>Select Semester</option>
            <option value="Mid Term" <?php if ($selected_semester == "Mid Term") echo "selected"; ?>>Mid Term</option>
            <option value="Annually" <?php if ($selected_semester == "Annually") echo "selected"; ?>>Annually</option>
            <option value="Semi-Annually" <?php if ($selected_semester == "Semi-Annually") echo "selected"; ?>>Semi-Annually</option>
        </select>
        </div>

        <!-- Select Month -->
     <div class="form-group">
     <label for="month">Select Month:</label>
        <select id="month" name="month" required>
            <option value="" disabled <?php if (empty($selected_month)) echo "selected"; ?>>Select Month</option>
            <?php
            $months = array(
                "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
            );

            foreach ($months as $month) {
                echo "<option value='$month' " . ($selected_month == $month ? "selected" : "") . ">$month</option>";
            }
            ?>
        </select>
     </div>

        <button type="submit" name="submit">Submit</button>
    </form>
</div>
</body>
</html>
