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
            max-width: 1450px;
            margin: 10px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-family : Times New Roman;
            color : #1e1e75;
        }

        form {
            margin-top: 0px;
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
            font-size : 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        .dashboard-btn {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 5px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .dashboard-btn:hover {
            background-color: #2980b9;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        @media screen and (max-width: 768px) {
    .container {
        padding: 5px;
    }

    
}
.separator{
    height : 2px;
    background-color : #6a69a1;
}
    </style>
</head>
<body>
<a href="dashboard.php" class="dashboard-btn">Go to Dashboard</a>

    <div class="container">
        <h1>Update Student Results</h1>
        <hr class = "separator">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Hidden input field to capture studentID -->
            <input type="hidden" id="studentID" name="studentID" value="<?php echo isset($_GET['studentID']) ? $_GET['studentID'] : 'Unknown'; ?>">

            <?php
             include './Includes/database.php';
            // Check if results already exist for the student
            $studentID = isset($_GET['studentID']) ? $_GET['studentID'] : null;
            if ($studentID) {
                $existing_result_sql = "SELECT * FROM results WHERE studentID = '$studentID'";
                $existing_result_result = $conn->query($existing_result_sql);
                if ($existing_result_result->num_rows > 0) {
                    $row = $existing_result_result->fetch_assoc();
                    $mathematics = $row['mathematics'];
                    $science = $row['science'];
                    $english = $row['english'];
                    $history = $row['history'];
                    $geography = $row['geography'];
                }
            } else {
                // Initialize marks if no results found
                $mathematics = '';
                $science = '';
                $english = '';
                $history = '';
                $geography = '';
            }
            ?>

            <label for="mathematics">Mathematics:</label>
            <input type="number" id="mathematics" name="mathematics" value="<?php echo $mathematics; ?>" required>

            <label for="science">Science:</label>
            <input type="number" id="science" name="science" value="<?php echo $science; ?>" required>

            <label for="english">English:</label>
            <input type="number" id="english" name="english" value="<?php echo $english; ?>" required>

            <label for="history">History:</label>
            <input type="number" id="history" name="history" value="<?php echo $history; ?>" required>

            <label for="geography">Geography:</label>
            <input type="number" id="geography" name="geography" value="<?php echo $geography; ?>" required>

            <input type="submit" name="upload_results" value="Update Results">
        </form>
        <br>
    
    </div>

    <?php
// Handle form submission
if (isset($_POST['upload_results'])) {
    $studentID = $_POST['studentID'];
    $mathematics = $_POST['mathematics'];
    $science = $_POST['science'];
    $english = $_POST['english'];
    $history = $_POST['history'];
    $geography = $_POST['geography'];

    // Calculate total marks
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

    // Update existing results if they exist, otherwise insert new results
    if ($studentID) {
        $update_sql = "UPDATE results SET mathematics='$mathematics', science='$science', english='$english', history='$history', geography='$geography', total_marks='$total_marks', average='$average', grade='$grade', remark='$remarks' WHERE studentID='$studentID'";
        if ($conn->query($update_sql) === TRUE) {
            // Recalculate positions
            recalculatePositions($conn);
            header("refresh:2;url=all_result.php");

            echo "<p>Results updated successfully</p>";
        } else {
            echo "<p>Error updating results: " . $conn->error . "</p>";
        }
    } else {
        // Insert new results
        $insert_sql = "INSERT INTO results (studentID, mathematics, science, english, history, geography, total_marks, average, grade, remark) VALUES ('$studentID', '$mathematics', '$science', '$english', '$history', '$geography', '$total_marks', '$average', '$grade', '$remarks')";
        if ($conn->query($insert_sql) === TRUE) {
            // Recalculate positions
            recalculatePositions($conn);
            echo "<p>Results updated successfully</p>";

        } else {
            echo "<p>Error updating results: " . $conn->error . "</p>";
        }
    }
}

// Function to recalculate positions
function recalculatePositions($conn) {
    // Retrieve all students ordered by average score
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
}
?>


</body>
</html>
