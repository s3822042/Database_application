<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/signup.css">
  <title>Sign in</title>
</head>
<body>

  <div class='block'>
    <form class='form' id="login" method="post" onsubmit="return handleSubmit();" action='logIO.php'>
    <h1>Sign in</h1>
      <div class='form-control'>

        <div class="forum" style={{marginTop: 20}}>
          <input id="inputUserType" type="hidden" name="userType" value="customer">
          <ul id="userType" style="padding-left: 0px;">
            <li id="customer" class="button-34 btnActive" onclick="changeUserType('customer');">Customer
            <li id="vendor" class="button-34" onclick="changeUserType('vendor');">Vendor
            <li id="shipper" class="button-34" onclick="changeUserType('shipper');">Shipper
          </ul>
        </div>

        <div class='input-block'>
          <span id='username' class='req' style="float:right;">* Require</span>
          <div style="clear:both;"></div>
          <div class='wrapper'>
            <div id='field3' class='input-control inside'>
              <input id='inputUsername' type='text' placeholder=' ' name='username'
                     onclick="addBorder('field3')"
                     onBlur="rmvBorder('field3')">
              <label class='move-out'>Username</label>
            </div>
          </div>
        </div>

        <div class='input-block'>
          <span id='pass1' class='req' style="float:right;">* Require</span>
          <div style="clear:both;"></div>
          <div class='wrapper'>
            <div id='field4' class='input-control inside'>
              <input id='inputPass1' type='password' placeholder=' ' name='pass1'
                     onclick="addBorder('field4')"
                     onBlur="rmvBorder('field4')">
              <label class='move-out'>Password</label>
              <div class='img-item' onclick="displayPassword('inputPass1', 'eye1')">
                <img id='eye1' src="asset/hide.png"/>
              </div>
            </div>
          </div>
        </div>

        <div id='wrongpass' class='req' style="margin-top: 15px;">* Password must match ! Please try again</div>
        <a href="signup.php" style="display: block; width: 100%; margin-top: 5px; margin-bottom: 15px;">Dont' have an account? Sign up here</a>
        <button type="submit" name="logIO" class="buttonSubmit">Sign in</button>

      </div>
    </form>
  </div>

  <script src="js/login.js"></script>
  <script src="js/common.js"></script>

</body>
</html>
