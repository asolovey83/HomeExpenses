<?php

if(isset($_POST['submit']))
{
    if ($_POST['login'] !=NULL && $_POST['password'] != NULL)
    {
        if ($_POST['login'] == 'andrew' && $_POST['password'] == 'password')
        {
            header("Location: datainput.php");
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
<body>
<h1>Please, login into expenses tracking system:</h1>
<form method="post">
    <p><label for="login">Login:</label>
        <input type="text" id="login" name="login"></p>
    <p><label for="password">Password:</label>
        <input type="password" id="password" name="password"></p>
    <input type="submit" id="submit" value="Login" name="submit">
</form>
</body>
<html>