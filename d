<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['username'])) {
    echo "<script>
          swal({
            title: 'Error!',
            text: 'Je moet inloggen om een bericht te sturen',
            icon: 'error',
            button: 'login'
          }).then(function() {
            window.location.href = 'login.php';
          });
        </script>";
    exit();
}

include 'config.php';

// Check if a message has been sent in the last 24 hours
if (isset($_SESSION['last_message_time']) && time() - $_SESSION['last_message_time'] < 86400) {
    echo "<script>
          swal({
            title: 'Error!',
            text: 'Je kunt slechts één bericht per dag verzenden',
            icon: 'error',
            button: 'Ok'
          });
        </script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $bericht = $_POST["bericht"];
    $photo = '';

    if (!empty($_FILES["photo"]["name"])) {
        $photo = $_FILES["photo"]["name"];
        $targetDir = "uploads/";
        $fileName = uniqid() . '_' . basename($_FILES["photo"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "<script>
            swal({
              title: 'Error!',
              text: 'je bestand is geen afbeelding',
              icon: 'error',
              button: 'ga terug'
            }).then(function() {
              window.location.href = 'post.php';
            });
            </script>";
            $uploadOk = 0;
        }

        if ($_FILES["photo"]["size"] > 50000000) {
            echo "<script>
          swal({
            title: 'Error!',
            text: 'je bestand is te groot (max 5MB)',
            icon: 'error',
            button: 'ga terug'
          });
        </script>";
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
                echo "<script>
                swal({
                  title: 'Error!',
                  text: 'alleen JPG, JPEG, PNG & GIF bestanden zijn toegestaan.',
                  icon: 'error',
                  button: 'ga terug'
                });
              </script>";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "<script>
          swal({
            title: 'Error!',
            text: 'je bestand is niet geupload',
            icon: 'error',
            button: 'ga terug'
          });
          </script>";
        } else {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
                echo "The file " . htmlspecialchars(basename($_FILES["photo"]["name"])) . "is geupload.";

                $sql = "INSERT INTO berichten (naam, bericht, photo) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $username, $bericht, $fileName);

                if ($stmt->execute()) {
                    header("Location: berichten.php");
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "<script>
          swal({
            title: 'Error!',
            text: 'er is een fout opgetreden bij het uploaden van je bestand',
            icon: 'error',
            button: 'ga terug'
          });
          </script>";
            }
        }
    }

    $sql = "INSERT INTO berichten (naam, bericht, photo) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $bericht, $photo);

    if ($stmt->execute()) {
        // Update last message time in session
        $_SESSION['last_message_time'] = time();
        header("Location: berichten.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
