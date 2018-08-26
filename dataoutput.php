<?php
session_start();
require_once('header.php');
require('pdo.php');
$sum = NULL;
$sqlshow = NULL;
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
            $sqlshow = "SELECT id, date, category, description, sum FROM main WHERE date >= '$startdate' and date <= '$enddate'";
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
                $sqlshow = "SELECT id, date, category, description, sum FROM main WHERE date >= '$startdate' and date <= '$enddate' and category = '$exptype'";
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

if (isset($_POST['delete']) && isset($_POST['id']))
{
    $sqldel="DELETE FROM main WHERE id = :zip";
    $stmt = $pdo->prepare($sqldel);
    $stmt -> execute(array(":zip" => $_POST['id']));        
}

?>


<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body class="bg-info">
    <?php
        
        print_r($_SESSION);
    
        //Success flash message using $_SESSION variable    
        if (isset($_SESSION['success'])) 
        {
            echo('<p style="color:green">' .$_SESSION['success']. '</p>');
            unset($_SESSION['success']);
        }
    
        if (!isset($_SESSION['login']))
            {
                echo('<div class="container">');
                echo ('<h2>Please, <a href="login.php"> Log In </a> to input you expenses!</h2>');
                echo('</div>');
            } else 
            {
                echo('<div class="container">');
                echo('<h2>Please, select the date range you want to get expenses for or <a href="logout.php">Log out.</a></h2>');
                echo('</div>');            
                echo('<div class="container">');
                echo('<div class="col-xs-12 col-sm-6">');
                echo ('<form id="queryfm" method="post">');
                echo('<p><label>Please, select the date range:</label></p>');
                echo('<p><input class="form-group" type="date" name="startdate" id="startdate">          ');
                echo('<input class="form-group" type="date" name="enddate" id="enddate"></p>');               
                echo('<p><label for="exptype">Please, select the expenses type:</label>');
                echo('<select class="form-control" name="exptype">');
                echo('<option value="default">--Select the expences type--</option>');
                echo('<option value="transport">Transport</option>');
                echo('<option value="foods">Foods</option>');
                echo('<option value="meals">Meals</option>');
                echo('<option value="fun">Fun</option>');
                echo('<option value="health">Health</option>');
                echo('<option value="clothing">Clothing</option>');
                echo('<option value="home">Home</option>');
                echo('<option value="services">Services</option>');
                echo('<option value="toys">Toys</option>');
                echo('<option value="study">Study</option>');
                echo('<option value="telecom">Telecom</option>');
                echo('<option value="other">Other</option>');
                echo('</select></p>');  
                echo('<input class="btn btn-primary" type="submit" name="dateselect" id="dateselect" value="Select">');
                echo('</p>');
                echo('</form>');        
        
                echo('<h3>Sum for indicated period is :');
                if ($sum == NULL) {echo('0');} else {echo($sum);} 
                echo('</h3>'); 
                echo('</div>');                
                echo('</div>');
            }      
            
     
        
                    

        if ($sqlshow != NULL)
        {
            $stmt = $pdo->query($sqlshow);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
             echo('<div class="container">');             
             echo ("<h2>Detailed expenses list</h2>");
             echo ('<table class="table table-bordered">');
             echo('<thead class="thead-dark">');
             echo("<tr><th>Date</th><th>Category</th><th>Description</th><th>Sum, UAH</th><th>Delete/Update</th></tr>");
             echo('</thead>');
             echo('<tbody>');
        foreach ($rows as $row) {         
             echo("<tr><td>"); 
             echo(htmlentities($row['date']));            
             echo("</td><td>");
             echo(htmlentities($row['category']));
             echo("</td><td>");
             echo(htmlentities($row['description']));
             echo("</td><td>");
             echo(htmlentities($row['sum']));
             echo("</td><td>");
             //echo('<form method="post"><input type="hidden" ');
             //echo('name="id" value="'.$row['id'].'">'."\n");
             //echo('<input type="submit" value="Del" name="delete">');
             //echo("\n</form>\n"); 
             echo('<a href="delete.php?id='. $row['id'].'">Delete</a>');
             echo(' / ');
             echo('<a href="update.php?id='. $row['id'].'">Update</a>');
             echo("</td></tr>\n");
            }
             echo('</tbody>');
             echo('</table>');
             echo('</div>');
            
        }

   ?>


</body>

</html>