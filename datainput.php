<?php
require_once('pdo.php');
date_default_timezone_set('Europe/Kiev');


session_start();
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
    <title>Expences Input</title>
    <body>
        <h1>Today is <?php echo date("d/m/Y"); ?><p>Please, input your expences</p></h1>
        
        <?php
        $expdate = isset($_SESSION['expdate']) ? $_SESSION['expdate']:NULL;
        $exptype = isset($_SESSION['exptype']) ? $_SESSION['exptype']: "transport";
        $expdesc = isset($_SESSION['expdesc']) ? $_SESSION['expdesc']: "";
        $expsum = isset($_SESSION['expsum']) ? $_SESSION['expsum']: "";      
        ?>
        
        <form id="expform" method="post">
            <p><label for="expdate">Enter the date:</label>
                <input type="date" name="expdate" id="expdate" value= "<?php echo(htmlentities($expdate)); ?>" /></p>
            <p><label for="exptype">Choose expenses type:</label>
                <select name="exptype">
                <option <?php if($exptype == "transport"){echo "selected=\"selected\"";} ?> value="transport">Transport</option>
                <option <?php if($exptype == "foods"){echo "selected=\"selected\"";} ?> value="foods">Foods</option>
                <option <?php if($exptype == "meals"){echo "selected=\"selected\"";} ?> value="meals">Meals</option>
                <option <?php if($exptype == "fun"){echo "selected=\"selected\"";} ?> value="fun">Fun</option>
                <option <?php if($exptype == "health"){echo "selected=\"selected\"";} ?> value="health">Health</option>
                <option <?php if($exptype == "clothing"){echo "selected=\"selected\"";} ?> value="clothing">Clothing</option>
                <option <?php if($exptype == "home"){echo "selected=\"selected\"";} ?> value="home">Home</option>
                <option <?php if($exptype == "services"){echo "selected=\"selected\"";} ?> value="services">Services</option>
                <option <?php if($exptype == "toys"){echo "selected=\"selected\"";} ?> value="toys">Toys</option>
                <option <?php if($exptype == "study"){echo "selected=\"selected\"";} ?> value="study">Study</option>
                <option <?php if($exptype == "telecom"){echo "selected=\"selected\"";} ?> value="telecom">Telecom</option>
                <option <?php if($exptype == "other"){echo "selected=\"selected\"";} ?> value="other">Other</option>
                </select></p>            
            <p><label for="expdesc">Give the expences description:</label></p>
                <p><textarea name="expdesc" id="expdesc" rows="10" cols="30" placeholder= "<?php echo(htmlentities($expdesc)); ?>"></textarea></p>
            <p><label for="expsum">Enter the sum:</label>
                <input type="text" name="expsum" id="expsum" <?php   echo 'value="' . htmlentities($expsum) . '"';?> /></p>
            <p><input type="submit" id="submit" name="submit" value="Записать"></p>             
            </form> 
        
        <h2>Session variables</h2>
        <?php foreach ($_SESSION as $key => $value) {
            echo ($key);
            echo("=>");
            echo($value);
            echo("<br />");
            } ?>
               
        
    </body>
</html>