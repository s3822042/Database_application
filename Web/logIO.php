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
  include "config_mysql.php";
  $username = $_POST["username"];
  $password = $_POST["pass1"];

  $username_err = $password_err = $login_err = "";
  echo "in";
  // Check if username is empty
  if (empty(trim($_POST["username"]))) {
    $username_err = "Please enter username.";
  }

  // Check if password is empty
  if (empty(trim($_POST["pass1"]))) {
    $password_err = "Please enter your password.";
  }
  // echo "User Type: ", $_POST['userType'], "<br>";
  // echo "Username: ", $_POST['username'], "<br>";
  // echo "Password: ", $_POST['pass1'], "<br>";
  // echo "Full data: ", implode(" ", $_POST), "<br>";
  // Processing form data when form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "1";
    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
      echo "2";
      // Prepare a select statement
      $sql = "SELECT * FROM users WHERE username = '$username'";
      echo "7";
      $result = mysqli_query($connect, $sql);
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
          if (password_verify($password, $row["password"])) {
            return true;
          } else {
            return false;
          }
        }
      } else {
        echo '<script>alert("Wrong User Details")</script>';
        return false;
      }
    }
    // True if the user exists in database; False otherwise.
  }
  echo "8";
  return FALSE;
}
