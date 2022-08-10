<?php
  session_start();

  if (isset($_SESSION['user'])) {
    session_destroy();
  }

  if (isSuccess()) {
    $_SESSION['user']['type'] = htmlentities($_POST["userType"], ENT_QUOTES);
    header("Location: home.php");
  } else {
    header("Location: signup.php");
  }
?>

<?php
  function isSuccess() {
    // echo "User Type: ", $_POST['userType'], "<br>";
    // echo "Username: ", $_POST['username'], "<br>";
    // echo "Username: ", $_POST['disHub'], "<br>";
    // echo "Password 1: ", $_POST['pass1'], "<br>";
    // echo "Password 2: ", $_POST['pass2'], "<br>";
    // echo "Full data: ", implode(" ", $_POST);

    return TRUE; // True if the user register success; False otherwise
  }
?>
