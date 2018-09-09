<?php
session_start();
require_once('pdo.php');
require('bootstrap.php');
require_once('header.php');

$userid = $_GET['id'];
$sql = "SELECT id, date, category, description, sum FROM main WHERE id = :user" ;
$stmt = $pdo->prepare($sql);
$stmt->execute(array(":user" => $userid));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
print_r($row);


if (isset($_POST['submit']))
{
    $sqlupd = "UPDATE main SET date = :w, category = :x, description = :y, sum =:z WHERE id = :user";
    $stmt = $pdo->prepare($sqlupd);
    $stmt->execute(array(
        ":user" => $userid,
        ":w" => $_POST['expdate'],
        ":x" => $_POST['exptype'],
        ":y" => $_POST['expdesc'],
        ":z" => $_POST['expsum']
    ));
    
    echo ('The expenses are edited');                
    header( "refresh:3; url=dataoutput.php");
}

?>

<html>
    <head>
        <title>Update Expenses</title>
    </head>
    
    <body class="bg-info">


<?php

echo('<div class="container">');

echo ('<h2>Please, edit the following expenses:</h2>');    

echo('<table class="table table-bordered">');
echo('<tr><th>Date</th><th>Category</th><th>Description</th><th>Sum, UAH</th></tr>');
echo('<tr><td>');
echo($row['date']); 
echo('</td><td>');
echo($row['category']);
echo('</td><td>');
echo($row['description']); 
echo('</td><td>');
echo($row['sum']); 
echo('</td></tr>');
echo('</table>');
echo('</div>');

echo('<div class="container">');
echo('<div class="col-xs-12 col-sm-6">');
echo ('<form id="expform" method="post">');
                echo ('<p><label for="expdate">Enter the date:</label>');
                echo ('<input class="form-control" type="date" name="expdate" id="expdate" value= "');
                echo (htmlentities($row['date'])); 
                echo ('" /></p>');
                
                echo ('<p><label for="exptype">Choose expenses type:</label>');
                echo ('<select class="form-control" name="exptype">');
                
                
                echo ('<option value="transport"');
                if ($row['category'] == "transport") { echo ('selected');}
                echo('>Transport</option>');
                
                echo ('<option value="foods"');
                if ($row['category'] == "foods") { echo ('selected');}
                echo('>Foods</option>');
                
                echo ('<option value="fun"');
                if ($row['category'] == "fun") { echo ('selected');}
                echo('>Fun</option>'); 
                
                echo ('<option value="health"');
                if ($row['category'] == "health") { echo ('selected');}
                echo('>Health</option>'); 
                
                echo ('<option value="clothing"');
                if ($row['category'] == "clothing") { echo ('selected');}
                echo('>Clothing</option>');
                
                echo ('<option value="home"');
                if ($row['category'] == "home") { echo ('selected');}
                echo('>Home</option>');
                
                echo ('<option value="toys"');
                if ($row['category'] == "toys") { echo ('selected');}
                echo('>Toys</option>');
                
                echo ('<option value="study"');
                if ($row['category'] == "study") { echo ('selected');}
                echo('>Study</option>');
                
                echo ('<option value="telecom"');
                if ($row['category'] == "telecom") { echo ('selected');}
                echo('>Telecom</option>');
                
                echo ('<option value="other"');
                if ($row['category'] == "other") { echo ('selected');}
                echo('>Other</option>');
                
                echo ('</select></p>');
                
                echo ('<p><label for="expdesc">Give the expences description:</label></p>');
                
                echo ('<p><textarea class="form-control" name="expdesc" id="expdesc" rows="10" cols="30" placeholder= "');
                echo (htmlentities($row['description']));
                echo ('"></textarea></p>');
                
                echo ('<p><label for="expsum">Enter the sum, UAH: </label>');
                echo (' <input type="text" name="expsum" id="expsum" value="');
                echo (htmlentities($row['sum']));
                echo ('"/></p>');
                echo ('<p><input class="btn btn-primary" type="submit" id="submit" name="submit" value="Edit"> ');
                echo('<a href="dataoutput.php"> Cancel</a></p>');
                echo ('</form>');
        echo('</div>');
        echo('</div>');

?>
        
    </body>
</html>