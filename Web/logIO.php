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
function isExist() {
  // require_once 'config_mysql.php';
  require_once 'nguyen_config_mysql.php';

  echo "User Type: ", $_POST['userType'], "<br>";
  echo "Username: ", $_POST['username'], "<br>";
  echo "Password: ", $_POST['pass1'], "<br>";
  echo "Full data: ", implode(" ", $_POST), "<br>";

  $hashPassword = password_hash($_POST['pass1'], PASSWORD_DEFAULT);
  $sql = "SELECT password FROM users WHERE username='".$_POST['username']."'";
  $result = $conn->query($sql);

  while($row = $result->fetch_assoc()) {
    if (password_verify($_POST['pass1'], $row['password'])) {
        return TRUE;
    } else {
        return FALSE;
    }
  }

  return FALSE;
}
