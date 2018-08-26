<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=expenses', 
   'andrew', 'hello');
// See the "errors" folder for details...
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>