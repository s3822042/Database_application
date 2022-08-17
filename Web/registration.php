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
    require "config_mysql.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
      //assign variables to post values
      $userType = $_POST['userType'];
      $name = $_POST['name'];
      $address = $_POST['address'];
      $username = $_POST['username'];
      $password = $_POST['pass1'];
      $confirm = $_POST['pass2'];

          //check if the username is already taken
          $stmt = $conn->prepare('SELECT * FROM users WHERE username = :username and userType= :userType');
          $stmt->bindValue(':username',$username);
          $stmt->bindValue(':userType',$userType);
          $stmt->execute();
          $user= $stmt->fetch();
          echo $stmt->rowCount();
          if($stmt->rowCount() > 0){
              //username with that usertype already taken
              return false;
          }
          else{
              //encrypt password using password_hash()
              $password = password_hash($password, PASSWORD_DEFAULT);

              //insert new user to our database
              $stmt = $conn->prepare('INSERT INTO users (userType,name, address, username, password) VALUES (:userType,:name, :address, :username, :password)');

              try{
                  $stmt->bindValue(':userType',$userType);
                  $stmt->bindValue(':name',$name);
                  $stmt->bindValue(':address',$address);
                  $stmt->bindValue(':username',$username);
                  $stmt->bindValue(':password',$password);
                  $stmt->execute();
                  return true;
              }
              catch(PDOException $e){
                  return false;
              }

          }

      }
      return false;
  }
?>