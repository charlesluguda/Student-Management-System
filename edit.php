<?php
include 'session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Student</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Include Font Awesome -->
<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 20px;
  }

  h2 {
    text-align: center;
    margin-bottom: 20px;
  }

  form {
    width: 50%;
    margin: 0 auto;
    border: 2px solid #007bff; /* Add border with blue color */
    border-radius: 10px; /* Add border-radius for round corners */
    padding: 20px; /* Add padding for better spacing */
  }

  label {
    display: block;
    margin-bottom: 10px;
  }

  input[type="text"], input[type="email"], input[type="file"], select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
  }

  .action-btns {
    text-align: center;
  }

  .action-btns button {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
  }

  .action-btns button:hover {
    background-color: #0056b3;
  }
</style>
</head>
<body>

<h2>Edit Student</h2>

<div id="editFormContainer"></div> <!-- Container for the edit form -->

<?php
// Include the database connection file
include 'database.php';

if(isset($_GET['studentID'])) {
    $id = $_GET['studentID'];

    // Fetch data from the database for the selected student
    $sql = "SELECT * FROM students WHERE studentID = $id";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
<div id="editFormContainer">

<form action="update.php" method="POST" enctype="multipart/form-data"> <!-- Added enctype attribute -->
    <input type="hidden" name="id" value="<?php echo $row['studentID']; ?>">
    <label for="firstname">First Name:</label>
    <input type="text" id="firstname" name="firstname" value="<?php echo $row['firstname']; ?>" required>

    <label for="middlename">Middle Name:</label>
    <input type="text" id="middlename" name="middlename" value="<?php echo $row['middlename']; ?>">

    <label for="lastname">Last Name:</label>
    <input type="text" id="lastname" name="lastname" value="<?php echo $row['lastname']; ?>" required>

    <label for="gender">Gender:</label>
    <select id="gender" name="gender" required>
        <option value="Male" <?php if($row['gender'] == 'Male') echo 'selected'; ?>>Male</option>
        <option value="Female" <?php if($row['gender'] == 'Female') echo 'selected'; ?>>Female</option>
    </select>

    <label for="class">Class:</label>
    <input type="text" id="class" name="class" value="<?php echo $row['class']; ?>" required>

    <label for="phone">Phone:</label>
    <input type="text" id="phone" name="phone" value="<?php echo $row['phone']; ?>" required>

    <label for="picture">Current Picture:</label>
    <input type="text" id="current_picture" name="current_picture" value="<?php echo $row['picture']; ?>" readonly>

    <label for="new_picture">New Picture:</label>
    <input type="file" id="new_picture" name="new_picture" accept="image/*">

    <label for="dateOfBirth">Date of Birth:</label>
    <input type="date" id="dateOfBirth" name="dateOfBirth" value="<?php echo $row['dateOfbirth']; ?>" required>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>

    <div class="action-btns">
        <button type="submit" name="update">Update</button>
    </div>
</form>
</div>
<?php
    } else {
        echo "No student found with the given ID.";
    }
} else {
    echo "No ID specified.";
}
?>

<!-- JavaScript function for loading edit form -->
<script>
    function loadEditForm(studentID) {
        // AJAX request to fetch the edit form
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("editFormContainer").innerHTML = this.responseText;
                // Display the edit form (e.g., in a modal)
                // Code for showing modal or displaying form in a specific area
            }
        };
        xhttp.open("GET", "edit.php?studentID=" + studentID, true);
        xhttp.send();
    }
</script>

</body>
</html>
``
