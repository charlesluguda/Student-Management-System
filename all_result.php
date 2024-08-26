<?php
include 'session.php';
include './Includes/database.php';

// Retrieve all student results
$results_sql = "SELECT students.studentID, CONCAT(students.firstname, ' ', students.middlename, ' ', students.lastname) AS fullname, results.mathematics, results.science, results.english, results.history, results.geography, results.total_marks, results.average, results.grade, results.position, results.remark FROM students INNER JOIN results ON students.studentID = results.studentID";
$results_result = $conn->query($results_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Student Results</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-iiR5QyaMqjw2m/4PfPtFVynTXCjTKhHHw7D+z13Lvp2l13Hq29ZBgefQsF2i6/IqGY7M1KdYAnw1YXqy1F6tGA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Add your CSS styles here */
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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

        .actions {
            text-align: center;
        }

        .actions a {
            text-decoration: none;
            color: White;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px; /* Adjust font size */
        }

        .actions a:hover {
            color: red;
        }

        .icon {
            margin-right: 5px;
        }

        .button {
            font-family: 'Times New Roman', Times, serif;
            font-size: 16px; /* Adjust font size */
            padding: 6px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>All Student Results</h1>
    <table>
        <thead>
            <tr>
                <th>S.NO</th>
                <th>Full Name</th>
                <th>Mathematics</th>
                <th>Science</th>
                <th>English</th>
                <th>History</th>
                <th>Geography</th>
                <th>Total Marks</th>
                <th>Average</th>
                <th>Grade</th>
                <th>Position</th>
                <th>Remark</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($results_result->num_rows > 0) {
                $count = 1;
                while ($row = $results_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $count . "</td>";
                    echo "<td>" . $row['fullname'] . "</td>";
                    echo "<td>" . $row['mathematics'] . "</td>";
                    echo "<td>" . $row['science'] . "</td>";
                    echo "<td>" . $row['english'] . "</td>";
                    echo "<td>" . $row['history'] . "</td>";
                    echo "<td>" . $row['geography'] . "</td>";
                    echo "<td>" . $row['total_marks'] . "</td>";
                    echo "<td>" . $row['average'] . "</td>";
                    echo "<td>" . $row['grade'] . "</td>";
                    echo "<td>" . $row['position'] . "</td>";
                    echo "<td>" . $row['remark'] . "</td>";
                    echo "<td class='actions'><a href='view_student_result.php?studentID=" . $row['studentID'] . "' class='button'>View Results</a></td>";
                    echo "</tr>";
                    $count++;
                }
            } else {
                echo "<tr><td colspan='13'>No results found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
