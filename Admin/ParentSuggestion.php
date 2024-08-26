<?php
// Connect to MySQL database
include '../Includes/database.php'; // Assuming you have a file named 'database.php' for database connection

// Prepare and execute SQL statement to select suggestions from the database
$stmt = $conn->prepare("SELECT * FROM suggestions");
$stmt->execute();
$result = $stmt->get_result();

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Parent Suggestions</title>
<link rel="stylesheet" href="./css/parentsuggestion.css">

</head>
<body>
<div class="back-card">
        <img src="images/logo.jpg" alt="Logo">
        <h2>Parent's Suggestions</h2>
        <button onclick="window.location.href='admin_dashboard.php'">BACK</button>
    </div>

<table>
  <thead>
    <tr>
      <th>S/No</th>
      <th>Name</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $count = 1;
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $count++ . "</td>";
      echo "<td>" . $row['name'] . "</td>";
      echo "<td id='status_" . $row['suggestionID'] . "'>" . ($row['is_read'] == 'Unread' ? 'Unread' : 'unread') . "</td>";
      echo "<td><button class='btn' onclick='viewSuggestion(" . $row['suggestionID'] . ")'>View</button></td>";
      echo "</tr>";
    }
    ?>
  </tbody>
</table>

<!-- Modal for displaying suggestion -->
<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <p id="suggestionText"></p>
  </div>
</div>

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
function viewSuggestion(suggestionId) {
  // Retrieve suggestion text from server using AJAX
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("suggestionText").innerHTML = this.responseText;
      // Display the modal
      modal.style.display = "block";
      
      // Update suggestion status to "Read" in the database
      var updateXhr = new XMLHttpRequest();
      updateXhr.open("GET", "update_suggestion.php?id=" + suggestionId, true);
      updateXhr.send();

      // Store the suggestion ID in sessionStorage to mark it as "Read"
      sessionStorage.setItem('read_suggestion_' + suggestionId, 'read');
      
      // Update suggestion status to "Read" in UI table
      document.getElementById("status_" + suggestionId).innerHTML = "Read";
    }
  };
  xhr.open("GET", "get_suggestion.php?id=" + suggestionId, true);
  xhr.send();
}

// When the page loads, check sessionStorage for previously read suggestions and mark them as "Read"
window.onload = function() {
  var suggestions = document.querySelectorAll('[id^="status_"]');
  suggestions.forEach(function(suggestion) {
    var suggestionId = suggestion.id.replace('status_', '');
    if (sessionStorage.getItem('read_suggestion_' + suggestionId) === 'read') {
      suggestion.innerHTML = "Read";
    }
  });
}

// When the user clicks on <span> (x) or outside of the modal, close the modal
span.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

</body>
</html>
