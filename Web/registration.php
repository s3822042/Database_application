<?php
  session_start();

  if (isset($_SESSION['user'])) {
    session_destroy();
  }

  if(isset($_POST['submit'])) {
    if (isSuccess()) {
      $_SESSION['user']['type'] = htmlentities($_POST["userType"], ENT_QUOTES);
      header("Location: index.php");
    } else {
      $_SESSION['status'] = "User is already exist";
      header("Location: signup.php");
    }
  }
?>

<?php
function isSuccess() {
  require_once 'nguyen_config_mysql.php';
  // echo "User Type: ", $_POST['userType'], "<br>";
  // echo "Username: ", $_POST['username'], "<br>";
  // echo "Username: ", $_POST['disHub'], "<br>";
  // echo "longitude: ", $_POST['longitude'], "<br>";
  // echo "latitude: ", $_POST['latitude'], "<br>";
  // echo "Password 1: ", $_POST['pass1'], "<br>";
  // echo "Password 2: ", $_POST['pass2'], "<br>";
  // echo "Full data: ", implode(" ", $_POST);




  $type = ucfirst($_POST['userType']);
  $sql = "SELECT ".$type."Username FROM $_POST[userType] WHERE ".$type."Username = ?";
  $result = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
  $result->execute(array($_POST['username']));

  // Return FALSE if the username already exists.
  while($row = $result->fetch()) {
    return FALSE;
  }

  if (strcmp($_POST['userType'], 'shipper') == 0) {
    if(signup_shipper($pdo)) {
      $_SESSION['user']['id'] = $pdo->lastInsertId();
      return TRUE;
    }
    return FALSE;
  } else {
    if (signup_cus_ven($pdo)) {
      $_SESSION['user']['id'] = $pdo->lastInsertId();
      return TRUE;
    }
    return FALSE;
  }

   // True if the user register success; False otherwise
}

function cast($addition) {
  return ucfirst($_POST['userType']) . $addition;
}

function signup_shipper($pdo) {
  $acc_username = cast('Username');
  $acc_password = cast('Password');
  $acc_dishub = "HubID";
  $sql = "INSERT INTO $_POST[userType] ($acc_username, $acc_password, $acc_dishub);
  VALUES(?, ?, ?)";

  $username_entity = htmlentities($_POST['username']);
  $password_entity = htmlentities($_POST['pass1']);
  $dishub_entity = htmlentities($_POST['disHub']);

  try {
    $sql = "SELECT HubID FROM hub WHERE HubName = ?";
    $result = $pdo->prepare($sql);
    $result->execute(array($dishub_entity));

    while($row = $result->fetch()) {
      $hashPassword = password_hash($password_entity, PASSWORD_DEFAULT);
      $sql = "INSERT INTO $_POST[userType] ($acc_username, $acc_password, $acc_dishub) VALUES(?, ?, ?)";

      $result = $pdo->prepare($sql);
      $result->bindParam(1, $username_entity);
      $result->bindParam(2, $hashPassword);
      $result->bindParam(3, $row['HubID'], PDO::PARAM_INT);
      $result->execute();

      return TRUE;
    }
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    return FALSE;
  }

  return FALSE;
}

function signup_cus_ven($pdo) {
  $acc_username = cast('Username');
  $acc_password = cast('Password');
  $acc_name = cast('Name');
  $acc_address = cast('Address');

  $sql = "INSERT INTO $_POST[userType] ($acc_name, $acc_address, $acc_username, $acc_password, latitude, longitude)
  VALUES(?, ?, ?, ?, ?, ?)";

  $username_entity = htmlentities($_POST['username']);
  $password_entity = htmlentities($_POST['pass1']);
  $address_entity = htmlentities($_POST['address']);
  $name_entity = htmlentities($_POST['name']);
  $longitude_entity = htmlentities($_POST['longitude']);
  $latitude_entity = htmlentities($_POST['latitude']);

  try {
    $hashPassword = password_hash($password_entity, PASSWORD_DEFAULT);
    $result = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $result->bindParam(1, $name_entity);
    $result->bindParam(2, $address_entity);
    $result->bindParam(3, $username_entity);
    $result->bindParam(4, $hashPassword);
    $result->bindParam(5, $latitude_entity, PDO::PARAM_INT);
    $result->bindParam(6, $longitude_entity, PDO::PARAM_INT);
    $result->execute();
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    return FALSE;
  }
  return TRUE;
}
?>
