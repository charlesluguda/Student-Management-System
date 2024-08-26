<?php
// Include database connection
include './Includes/database.php';

// Current counts from the database
$countSQL = "SELECT COUNT(*) AS total FROM students";
$countResult = $conn->query($countSQL);
$row = $countResult->fetch_assoc();
$totalRegisteredStudents = $row['total'];

$countTeachersSQL = "SELECT COUNT(*) AS total FROM teachers";
$countTeachersResult = $conn->query($countTeachersSQL);
$rowTeachers = $countTeachersResult->fetch_assoc();
$totalRegisteredTeachers = $rowTeachers['total'];

$countSubjectsSQL = "SELECT COUNT(*) AS total FROM subjects";
$countSubjectsResult = $conn->query($countSubjectsSQL);
$rowSubjects = $countSubjectsResult->fetch_assoc();
$totalRegisteredSubjects = $rowSubjects['total'];

// Previous counts (replace with actual data from your database)
$previousRegisteredStudents = 150;  // Replace with actual previous count
$previousRegisteredTeachers = 30;   // Replace with actual previous count
$previousRegisteredSubjects = 9;   // Replace with actual previous count

// Calculate percentage changes
$studentChangePercent = (($totalRegisteredStudents - $previousRegisteredStudents) / $previousRegisteredStudents) * 100;
$teacherChangePercent = (($totalRegisteredTeachers - $previousRegisteredTeachers) / $previousRegisteredTeachers) * 100;
$subjectChangePercent = (($totalRegisteredSubjects - $previousRegisteredSubjects) / $previousRegisteredSubjects) * 100;

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>

<!-- ======================== FULLCALENDAR ================================ -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

<!-- ========================= CHART JS ================================== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Include Calendar Heatmap Library -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/calendar-heatmap/dist/calendar-heatmap.css">
<script src="https://cdn.jsdelivr.net/npm/calendar-heatmap/dist/calendar-heatmap.min.js"></script>

<!-- ======================== JQUERY ================================ -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- ============================== FONT AWESOME ============================= -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- ========================== GOOGLE FONTS ================================ -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

<!-- ========================== STYLES SHEET ================================ -->
<link rel="stylesheet" href="./css/admin_dashboard.css">
</head>
<body>

<?php include('./Includes/header.php'); ?>

<div class="dashboard-container">
<div class="sidebar">
    <div class="sidebar-links">   
    <a href="Admin_dashboard.php"><i class="fas fa-home" style="margin-right: 8px;"></i> Dashboard</a>
    <a href="student_registration.php"><i class="fas fa-user-graduate" style="margin-right: 8px;"></i> Student Registration</a>
    <a href="add_event.php"><i class="fas fa-calendar-alt" style="margin-right: 8px;"></i> Event Management</a>
    <a href="teacher_registration.php"><i class="fas fa-user-plus" style="margin-right: 8px;"></i> Register Teacher</a>
    <a href="register_subjects.php"><i class="fas fa-plus-square" style="margin-right: 8px;"></i> Register Subjects</a>
    <a href="comments.php"><i class="fas fa-comments" style="margin-right: 8px;"></i> Comments</a>
    <a href="teacher_change_password.php"><i class="fas fa-lock" style="margin-right: 8px;"></i> Change Password</a>
    <a href="./edit_profile.php"><i class="fas fa-user-cog" style="margin-right: 8px;"></i> Profile Management</a>
    </div>
  </div>

