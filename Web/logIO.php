<?php
session_start();

if (isset($_POST['logout'])) {
  session_destroy();
  header("Location: login.php");
  exit();
}

if (isset($_POST['login'])) {
  if (isset($_SESSION["user"])) {
    session_destroy();
  }
  if (isExist()) {
    $_SESSION['user']['type'] = htmlentities($_POST["userType"], ENT_QUOTES);
    header("Location: home.php");
  } else {
    header("Location: login.php");
  }
} else {
  header("Location: login.php");
}
?>


<?php
function isExist()
{
  require "config_mysql.php";
  //assign variables to post values
  $userType = $_POST["userType"];
  $username = $_POST["username"];
  $password = $_POST["pass1"];

  //get the user with username
  $stmt = $conn->prepare('SELECT * FROM users WHERE username = :username and userType = :userType');
  if ($_SERVER["REQUEST_METHOD"] == "POST")
    try {
      echo "1";
      $stmt->execute(['username' => $username, 'username' => $username]);

      //check if username exist
      if ($stmt->rowCount() > 0) {
        //get the row
        echo "2";
        $user = $stmt->fetch();

        //validate inputted password with $user password
        if (password_verify($password, $user['pass1'])) {
          //action after a successful login
          echo "3";

          return true;
        } else {
          //return the false for failed login
          echo "4";

          return false;
        }
      } else {
        echo "5";

        return false;
      }
    } catch (PDOException $e) {
      echo "6";

      return false;
    }
  else {
    echo "7";

    return false;
  }
}