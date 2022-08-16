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
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
      //assign variables to post values
      $name = $_POST['name'];
      $address = $_POST['address'];
      $username = $_POST['username'];
      $password = $_POST['pass1'];
      $confirm = $_POST['pass2'];

      //check if password matches confirm password
      if($password != $confirm){
          return false;
      }
      else{
          //include our database connection
          require "config_mysql.php";

          //check if the email is already taken
          $stmt = $conn->prepare('SELECT * FROM users WHERE username = :username');
          $stmt->execute(['username' => $username]);

          if($stmt->rowCount() > 0){
              //email already taken
              return false;
          }
          else{
              //encrypt password using password_hash()
              $password = password_hash($password, PASSWORD_DEFAULT);

              //insert new user to our database
              $stmt = $conn->prepare('INSERT INTO users (name, address, username, password) VALUES (:name, :address, :username :password)');

              try{
                  $stmt->execute(['name' => $name, 'address' => $address, 'username' => $username, 'password' => $password]);
                  return true;
              }
              catch(PDOException $e){
                  return false;
              }

          }

      }

  }
  else{
      return false;
  }
    return true; // True if the user register success; False otherwise
  }
?>