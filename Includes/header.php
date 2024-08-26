<?php
include "database.php";
include "./session.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <!-- ============================= BOOSTRAP ICONS =================================== -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- =============================== CSS STYLES =================================== -->
     <!-- <link rel="stylesheet" href="../css/header.css"> -->
    <!-- ============================ GOGLE FONTS ============================= -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Moderustic:wght@300..800&display=swap" rel="stylesheet">
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Moderustic", sans-serif;
}
header {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 70px;
    background: #4f9354eb;
    padding: 10px 10px;
}
.header-container {
    width: 90%;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.header-container .user {
    display: flex;
    align-items: center;
}
.header-container .logo {
    text-transform: capitalize;
    font-weight: bold;
    font-size: 22px;
}
.user-avatar {
    display: flex;
    align-items: center;
    gap: 10px;
    position: relative; 
}
.user-avatar img {
    border: 5px solid #fff;
    width: 45px;
    height: 45px;
    cursor: pointer;    
    border-radius: 50%;
}
.user-avatar p {
    font-size: 15px;
}
.menu-btn {
    color: #000;
    font-weight: 500;
    cursor: pointer;
    display: flex; 
    align-items: center;
}
.menu-btn .bi {
    display: block; 
}
.dropdown-menu {
    display: none; 
    position: absolute; 
    top: 100%; 
    left: 0; 
    background-color: #fff; 
    list-style-type: none; 
    padding: 0;
    margin: 0;
    border: 1px solid #ccc; 
    border-radius: 5px; 
    z-index: 1000; 
}

.dropdown-menu li {
    padding: 10px; 
}
.dropdown-menu li:nth-child(2){
    border-top: 1px solid black;
}

.dropdown-menu li a {
    text-decoration: none;
    color: #000; 
    display: block; 
}

.user-avatar:hover .dropdown-menu {
    display: block; 
}

    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">Student management system</div>
            <div class="user">
            <div class="user-avatar">
               <?php
                  $teacherPicture = $_SESSION['Profile'];
                  echo '<img src="./uploads/' . $teacherPicture . '" alt="">';
                  $teacherUsername = $_SESSION['Username'];
                  echo '<p>Sir, ' . $teacherUsername . '</p>';
                ?>
                <div class="menu-btn">
                     <!-- <i class="bi bi-chevron-down"></i> -->
                     <ul class="dropdown-menu">
                     <li><a href="../Admin_dashboard.php">Dashboard</a></li>
                     <li><a href="../logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>      
            </div>
        </div>
    </header>
</body>
</html>