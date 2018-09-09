<?php
session_start();
require('pdo.php');


    $userid = $_GET['id'];
    $sql = "SELECT id, date, category, description, sum FROM main WHERE id = :user" ;
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(":user" => $userid));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (isset($_POST['delete']))
    {
        $sql = "DELETE FROM main WHERE id = :xyz";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(":xyz" => $userid));
        
        //Check if delete was succesfull
        $checkdel ="SELECT count(*) FROM main WHERE id = :user";
        $stmt = $pdo->prepare($checkdel);
        $stmt->execute(array(":user" => $userid));
        $res = $stmt->fetchColumn();
        
        if ($res > 0)
        {
            $_SESSION['error'] = 'Some error occured. Please, try again';
            header("Location:dataoutput.php");
            return;
        } else {                
            $_SESSION['success'] = 'Record was succesfully deleted!';
            header("Location:dataoutput.php");
            return;
        }
    } 

?>

<html>
    <head>
    </head>
    <body>
        <p>Are you sure you want to delete this expences from the table:</p>      
        <table border="1">
        <tr><th>Date</th><th>Category</th><th>Description</th><th>Sum, UAH</th></tr>
        <tr>
            <td><?php echo($row['date']); ?></td>
            <td><?php echo($row['category']); ?></td>
            <td><?php echo($row['description']); ?></td>
            <td><?php echo($row['sum']); ?></td>
        </tr>
        </table>
        
        <form method="post">            
        <p><input type="submit" name="delete" id="delete" value="Delete">
            <a href="dataoutput.php">Cancel</a></p>
        </form>
    </body>
    
</html>

