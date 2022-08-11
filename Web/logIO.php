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
  echo "1";
  include "config_mysql.php";
  $username = $_POST['username'];
  $password = $_POST['pass1'];
  $username_err = $password_err = $login_err = "";
  echo "1";
  // echo "User Type: ", $_POST['userType'], "<br>";
  // echo "Username: ", $_POST['username'], "<br>";
  // echo "Password: ", $_POST['pass1'], "<br>";
  // echo "Full data: ", implode(" ", $_POST), "<br>";
  // Processing form data when form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "1";
    // // Check if username is empty
    // if (empty(trim($username))) {
    //   $username_err = "Please enter username.";
    // } else {
    //   $username = trim($username);
    // }

    // // Check if password is empty
    // if (empty(trim($password))) {
    //   $password_err = "Please enter your password.";
    // } else {
    //   $password = trim($password);
    // }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
      // Prepare a select statement
      $sql = "SELECT * FROM users WHERE username = '$username'";

      if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_username);

        // Set parameters
        $param_username = $username;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
          // Store result
          mysqli_stmt_store_result($stmt);

          // Check if username exists, if yes then verify password
          if (mysqli_stmt_num_rows($stmt) == 1) {
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
            if (mysqli_stmt_fetch($stmt)) {
              if (password_verify($password, $hashed_password)) {
                // Password is correct, so start a new session
                return TRUE;
              } else {
                // Password is not valid, display a generic error message
                return FALSE;
              }
            }
          } else {
            // Username doesn't exist, display a generic error message
            return FALSE;
          }
        } else {
          return FALSE;
        }

        // Close statement
        mysqli_stmt_close($stmt);
      }
    }
    
    return FALSE; // True if the user exists in database; False otherwise.
  }
  
}