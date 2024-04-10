
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <title>Gastenboek | Register</title>
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
    <div class="register">
    <h2 class="logintext">Register</h1>
      <p class="loginp">Registreer hier om je account aan te maken</p>
        <form action="register.php" method="post">
        <label for="username">Gebruikersnaam:</label>
        <input class="registerinput" type="text" name="username" required>
        <label for="password">Wachtwoord:</label>
        <input class="registerinput" type="password" name="password" required>
        <button class="registerbutton" type="submit">Register</button>
        </form>
        <p class="registerp">Heb je al een account? <a class="registerl" href="login.php">Log in</a></p>
</div>
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
  
  if ($result->num_rows > 0) {
    echo "<script>
            swal({
              title: 'Error!',
              text: 'Gebruikersnaam is al in gebruik.',
              icon: 'error',
              button: 'OK'
            });
          </script>";
  } else {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->close();
    
    echo "<script>
            swal({
              title: 'Success!',
              text: 'Je account is aangemaakt!',
              icon: 'success',
              button: 'OK'
            }).then(function() {
              window.location.href = 'login.php';
            });
          </script>";
  }
}
?>

  <script src="script.js"></script>
</body>

</html>
