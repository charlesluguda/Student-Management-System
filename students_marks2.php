<?php
include 'session.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 100wh;
            margin: 0 auto;
            padding: 20px;
        }

        .back-button {
            margin-bottom: 20px;
        }

        .back-button button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .back-button button:hover {
            background-color: #45a049;
        }

        .back-button .back-arrow {
            margin-right: 5px;
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }

        .title-text {
            background-color: #fff;
            padding: 0 10px;
            font-size: 25px;
            font-weight: bold;
            position: relative;
        }

        .title-line {
            position: absolute;
            width: 100%;
            bottom: -10px;
            left: 0;
            border-bottom: 3px solid #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            transition: background-color 0.3s; /* Added transition for hover effect */
        }

        th {
            background-color: #4e62f1;
        }

        /* Added hover effect */
        tr:hover {
            background-color: #f2f2f2;
            cursor: pointer;
        }

        .button-container {
            text-align: right;
        }

        .button-container button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 10px 24px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-right: 0px;
            cursor: pointer;
            border-radius: 5px;
        }

        .button-container button:hover {
            background-color: #45a049;
        }

        @media only screen and (max-width: 768px) {
            table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="back-button">
        <button><a href ="dashboard.php" style="text-decoration : none;">
            <span class="back-arrow">&#8592;</span> Back to Dashboard
    </a>
        </button>
    </div>
    <div class="title">
        <span class="title-text">Panel to Upload Student Results</span>
        <div class="title-line"></div>
    </div>
    <?php
   
    // Include database connection file
    include 'database.php';

    // Fetch students data from the database
    $sql = "SELECT studentID, firstname, middlename, lastname, class FROM students";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        ?>
        <table>
            <tr>
                <th>Sno</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Class</th>
                <th>Actions</th>
            </tr>
            <?php
            $sno = 1;
            while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $sno; ?></td>
                    <td><?php echo $row['firstname']; ?></td>
                    <td><?php echo $row['middlename']; ?></td>
                    <td><?php echo $row['lastname']; ?></td>
                    <td><?php echo $row['class']; ?></td>
                    <td>
                        <button onclick="window.location.href='upload_result.php?studentID=<?php echo $row['studentID']; ?>'">Add marks</button>
                        <button onclick="window.location.href='edit_result.php?studentID=<?php echo $row['studentID']; ?>'">Edit marks</button>
                    </td>
                </tr>
                <?php $sno++; ?>
            <?php } ?>
        </table>
        <?php
    } else {
        echo "No students found.";
    }
    ?>
</div>

<script>
    // JavaScript function to navigate back to the previous page
    function goBack() {
        window.history.back();
    }
</script>

</body>
</html>
