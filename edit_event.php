<?php
include 'session.php';
// Include the database connection file
include 'database.php';

// Check if event ID is provided
if(isset($_GET['eventID'])) {
    $event_id = $_GET['eventID'];

    // Retrieve event details from the database
    $event_query = "SELECT * FROM events WHERE eventID = $event_id";
    $event_result = $conn->query($event_query);

    if ($event_result->num_rows == 1) {
        $event_row = $event_result->fetch_assoc();
    } else {
        // Event not found, handle error or redirect
        header("Location: error.php");
        exit();
    }
}

// Check if the form is submitted
if(isset($_POST['submit'])) {
    // Retrieve form data
    $title = $_POST['title'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    // Update the event in the database
    $update_event_query = "UPDATE events SET title='$title', date='$date', time='$time', location='$location', description='$description' WHERE eventID = $event_id";
    if ($conn->query($update_event_query) === TRUE) {
        // Redirect to a success page or display a success message
        header("refresh:2; url=view_event.php");
        echo "<p>Update Event Successfully</p>";
        exit();
    } else {
        // Handle errors if any
        echo "Error: " . $update_event_query . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1900px;
            margin: 70px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            position: relative;
        }

        h2::after {
            content: '';
            display: block;
            width: 100%;
            height: 3px;
            background-color: #4CAF50;
            position: absolute;
            bottom: -5px;
            left: 0;
        }

        form {
            margin-top: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"],
        input[type="time"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .back-to-dashboard {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 999;
        }

        .back-to-dashboard:hover {
            background-color: #45a049;
        }

        /* Responsive layout */
        @media only screen and (max-width: 768px) {
            .container {
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
    <a href="dashboard.php" class="back-to-dashboard">Back to Dashboard</a>

    <div class="container">
        <h2>EDIT AND UPDATE EVENT DETAILS</h2>
        <form action="update_event.php?eventID=<?php echo $event_id; ?>" method="post">
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title" value="<?php echo $event_row['title']; ?>" required><br>
            
            <label for="date">Date:</label><br>
            <input type="date" id="date" name="date" value="<?php echo $event_row['date']; ?>" required><br>
            
            <label for="time">Time:</label><br>
            <input type="time" id="time" name="time" value="<?php echo $event_row['time']; ?>" required><br>
            
            <label for="location">Location:</label><br>
            <input type="text" id="location" name="location" value="<?php echo $event_row['location']; ?>"><br>
            
            <label for="description">Description:</label><br>
            <textarea id="description" name="description" rows="4"><?php echo $event_row['description']; ?></textarea><br>
            
            <input type="submit" name="submit" value="Update">
        </form>
    </div>
</body>
</html>


