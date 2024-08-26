<?php 
include 'session.php';
include './Includes/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Include Font Awesome -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet"></div>
<style>
body {
    margin: 0;
    padding: 0;
    font-family: "Ubuntu", sans-serif;
  }

  .header {
    width: 100%;
    height: 70px;
    background-color: #4f9354eb;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    padding: 5px;
    text-align: center;
  }
  .header h1{
    font-size : 16px;
    text-align: center;
  }
  .grid-container{
    margin: 20px 20px;
    display: grid;
    grid-template-columns: 30% 70%;
    gap: 20px;
  }
  .sidebar .img{
    border-radius: 5px;
    display: flex;
    align-items: center;
  }
  .sidebar-links{
    display: flex;
    flex-direction: column;
    margin-top: 20px;
    gap: 20px;
    background: #f0f0f0;
    height: 300px;
    border-radius: 5px;
  }
  .sidebar-links a{
    text-decoration: none;
    margin: 10px 10px;
    color: black;
  }
  .sidebar-links a:hover{
    text-decoration: underline;
  }
  .main-content{
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    margin: 20px 0px;
  }
  .main-content a{
    background: #f0f0f0;
    margin: 10px 10px;
    border-radius: 5px;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding-top: 10px;
    text-decoration: none;
    color: black;
    box-shadow: 5px 7px 33px 1px rgba(0,0,0,0.57);
  }
  .main-content h3{
    font-size: 17px;
  }
</style>
</head>
<body>

<div class="header">
  <h1>Welcome to the Dashboard</h1>
</div>
<div class="grid-container">
<div class="sidebar">
    <div class="img" style="background-color: #2f409594; margin-top;" >
        <?php
        // Check if the teacher's picture is set
        $teacherPicture = $_SESSION['Profile'];
        echo '<img src="uploads/' . $teacherPicture . '" alt="Teacher Picture" style="width: 90px; height: 90px; padding: 5px 60px; border-radius: 50%;">';
        $teacherUsername = $_SESSION['Username'];
        echo '<h3>Welcome, ' . $teacherUsername . '</h3>';
        ?>
    </div>
    <div class="sidebar-links">
    <a href="dashboard.php"><i class="fas fa-home" style="margin-right: 8px;"></i> Dashboard</a>
    <a href="students_result.php"><i class="fas fa-poll" style="margin-right: 8px;"></i> Result Management</a>
    <a href="student_attendance.php"><i class="fas fa-user-clock" style="margin-right: 8px;"></i> Attendance Tracking</a>
    <a href="teacher_change_password.php"><i class="fas fa-lock" style="margin-right: 8px;"></i> Change Password</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i> Logout</a>
    </div>
</div>

<div class="main-content">
  
    <a href="view_student_results.php" class="box">
      <i class="fas fa-file-upload" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
      <h3>UPLOADED RESULTS</h3>
      <p>View and Edit Results You Have Uploaded.</p>
    </a>

    <a href="edit_profile.php" class="box">
      <i class="fas fa-user-cog" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
      <h3>PROFILE MANAGEMENT</h3>
      <p>Content related to profile management goes here.</p>
    </a>
  
    <a href="view_event.php" class="box">
      <i class="fas fa-calendar" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
      <h3>ALL EVENTS</h3>
      <p>Content related to all events goes here.</p>
    </a>
  
    <a href="attendance_record.php" class="box">
      <i class="fas fa-history" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
      <h3>ATTENDANCE HISTORY</h3>
      <p>Content related to all events goes here.</p>
    </a>
</div>
</div>
</script> 
</body>
</html>
