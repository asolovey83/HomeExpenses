<?php
session_start();
require_once('header.php');
require('pdo.php');
require('bootstrap.php');
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
        $_SESSION['startdate'] = $startdate;
        $_SESSION['enddate'] = $enddate;
        $_SESSION['exptypeout'] = $exptype;
            
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
        <title>Expences Output</title>
    </head> 

<body class="bg-info">
    <?php
        
        print_r($_SESSION);       
            
        $startdate = isset($_SESSION['startdate']) ? $_SESSION['startdate']:NULL;
        $enddate = isset($_SESSION['enddate']) ? $_SESSION['enddate']:NULL;
        $exptype = isset($_SESSION['exptypeout']) ? $_SESSION['exptypeout']: "transport";
            
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
                echo('<p><input class="form-group" type="date" name="startdate" id="startdate" value="');
                echo(htmlentities($startdate));
                echo('">');
                echo('<input class="form-group" type="date" name="enddate" id="enddate" value="');
                echo(htmlentities($enddate));
                echo('"></p>');                           
            
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
             echo('<div class="row">');
             echo ('<h2 onclick="showExp()">Show/hide detailed expenses list</h2>');
             echo ('</div>');
             echo('<div class="row" id="detExp" style="display:none;">');
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
             echo('</div>');
            
        }

   ?>
    
<script type="text/javascript">
    function showExp() {
        var x = document.getElementById("detExp");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>


</body>

</html>