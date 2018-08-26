<?php
require_once('pdo.php');
date_default_timezone_set('Europe/Kiev');


session_start();

require_once('header.php');

if (isset($_POST['submit']))
{
    
    if ($_POST['expdate'] != NULL)
    {
        $expdate = $_POST['expdate'];
        if ($_POST['exptype'] != NULL)
        {
            $exptype = $_POST['exptype'];
            if($_POST['expsum'] != NULL)
            {   
                $expsum = $_POST['expsum'];
                $expdesc = $_POST['expdesc'];
                $_SESSION['expsum'] = $expsum;        
                $_SESSION['expdesc'] = $expdesc;
                $_SESSION['exptype'] = $exptype;
                $_SESSION['expdate'] = $expdate;
              
                
                $sql='INSERT into main (date, category, description, sum) VALUES (:dt, :cat, :desc, :sum)';
                $stmt=$pdo->prepare($sql);
                $stmt->execute(array(
                    ':dt'=>$_POST['expdate'],
                    ':cat'=>$_POST['exptype'],
                    ':desc'=>$_POST['expdesc'],
                    ':sum'=>$_POST['expsum']
                ));
                
                echo ('The expenses are added to the database');                
                header( "refresh:3; url=datainput.php" );
                
                return;
                
                
            } else {
                echo('Please, enter the expenses sum');
            }
            
        } else {
            echo('Please, enter the expenses type');
        }        
    } else{
        echo('Please, enter the date');
    }    
    
}

?>


<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <title>Expences Input</title>
    <body class="bg-info">
        <div class="container">
            <div class="col-xs-12 col-sm-6">
            <h1>Today is <?php echo date("d/m/Y"); ?></h1>
            </div>
        </div>
        
        
        <?php
        $expdate = isset($_SESSION['expdate']) ? $_SESSION['expdate']:NULL;
        $exptype = isset($_SESSION['exptype']) ? $_SESSION['exptype']: "transport";
        $expdesc = isset($_SESSION['expdesc']) ? $_SESSION['expdesc']: "";
        $expsum = isset($_SESSION['expsum']) ? $_SESSION['expsum']: "";      
        ?>
        
            
        <?php 
            if (!isset($_SESSION['login'])) 
            {
                echo('<div class="container">');
                echo('<div class="col-xs-12 col-sm-6">');
                echo ('<h2>Please, <a href="login.php"> Log In </a> to input you expenses!</h2>'); 
                echo('</div');
                echo('</div');
            } else
            {   echo('<div class="container">');
                echo('<div class="col-xs-12 col-sm-6">');
                echo ('<h2>Please, input you expenses or <a href="logout.php">Log out.</a></h2>');                
                echo ('<form id="expform" method="post">');
                echo ('<p><label for="expdate">Enter the date:</label>');
                echo ('<input class="form-control" type="date" name="expdate" id="expdate" value= "');
                echo (htmlentities($expdate)); 
                echo ('" /></p>');
                
                echo ('<p><label for="exptype">Choose expenses type:</label>');
                echo ('<select class="form-control" name="exptype">');
                
                
                echo ('<option value="transport"');
                if ($exptype == "transport") { echo ('selected');}
                echo('>Transport</option>');
                
                echo ('<option value="foods"');
                if ($exptype == "foods") { echo ('selected');}
                echo('>Foods</option>');
                
                echo ('<option value="fun"');
                if ($exptype == "fun") { echo ('selected');}
                echo('>Fun</option>'); 
                
                echo ('<option value="health"');
                if ($exptype == "health") { echo ('selected');}
                echo('>Health</option>'); 
                
                echo ('<option value="clothing"');
                if ($exptype == "clothing") { echo ('selected');}
                echo('>Clothing</option>');
                
                echo ('<option value="home"');
                if ($exptype == "home") { echo ('selected');}
                echo('>Home</option>');
                
                echo ('<option value="toys"');
                if ($exptype == "toys") { echo ('selected');}
                echo('>Toys</option>');
                
                echo ('<option value="study"');
                if ($exptype == "study") { echo ('selected');}
                echo('>Study</option>');
                
                echo ('<option value="telecom"');
                if ($exptype == "telecom") { echo ('selected');}
                echo('>Telecom</option>');
                
                echo ('<option value="other"');
                if ($exptype == "other") { echo ('selected');}
                echo('>Other</option>');
                
                echo ('</select></p>');
                
                echo ('<p><label for="expdesc">Give the expences description:</label></p>');
                
                echo ('<p><textarea class="form-control" name="expdesc" id="expdesc" rows="10" cols="30" placeholder= "');
                echo (htmlentities($expdesc));
                echo ('"></textarea></p>');
                
                echo ('<p><label for="expsum">Enter the sum, UAH: </label>');
                echo (' <input type="text" name="expsum" id="expsum" value="');
                echo (htmlentities($expsum));
                echo ('"/></p>');
                echo ('<p><input class="btn btn-primary" type="submit" id="submit" name="submit" value="Записать"></p>');
                    
                echo ('</form>');
                echo('</div>');                
                echo('</div>');
            }            
            
        ?>  
       
               
        
    </body>
</html>