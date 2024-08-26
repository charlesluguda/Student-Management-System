<?php
// Include session.php and database.php
include '../session.php';
include '../Includes/database.php';

// Fetch subjects data from the database
$sql = "SELECT subjects.*, teachers.email AS email FROM subjects 
        LEFT JOIN teachers ON subjects.teacherID = teachers.teacherID";

// Check if search query is provided
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql .= " WHERE subject_name LIKE '%$search%' OR class LIKE '%$search%' OR email LIKE '%$search%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Subjects</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Include Font Awesome -->

<link rel="stylesheet" href="./css/view_teacher.css">
</head>
<body>
<div class="back-card">
        <img src="images/logo.jpg" alt="Logo">
        <h2>Registered Subjects</h2>
        <button onclick="window.location.href='admin_dashboard.php'">BACK</button>
    </div>

<!-- <h2>View Subjects</h2> -->

<div class="search-form">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
    <input type="text" name="search" class="search-input" placeholder="Search...">
    <button type="submit" class="search-button"><i class="fas fa-search"></i></button>
  </form>
</div>

<table>
  <thead>
    <tr>
      <th>S/NO</th>
      <th>Teacher Name</th>
      <th>Subject</th>
      <th>Class</th>
      <th>Email</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php
  $sno = 1; // Initialize serial number counter
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          ?>
          <tr>
            <td><?php echo $sno++; ?></td>
            <td><?php echo $row['teacher_name']; ?></td>
            <td><?php echo $row['subject_name']; ?></td>
            <td><?php echo $row['class']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td>
              <a href="edit_subject.php?subject_id=<?php echo $row['subject_id']; ?>"><i class="fas fa-edit" title="Edit"></i></a>
              <a href="delete_subjects.php?subject_id=<?php echo $row['subject_id']; ?>"><i class="fas fa-trash-alt" title="Delete"></i></a>
            </td>
          </tr>
          <?php
      }
  } else {
      echo "<tr><td colspan='6'>No subjects found.</td></tr>";
  }
  ?>
  </tbody>
</table>

</body>
</html>
