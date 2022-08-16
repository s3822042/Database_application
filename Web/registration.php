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
function isSuccess()
{
  require_once 'db.php';

  // Define variables and initialize with empty values
  $username = $_POST['username'];
  $password = $_POST['password'];
  $confirm_password = "";
  $username_err = $password_err = $confirm_password_err = "";
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

  $stmt = $pdo->prepare("INSERT INTO `user_db` VALUES (:user_type, :name, :address, :username, :password)");
  $stmt->bindParam(':user_type', $_POST["user_type"]);
  $stmt->bindParam(':name', $_POST["name"]);
  $stmt->bindParam(':address', $_POST["address"]);
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':password', $password);

  try {
      $stmt->execute();
      echo "<script type='text/javascript'>alert('Create successfully');</script>";
      echo "<script>window.location.href='auctions.php';</script>";
  } catch (PDOException $e) {
      $code = $e->getCode();
      if ($code == 23000) {
          echo "<script type='text/javascript'>alert('Email/Phone/Id number has been register before');</script>";
      } else {
          echo "<script type='text/javascript'>alert('An error occurred. Not create successfully');</script>";
      }
  }
  //  Validate username
  if (empty(trim($username))) {
    $username_err = "Please enter a username.";
  } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($username))) {
    $username_err = "Username can only contain letters, numbers, and underscores.";
  } else {
    // Prepare a select statement
    $sql = "SELECT id FROM users WHERE username = $username";

    if ($stmt = mysqli_prepare($link, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_username);

      // Set parameters
      $param_username = trim($username);

      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        /* store result */
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
          $username_err = "This username is already taken.";
        } else {
          $username = trim($_POST["username"]);
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }

      // Close statement
      mysqli_stmt_close($stmt);
    }
  }

  // Validate password
  if (empty(trim($password))) {
    $password_err = "Please enter a password.";
  } elseif (strlen(trim($password)) < 6) {
    $password_err = "Password must have atleast 6 characters.";
  } else {
    $password = trim($password);
  }

  // Validate confirm password
  if (empty(trim($_POST["confirm_password"]))) {
    $confirm_password_err = "Please confirm password.";
  } else {
    $confirm_password = trim($_POST["confirm_password"]);
    if (empty($password_err) && ($password != $confirm_password)) {
      $confirm_password_err = "Password did not match.";
    }
  }

  // Check input errors before inserting in database
  if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

    // Prepare an insert statement
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

    if ($stmt = mysqli_prepare($link, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

      // Set parameters
      $param_username = $username;
      $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        // Redirect to login page
        header("location: login.php");
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }

      // Close statement
      mysqli_stmt_close($stmt);
    }
  }

  // Close connection
  mysqli_close($link);
  // echo "User Type: ", $_POST['userType'], "<br>";
  // echo "Username: ", $_POST['username'], "<br>";
  // echo "Username: ", $_POST['disHub'], "<br>";
  // echo "Password 1: ", $_POST['pass1'], "<br>";
  // echo "Password 2: ", $_POST['pass2'], "<br>";
  // echo "Full data: ", implode(" ", $_POST);

  return TRUE; // True if the user register success; False otherwise
}
?>
