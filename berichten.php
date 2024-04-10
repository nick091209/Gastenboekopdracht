<?php
include 'config.php';
session_start();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['delete_message'])) {
    $message_id = $_POST['message_id'];

    if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        if ($username === "admin") {
            $stmt = $conn->prepare("DELETE FROM berichten WHERE id = ?");
            $stmt->bind_param("i", $message_id);
        } else {
            $stmt = $conn->prepare("DELETE FROM berichten WHERE id = ? AND naam = ?");
            $stmt->bind_param("is", $message_id, $username);
        }

        if ($stmt->execute()) {
            header("Location: berichten.php");
            exit();
        } else {
            echo "Error deleting message: " . $conn->error;
        }
    } else {
        echo "You need to be logged in to delete messages.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastenboek | Berichten</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<nav id="desktop-nav">
    <div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="#">Berichten</a></li>
        <li><a href="post.php">Bericht posten</a></li>
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
        <li><a href="#" onclick="toggleMenu()">Berichten</a></li>
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

    <?php
    
    $result = $conn->query("SELECT * FROM berichten ORDER BY datum DESC");

    if ($result->num_rows > 0) {
        echo '<div class="berichten">';
        while ($row = $result->fetch_assoc()) {
            echo '<div class="bericht">';
            echo '<p class="send-messages">
            <strong>' . htmlspecialchars($row['naam']) . ':</strong>' . '<p class="message-text">' . nl2br(htmlspecialchars($row['bericht'])) . '</p>' . '</p>';

            if (!empty($row['photo'])) {
                $photoURL = 'uploads/' . htmlspecialchars($row['photo']);
                if (file_exists($photoURL)) {
                    echo '<img src="' . $photoURL . '" alt="Uploaded photo" style="max-width: 150px; max-height: 150px;">';
                } else {
                    echo 'foto niet gevonden!';
                }
            }

            if (isset($_SESSION['username']) && ($_SESSION['username'] === $row['naam'] || $_SESSION['username'] === "admin")) {
                echo '<form method="post">';
                echo '<input type="hidden" name="message_id" value="' . $row['id'] . '">';
                echo '<button type="submit" class="deletebutton" name="delete_message">Verwijderen</button>';
                echo '</form>';
            }

            echo '<small>' . $row['datum'] . '</small></p>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo "<center><p>Geen berichten gevonden.</p></center>";
    }

    $conn->close();
    ?>
<script src="script.js"></script>
</body>

</html>
