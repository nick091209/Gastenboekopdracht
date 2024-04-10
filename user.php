<?php
include 'config.php';
session_start();

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastenboek | User Page</title>
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
                <?php
                if (isset($_SESSION['username'])) {
                    echo "<li><a href='#'>Welkom " . $_SESSION['username'] . "</a></li>";
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
                if (isset($_SESSION['username'])) {
                    echo "<li><a href='#'>Welcome " . $_SESSION['username'] . "</a></li>";
                } else {
                    echo "<li><a href='login.php' onclick='toggleMenu()'>Login</a></li>";
                }
                ?>
            </div>
        </div>
    </nav>

    <div class="user-info">
        <?php
        if (isset($_SESSION['username'])) {
            echo "<h2>User Info:</h2>";
            echo "<p>Gebruikersnaam: " . $_SESSION['username'] . "</p>";
            echo "<form method='post'><button type='submit' class='deletebutton' name='logout'>uitloggen</button></form>";
        }
        ?>
    </div>

    <script src="script.js"></script>
</body>

</html>
