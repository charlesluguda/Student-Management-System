<?php
// Include session.php and database.php
include '../session.php';
include '../Includes/database.php';

// Fetch teachers data from the database based on search criteria
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM teachers WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR username LIKE '%$search%'";
} else {
    // If no search term provided, fetch all teachers
    $sql = "SELECT * FROM teachers";
}

$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Teachers</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Include Font Awesome -->
<link rel="stylesheet" href="./css/view_teacher.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>
<body>
<div class="back-card">
        <img src="images/logo.jpg" alt="Logo">
        <h2>Registered Teachers</h2>
        <button onclick="window.location.href='admin_dashboard.php'">BACK</button>
    </div>
<div class="search-form">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
    <input type="text" name="search" class="search-input" placeholder="Search by username or full name" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
    <button type="submit" class="search">Search</button>
  </form>
</div>

<table>
  <thead>
    <tr>
      <th>S/NO</th>
      <th>Full Name</th>
      <th>Username</th>
      <th>Picture</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
  <?php
  if ($result->num_rows > 0) {
      $sno =1;
      while ($row = $result->fetch_assoc()) {
          ?>
          <tr>
              <td><?php echo $sno ?></td>
            <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><img src="teacher_uploads/<?php echo $row['picture']; ?>" alt="Teacher Picture" style="width: 50px; height: 50px;"></td>
            <td>
              <a href="edit_teacher.php?teacherID=<?php echo $row['teacherID']; ?>"><i class="fas fa-edit" title="Edit"></i></a>
              <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['teacherID']; ?>)"><i class="fas fa-trash-alt" title="Delete"></i></a>
            </td>
          </tr>
          <?php
          $sno++;
      }
  } else {
      echo "<tr><td colspan='5'>No teachers found.</td></tr>";
  }
  ?>
  </tbody>
</table>

<script>
  function confirmDelete(teacherID) {
    var confirmation = confirm("Are you sure you want to delete this teacher?");
    if (confirmation) {
      window.location.href = "delete_teacher.php?teacherID=" + teacherID;
    }
  }
</script>

</body>
</html>
