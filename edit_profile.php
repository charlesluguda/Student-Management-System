<?php
// Include session and database files
include 'session.php';
include 'database.php';

// Initialize variables to store teacher data
$id = $teacherUsername = $teacherEmail = $teacherPicture = '';

// Check if session variable is set
if(isset($_SESSION['teacherID'])) {
    $id = $_SESSION['teacherID'];

    // Retrieve teacher data from the database
    $sql = "SELECT * FROM teachers WHERE teacherID = '$id'";
    $result = $conn->query($sql);

    // Check if query was successful and if data exists
    if($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $teacherUsername = $row['username'];
        $teacherEmail = $row['email'];
        $teacherPicture = $row['picture'];
    } else {
        echo "No teacher data found.";
        exit(); // Exit script if no data found
    }
} else {
    echo "Teacher ID not set in session.";
    exit(); // Exit script if session variable not set
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="./css/edit_profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

</head>
<body>
<div class="back-card">
        <img src="images/logo.jpg" alt="Logo">
        <h2>Teacher Profile</h2>
        <button onclick="window.location.href='admin_dashboard.php'">BACK</button>
</div>
<!-- <div class="header">
    <h1>Welcome, <?php echo $teacherUsername; ?></h1>
</div> -->
<div class="main-content">
    <div class="profile">
        <img src="uploads/<?php echo $teacherPicture; ?>" alt="Profile Picture">
        <p>Username: <?php echo $teacherUsername; ?></p>
        <div class="divider"></div>
        <div class="profile-info">
        <p>ID: </p>
        <p>Subject: </p>
        <p>Email: <?php echo $teacherEmail; ?></p>
        </div>
    </div>
    <div class="profile-updates">
    <form action="edit_profile.php" method="post" enctype="multipart/form-data">
            <h2>Update Profile</h2>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="text" name="username" placeholder="Username" value="<?php echo $teacherUsername; ?>">
            <input type="email" name="email" placeholder="Email" value="<?php echo $teacherEmail; ?>">
            <input type="file" name="picture" accept="image/*">
            <input type="submit" value="Update Profile" name="update_profile">
        </form>
    </div>
</div>

</body>
</html>

<?php
// Include database file
include 'database.php';

// Check if form is submitted for updating profile
if(isset($_POST['update_profile'])) {
    // Get form data
    $id = $_POST['id'];
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];

    // Fetch existing picture from the database
    $sql = "SELECT picture FROM teachers WHERE teacherID = '$id'";
    $result = $conn->query($sql);

    // Check if query was successful
    if($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $existingPicture = $row['picture'];

        // Check if a new picture is uploaded
        if ($_FILES['picture']['name']) {
            // Handle picture upload
            $target_dir = "teacher_uploads/";
            $target_file = $target_dir . basename($_FILES["picture"]["name"]);
            if(move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                $newPicture = basename($_FILES["picture"]["name"]);
            } else {
                echo "Failed to move uploaded file.";
                exit();
            }
        } else {
            // Keep the existing picture
            $newPicture = $existingPicture;
        }

        // Update profile in the database using prepared statement to prevent SQL injection
        $updateSql = "UPDATE teachers SET username=?, email=?, picture=? WHERE teacherID=?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("sssi", $newUsername, $newEmail, $newPicture, $id);

        // Execute the update query
        if ($stmt->execute()) {
            // Redirect to profile page with success message
            header("Location: edit_profile.php?update=success");
            exit();
        } else {
            // Redirect to profile page with error message
            header("Location: edit_profile.php?update=error");
            exit();
        }
    } else {
        echo "No teacher data found for ID: $id";
        exit();
    }
}
?>
