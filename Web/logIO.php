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
      header("Location: index.php");
    } else {
      $_SESSION['status'] = "User is already exist";
      header("Location: login.php");
    }
  } else {
    header("Location: login.php");
  }
?>


<?php
function isExist() {
  require_once 'nguyen_config_mysql.php';

  echo "User Type: ", $_POST['userType'], "<br>";
  echo "Username: ", $_POST['username'], "<br>";
  echo "Password: ", $_POST['pass1'], "<br>";
  echo "Full data: ", implode(" ", $_POST), "<br>";

  $type = ucfirst($_POST['userType']);
  $sql = "SELECT * FROM `".$_POST['userType']."` WHERE ".$type."Username = ?";
  $result = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
  $result->execute(array(htmlentities($_POST['username'])));

  while($row = $result->fetch()) {
    if (password_verify($_POST['pass1'], $row["".$type."Password"])) {
        $_SESSION['user']['id'] = $row["".$type."ID"];
        return TRUE;
    } else {
        return FALSE;
    }
  }

  return FALSE;
}
