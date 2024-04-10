<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <title>Gastenboek | Login</title>
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <nav id="desktop-nav">
    <div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="berichten.php">Berichten</a></li>
        <li><a href="post.php">Bericht posten</a></li>
        <li><a href="#">Login</a></li>
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
        <li><a href="post.php" onclick="toggleMenu()">Bericht posten</a></li>
        <li><a href="#" onclick="toggleMenu()">Login</a></li>
      </div>
    </div>
  </nav>  

    <div class="login">
      <h2 class="logintext">Login</h1>
      <p class="loginp">log hier in zodat je berichten kan plaatsen</p>
        <form class="loginform" action="login.php" method="post">
        <label for="username">Gebruikersnaam:</label>
        <input class="logininput" type="text" name="username" required>
        <label for="password">Wachtwoord:</label>
        <input class="logininput" type="password" name="password" required>
        <button class="loginbutton" type="submit">Login</button>
        </form>
        <p class="registerp">Heb je nog geen account? <a class="registerl" href="register.php">Registreer hier</a></p>
</div>
  <script src="script.js"></script>
</body>

</html>
<?php
include 'config.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();
  if (password_verify($password, $user['password'])) {
    $_SESSION['username'] = $username;
    echo "<script>
          swal({
            title: 'Success!',
            text: 'Je bent ingelogd!',
            icon: 'success',
            button: 'Ga naar berichten'
          }).then(function() {
            window.location.href = 'berichten.php';
          });
        </script>";
  } else {
    echo"<script language='javascript'>
    swal('Error!', 'Gebruikersnaam of wachtwoord is onjuist!', 'error');
    </script>
";
  }
}
?>
