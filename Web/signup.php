<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/signup.css">
    <title>Sign up</title>
</head>

<body>

    <div class='block'>
        <form class='form' id="signup" method="post" onsubmit="return handleSubmit();" action='registration.php'>
            <h1>Sign up</h1>
            <div class='form-control'>

                <div class="forum">
                    <input id="inputUserType" type="hidden" name="userType" value="customer">
                    <ul id="userType" style="padding-left: 0px;">
                        <li id="customer" class="button-34 btnActive" onclick="changeUserType('customer');">Customer
                        <li id="vendor" class="button-34" onclick="changeUserType('vendor');">Vendor
                        <li id="shipper" class="button-34" onclick="changeUserType('shipper');">Shipper
                    </ul>
                </div>

                <div id="nameBlock" class='input-block'>
                    <span id='name' class='req' style="float:right;">* Require</span>
                    <div style="clear:both;"></div>
                    <div class='wrapper'>
                        <div id='field1' class='input-control inside'>
                            <input id='inputName' type='text' placeholder=' ' name='name' onclick="addBorder('field1')"
                                onBlur="rmvBorder('field1')">
                            <label class='move-out'>Name</label>
                        </div>
                    </div>
                </div>

                <div id="addressBlock" class='input-block'>
                    <span id='address' class='req' style="float:right;">* Require</span>
                    <div style="clear:both;"></div>
                    <div class='wrapper'>
                        <div id='field2' class='input-control inside'>
                            <input id='inputAddress' type='text' placeholder=' ' name='address'
                                onclick="addBorder('field2')" onBlur="rmvBorder('field2')">
                            <label class='move-out'>Address</label>
                        </div>
                    </div>
                </div>

                <div id="hubBlock" class="input-block"></div>

                <div class='input-block'>
                    <span id='username' class='req' style="float:right;">* Require</span>
                    <div style="clear:both;"></div>
                    <div class='wrapper'>
                        <div id='field3' class='input-control inside'>
                            <input id='inputUsername' type='text' placeholder=' ' name='username'
                                onclick="addBorder('field3')" onBlur="rmvBorder('field3')">
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
                                onclick="addBorder('field4')" onBlur="rmvBorder('field4')"
                                oninput="detectPass('inputPass1', 'strength1', 'passLabel1')">
                            <label class='move-out'>Password</label>
                            <div class='img-item' onclick="displayPassword('inputPass1', 'eye1')">
                                <img id='eye1' src="asset/hide.png" />
                            </div>
                        </div>
                    </div>
                    <div class="passStrength" id='strength1'></div>
                    <span id="passLabel1" class="passLabel">Week</span>
                </div>

                <div class='input-block' style="margin-bottom: 30px; margin-top: 30px;">
                    <span id='pass2' class='req' style="float:right;">* Require</span>
                    <div style="clear:both;"></div>
                    <div class='wrapper'>
                        <div id='field5' class='input-control inside'>
                            <input id='inputPass2' type='password' placeholder=' ' name='pass2'
                                onclick="addBorder('field5')" onBlur="rmvBorder('field5')"
                                oninput="detectPass('inputPass2', 'strength2', 'passLabel2')">
                            <label class='move-out'>Comfirm Password</label>
                            <div class='img-item' onclick="displayPassword('inputPass2', 'eye2')">
                                <img id='eye2' src="asset/hide.png" />
                            </div>
                        </div>
                    </div>
                    <div class="passStrength" id='strength2'></div>
                    <span id="passLabel2" class="passLabel">Week</span>
                </div>

                <div id='wrongpass' class='req' style="margin-top: 15px;">* Password must match ! Please try again</div>
                <a href="login.php" style="display: block; width: 100%; margin-top: 5px; margin-bottom: 15px;">Already
                    have an account? Sign in</a>
                <button type="submit" class="buttonSubmit">Create Account</button>

            </div>
        </form>
    </div>

    <script src="js/signup.js"></script>
    <script src="js/common.js"></script>

</body>

</html>