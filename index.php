<?php
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastenboek | Home</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<nav id="desktop-nav">
    <div>
      <ul class="nav-links">
        <li><a href="#">Home</a></li>
        <li><a href="berichten.php">Berichten</a></li>
        <li><a href="post.php">Bericht posten</a></li>
        <?php 
        session_start(); 
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
        <li><a href="#" onclick="toggleMenu()">Home</a></li>
        <li><a href="berichten.php" onclick="toggleMenu()">Berichten</a></li>
        <li><a href="post.php" onclick="toggleMenu()">Bericht posten</a></li>
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
  <div class="container">
    <div class="home" id="home">
      <h1 class="homeh1">Dit is het Gastenboek</h1>
      <p class="homep">als je een bericht wilt plaatsen log dan in of registreer een account. Dat kan door rechts boven op login te klikken<br>
        als je berichten wilt lezen klik dan op berichten
      </p>
    </div>

    
    <script src="script.js"></script>
</body>

</html>