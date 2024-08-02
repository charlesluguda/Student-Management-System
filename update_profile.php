<?php

include 'session.php';
include 'database.php';

// Check if form is submitted for updating profile
if(isset($_POST['update_profile'])) {
    // Get form data
    $id = $_POST['teacherID'];
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];

    // Fetch existing picture from the database
    $sql = "SELECT picture FROM teachers WHERE teacherID = '$id'";
    $result = $conn->query($sql);
    
    if($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $existingPicture = $row['picture'];

        // Check if a new picture is uploaded
        if ($_FILES['picture']['name']) {
            // Handle picture upload
            $target_dir = "teacher_uploads/";
            $target_file = $target_dir . basename($_FILES["picture"]["name"]);
            move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file);
            $newPicture = basename($_FILES["picture"]["name"]);
        } else {
            // Keep the existing picture
            $newPicture = $existingPicture;
        }
        
        // Update profile in the database using prepared statement to prevent SQL injection
        $updateSql = "UPDATE teachers SET username=?, email=?, picture=? WHERE teacherID=?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("sssi", $newUsername, $newEmail, $newPicture, $id);

        if ($stmt->execute()) {
            // Redirect to profile page with success message
            header("Location: edit_profile.php?update=success");
            exit();
        } else {
            // Redirect to profile page with error message
            header("Location: edit_profile.php?update=error");
            exit();
        }
    }
}
?>