<div class="main-content">
    <div class="main-conent-box">
    <a href="./Admin/view_students.php" class="box">
      <i class="fas fa-users" style="font-size: 24px; margin-bottom: 8px; display: block; color : #4f9354eb"></i>
      <h3>Registered Students</h3>
      <p>Total Registered Students: <?php echo $totalRegisteredStudents; ?></p>
      <p>
        <?php if ($studentChangePercent > 0): ?>
          <span style="color: green;">&#9650; <?php echo round($studentChangePercent, 2); ?>%</span>
        <?php elseif ($studentChangePercent < 0): ?>
          <span style="color: red;">&#9660; <?php echo round($studentChangePercent, 2); ?>%</span>
        <?php else: ?>
          <span style="color: gray;">0%</span>
        <?php endif; ?>
      </p>
    </a>

    <a href="./Admin/view_teachers.php" class="box">
      <i class="fas fa-chalkboard-teacher" style="font-size: 20px; margin-bottom: 8px; display: block; color : #4f9354eb"></i>
      <h3>Registered Teachers</h3>
      <p>Total Registered Teachers: <?php echo $totalRegisteredTeachers; ?></p>
      <p>
        <?php if ($teacherChangePercent > 0): ?>
          <span style="color: green;">&#9650; <?php echo round($teacherChangePercent, 2); ?>%</span>
        <?php elseif ($teacherChangePercent < 0): ?>
          <span style="color: red;">&#9660; <?php echo round($teacherChangePercent, 2); ?>%</span>
        <?php else: ?>
          <span style="color: gray;">0%</span>
        <?php endif; ?>
      </p>
    </a>

    <a href="./Admin/view_subjects.php" class="box">
      <i class="fas fa-book" style="font-size: 20px; margin-bottom: 8px; display: block; color : #4f9354eb"></i>
      <h3>Registered Subjects</h3>
      <p>Total Registered Subjects: <?php echo $totalRegisteredSubjects; ?></p>
      <p>
        <?php if ($subjectChangePercent > 0): ?>
          <span style="color: green;">&#9650; <?php echo round($subjectChangePercent, 2); ?>%</span>
        <?php elseif ($subjectChangePercent < 0): ?>
          <span style="color: red;">&#9660; <?php echo round($subjectChangePercent, 2); ?>%</span>
        <?php else: ?>
          <span style="color: gray;">0%</span>
        <?php endif; ?>
      </p>
    </a>

    <?php
    // Fetch unread suggestions count
    $countStmt = $conn->prepare("SELECT COUNT(*) AS unread_count FROM suggestions WHERE is_read = 'Unread'");
    $countStmt->execute();
    $countResult = $countStmt->get_result();
    $countRow = $countResult->fetch_assoc();
    $unreadCount = $countRow['unread_count'];

    $countStmt->close();
    ?>

    <a href="./Admin/ParentSuggestion.php" class="box">
      <i class="fas fa-comments" style="font-size: 24px; margin-bottom: 8px; display: block; color : #4f9354eb"></i>
      <h3>Suggestions From Parents</h3>
      <?php if ($unreadCount > 0): ?>
        <p><?php echo $unreadCount; ?> Unread/new</p>
      <?php else: ?>
        <p>No new suggestions</p>
      <?php endif; ?>
    </a>

    <a href="./Admin/classes_result.php" class="box">
      <i class="fas fa-file-upload" style="font-size: 20px; margin-bottom: 8px; display: block; color : #4f9354eb"></i>
      <h3>Uploaded Results</h3>
      <p>Content related to uploaded results goes here.</p>
    </a>

    <a href="./Admin/view_event.php" class="box">
      <i class="fas fa-calendar" style="font-size: 20px; margin-bottom: 8px; display: block; color : #4f9354eb"></i>
      <h3>All Events</h3>
      <p>Content related to all events goes here.</p>
    </a>

    <a href="./Admin/classes_attendance.php" class="box">
      <i class="fas fa-history" style="font-size: 20px; margin-bottom: 8px; display: block; color : #4f9354eb"></i>
      <h3>Previously Attendance</h3>
      <p>Content related to all events goes here.</p>
    </a>

    </div>
    <div class="chart-container">
    <div class="chart">
      <h3>Charts</h3>
      <canvas id="combinedChart" ></canvas>
    </div>
    <div class="calendars">
      <h3>Calendar</h3>
      <div id="calendar" style="margin-top: 20px;"></div>
    </div>
    </div>

</div>
</div>

<script>
// Data for chart
const registeredStudents = <?php echo json_encode($totalRegisteredStudents); ?>;
const registeredTeachers = <?php echo json_encode($totalRegisteredTeachers); ?>;
const registeredSubjects = <?php echo json_encode($totalRegisteredSubjects); ?>;
const unreadComment = <?php echo json_encode($unreadCount); ?>;

// Initialize Chart.js
const ctx = document.getElementById('combinedChart').getContext('2d');
const combinedChart = new Chart(ctx, {
    type: 'line', 
    data: {
        labels: ['Registered Students', 'Registered Teachers', 'Registered Subjects', 'Unread Comments'],
        datasets: [{
            label: 'Count',
            data: [registeredStudents, registeredTeachers, registeredSubjects, unreadComment],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Initialize FullCalendar
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth'
    });
    calendar.render();
});
</script>

</body>
</html>
