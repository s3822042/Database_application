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
  // echo "User Type: ", $_POST['userType'], "<br>";
  // echo "Username: ", $_POST['username'], "<br>";
  // echo "Password: ", $_POST['pass1'], "<br>";
  // echo "Full data: ", implode(" ", $_POST), "<br>";


  return TRUE; // True if the user exists in database; False otherwise.
}
?>
