<?php
include 'session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Include Font Awesome -->
    <link rel="stylesheet" href="./css/view_student.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>

<body>

    <div class="back-card">
        <img src="images/logo.jpg" alt="Logo">
        <h2>Registered Students</h2>
        <button onclick="window.location.href='admin_dashboard.php'">BACK</button>
    </div>

    <div class="search-form">
        <form method="GET">
            <input type="text" name="class" placeholder="Enter class">
            <input type="submit" value="Search">
        </form>
    </div>

    <div class="container">
        <table>
            <tr>
                <th>S/No</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Class</th>
                <th>Phone</th>
                <th>Picture</th>
                <th>Email</th>
                <th>Date of Birth</th>
                <th>Actions</th>
            </tr>
  <?php
  // Include the database connection file
  include 'database.php';
  
  // Check if class search parameter is provided
  if (isset($_GET['class'])) {
    $class = $_GET['class'];
    // Fetch data from the database based on the entered class
    $sql = "SELECT studentID, firstname, middlename, lastname, gender, class, phone,email, picture, dateOfbirth FROM students WHERE class = '$class'";
  } else {
    // Fetch all students if no search parameter is provided
    $sql = "SELECT studentID, firstname, middlename, lastname, gender, class, phone, email, picture, dateOfbirth FROM students";
  }
  
  $result = $conn->query($sql);

  $serial_number = 1;
  if ($result->num_rows > 0) {
      // Output data of each row
      while($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>".$serial_number."</td>";
          echo "<td>".$row["firstname"]."</td>";
          echo "<td>".$row["middlename"]."</td>";
          echo "<td>".$row["lastname"]."</td>";
          echo "<td>".$row["gender"]."</td>";
          echo "<td>".$row["class"]."</td>";
          echo "<td>".$row["phone"]."</td>";
          echo "<td><img src='uploads/".$row["picture"]."'</td>";
          echo "<td>".$row["email"]."</td>";
          echo "<td>".$row["dateOfbirth"]."</td>";
          echo "<td>";
          echo "<div class='action-icons'>
              <a href='edit.php?studentID=".$row["studentID"]."'><i class='fas fa-edit'> Edit</i></a>
            
              <a href='delete.php?studentID=".$row["studentID"]."' onclick='return confirm(\"Are you sure you want to delete this student?\");'><i class='fas fa-trash-alt'></i> Delete</a>
          </td>";
         
          echo "</tr>";
          $serial_number++;
      }
  } else {
      echo "<tr><td colspan='10'>No students found</td></tr>";
  }
  ?>
</table>

</body>
</html>
