<?php
include './Includes/database.php';

$students = [];
$comments = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];

    $query = "SELECT * FROM students WHERE firstname LIKE ? AND middlename LIKE ? AND lastname LIKE ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $firstname, $middlename, $lastname);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $studentID = $_POST['studentID'];
    $comment = $_POST['comment_text'];

    $query = "INSERT INTO comments (studentID, comment) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $studentID, $comment);
    $stmt->execute();
    $stmt->close();
}

if (!empty($students)) {
    $studentID = $students[0]['studentID'];
    $query = "SELECT c.comment, c.dateCreated, CONCAT(s.firstname, ' ', s.middlename, ' ', s.lastname) AS name
              FROM comments c
              JOIN students s ON c.studentID = s.studentID
              WHERE c.studentID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $studentID);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
    $stmt->close();

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Comments</title>
    <style>

    </style>
        <?php
include './Includes/database.php';

$students = [];
$comments = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];

    $query = "SELECT * FROM students WHERE firstname LIKE ? AND middlename LIKE ? AND lastname LIKE ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $firstname, $middlename, $lastname);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $studentID = $_POST['studentID'];
    $comment = $_POST['comment_text'];

    $query = "INSERT INTO comments (studentID, comment) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $studentID, $comment);
    $stmt->execute();
    $stmt->close();
}

if (!empty($students)) {
    $studentID = $students[0]['studentID'];
    $query = "SELECT c.comment, c.dateCreated, c.commentID, CONCAT(s.firstname, ' ', s.middlename, ' ', s.lastname) AS name
              FROM comments c
              JOIN students s ON c.studentID = s.studentID
              WHERE c.studentID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $studentID);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Comments</title>
    <style>
        body {
            font-family: "Ubuntu", sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            font-size: 20px;
            padding: 20px;
        }
        h2{
            font-size: 18px;
        }
        .container {
            max-width: 80%;
            margin: 8% auto;
            background: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 5px 7px 33px 1px rgba(0,0,0,0.57);
        }

        form {
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
        }

        input[type="text"], textarea {
            flex: 1;
            padding: 10px;
            font-size: 15px;
            margin: 10px 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"]{
            background-color: #4f9354eb;
            color: white;
            font-size: 15px;
            padding: 10px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            
        }

        .table th, .table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
            font-size: 15px;
        }

        .table th {
            background-color: #4f9354eb;
            font-size: 15px;
        }

        .comments-section {
            margin-top: 20px;
        }

        .comment {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }

        .comment:last-child {
            border-bottom: none;
        }

        .back-card {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 70px;
    display: flex;
    background-color: #4f9354eb;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding-bottom: 10px;
    box-sizing: border-box;
    z-index: 1000;
}

.back-card img {
    width: 50px;
    border-radius: 50px;
    margin-left: 10px;
}

.back-card h2 {
    text-align: center;
    color: #ffffff;
    font-size: 24px;
    margin: 0;
    flex-grow: 1;
}

.back-card button {
    background-color: #fff;
    color: #000;
    border: none;
    height: 40px;
    border-radius: 8px;
    padding: 10px 20px;
    cursor: pointer;
    font-weight: 600;
    margin-right: 20px;
    transition: background-color 0.3s ease;
}

        .delete a{
            font-weight: 600;
            color : white;
            text-decoration: none;
            border : 2px solid #e1d8d8;
            margin: 6px;
            padding : 9px;
            border-radius: 8px;
            background-color: red;
            border: none;
        }
        @media (max-width: 768px) {
            .container {
                width: 90%;
                max-width: 90%;
                padding: 10px;
            }

            .table th, .table td {
                font-size: 15px;
            }

            .back-card h2 {
                font-size: 20px;
            }
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>
<body>
<div class="back-card">
    <img src="images/logo.jpg" alt="Logo">
    <h2>Search Students and Add Comments</h2>
    <button onclick="window.location.href='admin_dashboard.php'">BACK</button>
</div>

<div class="container">
    <form method="post">
        <input type="text" name="firstname" placeholder="First Name" required>
        <input type="text" name="middlename" placeholder="Middle Name" required>
        <input type="text" name="lastname" placeholder="Last Name" required>
        <input type="submit" name="search" value="Search">
    </form>

    <?php if (!empty($students)): ?>
        <h2>Matched Students</h2>
        <table class="table">
            <tr>
                <th>Student ID</th>
                <th>Name</th>
            </tr>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo $student['studentID']; ?></td>
                    <td><?php echo $student['firstname'] . ' ' . $student['middlename'] . ' ' . $student['lastname']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>Add Comment</h2>
        <form method="post" action="commentHandling.php">
            <input type="hidden" name="studentID" value="<?php echo $students[0]['studentID']; ?>">
            <textarea name="comment_text" placeholder="Enter your comment" required></textarea>
            <input type="submit" name="comment" value="Add Comment">
        </form>

        <?php if (!empty($comments)): ?>
            <h2 style="color : brown;">Previous Comments</h2>
            <table class="table">
                <tr>
                    <th>Comment</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($comments as $comment): ?>
    <tr>
        <td><?php echo $comment['comment']; ?></td>
        <td><?php echo $comment['dateCreated']; ?></td>
        <td>
            <div class = "delete">
    <a href="commentDelete.php?commentID=<?php echo $comment['commentID']; ?>" onclick="return confirm('Are you sure you want to delete this comment?');"><i class="fas fa-trash-alt"></i> Delete
    </a>
                </div>
</td>
    </tr>
<?php endforeach; ?>

            </table>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>
