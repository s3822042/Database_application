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
      $query = "SELECT * FROM user_db WHERE username = '$username'";
      // Values array for PDO
      // $values = [':name' => $username];
      // Execute the query 
      try {
        $res = $pdo->prepare($query);
        $res->execute($username);
      } catch (PDOException $e) {
        // Query error 
        return false;
      }

      $row = $res->fetch(PDO::FETCH_ASSOC);

      // If there is a result, check if the password matches using password_verify()
      if (is_array($row)) {
        if (password_verify($password, $row['password'])) {
          // The password is correct
          return true;
        }
      return false;
      }
    }
    return false;
  }
  echo "8";
  return false;
}