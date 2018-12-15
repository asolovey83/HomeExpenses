<?php
require_once('header.php');
require('bootstrap.php');
require_once('pdo.php');
session_start();
$salt = "XyZzy12*_";

if (isset($_SESSION['login']) && isset($_SESSION['password'])) { unset($_SESSION['login']); unset($_SESSION['password']); }

if(isset($_POST['logininput']) || isset($_POST['loginoutput']) )
{
    if ($_POST['login'] !=NULL && $_POST['password'] != NULL)
    {
        
        $sql = "SELECT * FROM users";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($rows as $row)
        {
        
        if (($_POST['login'] == $row['name'] || $_POST['login'] == $row['email']) && md5($salt.$_POST['password']) == $row['password'])
        {
            $_SESSION['login'] = $_POST['login'];
            $_SESSION['password'] = $_POST['password'];
            if ($_POST['logininput'])
            {
                header("Location: datainput.php?id=" . $row['user_id']);
            } else if ($_POST['loginoutput'])
            {
                header("Location: dataoutput.php?id=" . $row['user_id']);
            }
            return;
        } else {
            echo('Incorrect login or password. Please, try again.');
        }        
     } 
    }else {
        echo('Login or password is missing');
    }
    
}
?>


<html>

<head>
    <title>Log In Page</title>
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
</body>
<html>