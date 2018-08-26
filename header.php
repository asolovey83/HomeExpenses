<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="#">HomeExpenses</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav navbar-right">
      <li class="active"><a href="login.php">Home</a></li>
      <li><a href="datainput.php">Enter the data</a></li>
      <li><a href="dataoutput.php">View the data</a></li> 
      <li><?php 
          if (isset($_SESSION['login'])) 
              {
                  echo ('<a href="logout.php">Log Out</a>');
              } else if (!isset($_SESSION['login']))
          {
              echo ('<a href="login.php">Log In</a>');
          } ?></li>
    </ul>
      </div>
  </div>
</nav>
    </body>
</html>