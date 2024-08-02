<?php
// Include the database connection file
include 'database.php';

if(isset($_POST['update'])) {
    $id = $_POST['id'];
    $firstName = $_POST['firstname'];
    $middleName = $_POST['middlename'];
    $lastName = $_POST['lastname'];
    $gender = $_POST['gender'];
    $class = $_POST['class'];
    $phone = $_POST['phone'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $email = $_POST['email'];
    $currentPicture = $_POST['current_picture'];
    $newPicture = $_FILES['new_picture']['name'];

    // Check if a new picture is uploaded
    if($newPicture) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["new_picture"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate the file type
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");
        if(!in_array($imageFileType, $allowedExtensions)) {
            echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
            exit;
        }

        // Validate the file size (maximum 5MB)
        $maxFileSize = 5 * 1024 * 1024; // 5 MB in bytes
        if($_FILES["new_picture"]["size"] > $maxFileSize) {
            echo "Sorry, your file is too large. Maximum file size allowed is 5MB.";
            exit;
        }

        // Move the uploaded file to the target directory
        if(!move_uploaded_file($_FILES["new_picture"]["tmp_name"], $target_file)) {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }

        // Use the new picture name in the database
        $picture = $newPicture;
    } else {
        // Use the current picture if no new picture is uploaded
        $picture = $currentPicture;
    }

    // Prepare SQL statement to update data in the database
    $sql = "UPDATE students SET 
            firstname='$firstName', 
            middlename='$middleName', 
            lastname='$lastName', 
            gender='$gender', 
            class='$class', 
            phone='$phone', 
            picture='$picture', 
            email='$email',
            dateOfbirth='$dateOfBirth' 
            WHERE studentID=$id";

    // Execute the SQL statement
    if($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        // Redirect to the view page after updating
        header("Location: view_students.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
