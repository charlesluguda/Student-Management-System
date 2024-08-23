<?php
include 'session.php';
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
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">


<lrel="stylesheet" href="./css/admin_dashboard.css">
</head>
<body>

<div class="header">
  <h1>Admin Dashboard Panel</h1>
</div>

<div class="dashboard-container">
<div class="sidebar">
    <div class="img" style="background-color: #f5f4f2; margin-top: 10px;" >
        <?php
        // Check if the teacher's picture is set
        $teacherPicture = $_SESSION['Profile'];
        echo '<img src="uploads/' . $teacherPicture . '" alt="Teacher Picture" style="width: 70px; height: 70px; border-radius: 50%;">';
        $teacherUsername = $_SESSION['Username'];
        echo '<h3>Welcome, ' . $teacherUsername . '</h3>';
        ?>
    </div>
    <div class="sidebar-links">   
    <a href="Admin_dashboard.php"><i class="fas fa-home" style="margin-right: 8px;"></i> Dashboard</a>
    <a href="student_registration.php"><i class="fas fa-user-graduate" style="margin-right: 8px;"></i> Student Registration</a>
    <a href="add_event.php"><i class="fas fa-calendar-alt" style="margin-right: 8px;"></i> Event Management</a>
    <a href="teacher_registration.php"><i class="fas fa-user-plus" style="margin-right: 8px;"></i> Register Teacher</a>
    <a href="register_subjects.php"><i class="fas fa-plus-square" style="margin-right: 8px;"></i> Register Subjects</a>
    <a href="comments.php"><i class="fas fa-comments" style="margin-right: 8px;"></i> Comments</a>
    <a href="teacher_change_password.php"><i class="fas fa-lock" style="margin-right: 8px;"></i> Change Password</a>
    <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i> Logout</a>
    </div>
  </div>

<div class="main-content">
    <a href="view_students.php" class="box">
      <i class="fas fa-users" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
      <h3>Registered Students</h3>
      <?php
      include 'database.php';
      // Query to count the total number of registered students
      $countSQL = "SELECT COUNT(*) AS total FROM students";
      $countResult = $conn->query($countSQL);
      $row = $countResult->fetch_assoc();
      $totalRegisteredStudents = $row['total'];
      ?>
      <p>Total Registered Students: <?php echo $totalRegisteredStudents; ?></p>
    </a>

    <a href="view_teachers.php" class="box">
      <i class="fas fa-chalkboard-teacher" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
      <h3>Registered Teachers</h3>
      <?php
      include 'database.php';
      // Query to count the total number of registered teachers
      $countTeachersSQL = "SELECT COUNT(*) AS total FROM teachers";
      $countTeachersResult = $conn->query($countTeachersSQL);
      $rowTeachers = $countTeachersResult->fetch_assoc();
      $totalRegisteredTeachers = $rowTeachers['total'];
      ?>
      <p>Total Registered Teachers: <?php echo $totalRegisteredTeachers; ?></p>
    </a>

    <a href="view_subjects.php" class="box">
      <i class="fas fa-book" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
      <h3>Registered Subjects</h3>
      <?php
      include 'database.php';
      // Query to count the total number of registered subjects
      $countSubjectsSQL = "SELECT COUNT(*) AS total FROM subjects";
      $countSubjectsResult = $conn->query($countSubjectsSQL);
      $rowSubjects = $countSubjectsResult->fetch_assoc();
      $totalRegisteredSubjects = $rowSubjects['total'];
      ?>
      <p>Total Registered Subjects: <?php echo $totalRegisteredSubjects; ?></p>
    </a>
    <?php
// Connect to MySQL database
include 'database.php'; // Assuming you have a file named 'database.php' for database connection

// Prepare and execute SQL statement to count unread suggestions
$countStmt = $conn->prepare("SELECT COUNT(*) AS unread_count FROM suggestions WHERE is_read = 'Unread'");
$countStmt->execute();
$countResult = $countStmt->get_result();
$countRow = $countResult->fetch_assoc();
$unreadCount = $countRow['unread_count'];

// Close statement
$countStmt->close();

// Close database connection
$conn->close();
?>

<a href="ParentSuggestion.php" class="box">
  <i class="fas fa-comments" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
  <h3>Suggestions From Parents</h3>
  <?php if ($unreadCount > 0): ?>
    <p><?php echo $unreadCount; ?> Unread/new</p>
  <?php else: ?>
    <p>No new suggestions</p>
  <?php endif; ?>
</a>


    <a href="classes_result.php" class="box">
      <i class="fas fa-file-upload" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
      <h3>Uploaded Results</h3>
      <p>Content related to uploaded results goes here.</p>
    </a>

    <a href="edit_profile.php" class="box">
      <i class="fas fa-user-cog" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
      <h3>Profile Management</h3>
      <p>Content related to profile management goes here.</p>
    </a>
  
    <a href="view_event.php" class="box">
      <i class="fas fa-calendar" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
      <h3>All Events</h3>
      <p>Content related to all events goes here.</p>
    </a>
  
    <a href="classes_attendance.php" class="box">
      <i class="fas fa-history" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
      <h3>Previously Attendance</h3>
      <p>Content related to all events goes here.</p>
    </a>
</div>
</div>

</body>
</html>
