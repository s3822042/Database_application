<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<style media="screen">
  ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
  }

  li {
    float: right;
  }

  .btn-signout {
    display: block;
    text-align: center;
    padding: 10px 16px;
    text-decoration: none;
    cursor: pointer;
    background-color: #E9F5FE;
  }

  .btn-signout:hover {
    background-color: #239BF4;
    color: white;
  }
</style>
<body>

<ul>
  <form class="" action="logIO.php" method="post">
    <li><button name="logout" class="btn-signout">Sign Out</button></li>
  </form>
</ul>

</body>
</html>
