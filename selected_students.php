<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selected Students</title>
    <style>
        /* CSS styles for the student list */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        li {
            background-color: #f0f0f0;
            border-radius: 5px;
            margin-bottom: 10px;
            padding: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Selected Students</h1>
    <ul>
        <?php
        // Retrieve the selected students' data passed from the previous page
        if (isset($_POST['selected_students']) && is_array($_POST['selected_students'])) {
            $selected_students = $_POST['selected_students'];
            foreach ($selected_students as $student) {
                echo "<li>{$student}</li>";
            }
        } else {
            echo "<li>No students selected.</li>";
        }
        ?>
    </ul>
</div>
</body>
</html>
