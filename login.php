<?php
require_once('header.php');
session_start();

if (isset($_SESSION['login']) && isset($_SESSION['password'])) { unset($_SESSION['login']); unset($_SESSION['password']); }

if(isset($_POST['logininput']) || isset($_POST['loginoutput']) )
{
    if ($_POST['login'] !=NULL && $_POST['password'] != NULL)
    {
        if ($_POST['login'] == 'andrew' && $_POST['password'] == 'password')
        {
            $_SESSION['login'] = $_POST['login'];
            $_SESSION['password'] = $_POST['password'];
            if ($_POST['logininput'])
            {
                header("Location: datainput.php");
            } else if ($_POST['loginoutput'])
            {
                header("Location: dataoutput.php");
            }
            return;
        } else {
            echo('Incorrect login or password. Please, try again.');
        }        
    } else {
        echo('Login or password is missing');
    }
}
?>


<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body class="bg-info">
    <div class="container">
    <h1>Please, login into expenses tracking system:</h1>
    </div>
    <div class="container">
        <div class="col-xs-12 col-sm-6">
        <form method="post">
            <p><label for="login">Login:</label>
                <input class="form-control" type="text" id="login" name="login"></p>
            <p><label for="password">Password:</label>
                <input class="form-control" type="password" id="password" name="password"></p>
            <input class="btn btn-primary" type="submit" id="logininput" value="Login to Input Data" name="logininput">
            <input class="btn btn-primary" type="submit" id="loginoutput" value="Login to Output Data" name="loginoutput">
        </form>
        </div>
    </div>
    
    
    <?php
    /**foreach ($_COOKIE as $key => $value)
    {
        echo $key.' is '.$value."<br>\n";
    }
    
    foreach ($_SESSION as $key => $value)
    {
        echo $key.' is '.$value."<br>\n";
    }*/
    ?>
</body>
<html>