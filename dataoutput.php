<?php

require_once('pdo.php');
$sum = NULL;
$output = 0;

if (isset($_POST['dateselect']))
{
    if ($_POST['startdate'] != NULL && $_POST['enddate'] != NULL)
    {
        $startdate = $_POST['startdate'];
        $enddate = $_POST['enddate'];
        $exptype = $_POST['exptype'];       
        
        if ($enddate >= $startdate)
        {   
            if ($exptype == 'default'){
            
            $sql = "SELECT SUM(sum) FROM main WHERE date >= '$startdate' and date <= '$enddate'";
            print_r($sql);
            $stmt = $pdo->query($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);          
            
            echo('<br><br>');
            print_r($row);
            $sum = $row['SUM(sum)']; 
            } 
            else {
               $sql = "SELECT SUM(sum) FROM main WHERE date >= '$startdate' and date <= '$enddate' and category = '$exptype'";
                print_r($sql);
                $stmt = $pdo->query($sql);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC); 
                echo('<br><br>');
                print_r($row);
                $sum = $row['SUM(sum)'];
            }                        
                        
        } else {
            
            echo('Incorrect date range');
        }
        
    } else
    {
        echo('Please, provide correct input');
    }
}


?>


<html>
    <body>
        <h1>Please, select the date range you want to get expenses for:</h1>
        <form id="queryfm" method="post">
            <p><label>Please, select the date range:</label>
                <input type="date" name="startdate" id="startdate">
                <input type="date" name="enddate" id="enddate">
                <p><label for="exptype">Please, select the expenses type:</label>
                <select name="exptype">
                <option value="default">--Select the expences type--</option>
                <option value="transport">Transport</option>
                <option value="foods">Foods</option>
                <option value="meals">Meals</option>
                <option value="fun">Fun</option>
                <option value="health">Health</option>
                <option value="clothing">Clothing</option>
                <option value="home">Home</option>
                <option value="services">Services</option>
                <option value="toys">Toys</option>
                <option value="study">Study</option>
                <option value="telecom">Telecom</option>
                <option value="other">Other</option>
                </select></p>  
                <input type="submit" name="dateselect" id="dateselect" value="Select">
                </p>
        </form>        
        
        <h2>Sum for indicated period is : <?php if ($sum == NULL) {echo('0');} else {echo($sum);} ?></h2>      
     
        
    </body>
</html>