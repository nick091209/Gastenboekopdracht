<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastenboek | Post</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav id="desktop-nav">
    <div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="berichten.php">Berichten</a></li>
        <li><a href="#">Bericht posten</a></li>
        <?php 
        if(isset($_SESSION['username'])) {
            echo "<li><a href='user.php'>Welkom ".$_SESSION['username']."</a></li>";
        } else {
            echo "<li><a href='login.php'>Login</a></li>";
        }
        ?>
      </ul>
    </div>
  </nav>
  <nav id="hamburger-nav">
    <div class="hamburger-menu">
      <div class="hamburger-icon" onclick="toggleMenu()">
        <span></span>
        <span></span>
        <span></span>
      </div>
      <div class="menu-links">
        <li><a href="index.php" onclick="toggleMenu()">Home</a></li>
        <li><a href="berichten.php" onclick="toggleMenu()">Berichten</a></li>
        <li><a href="#" onclick="toggleMenu()">Bericht posten</a></li>
        <?php 
        if(isset($_SESSION['username'])) {
            echo "<li><a href='user.php'>Welkom ".$_SESSION['username']."</a></li>";
        } else {
            echo "<li><a href='login.php'>Login</a></li>";
        }
        ?>
      </div>
    </div>
  </nav>
  <h2 class="posttext">Post bericht</h2>
    <p class="postp">Plaats hier je bericht en eventueel een foto</p>
  <div class="post">
   
  <form action="proces.php" method="post" enctype="multipart/form-data">
      <label for="bericht">Bericht:</label>
      <textarea maxlength="120" class="postinput" name="bericht" rows="20" required></textarea>
      <label for="photo">Foto:</label>
      <input class="postinput" type="file" name="photo">
      <button class="postbutton" type="submit" >Plaats bericht</button>
    </form>
  </div>
  <script src="script.js"></script>
</body>
</html>
