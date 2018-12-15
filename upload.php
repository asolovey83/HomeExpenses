<?php

if(isset($_FILES['fileToUpload'])){
      $errors= array();
      /*$file_name = $_FILES['fileToUpload']['name'];*/
      $file_size =$_FILES['fileToUpload']['size'];
      $file_tmp =$_FILES['fileToUpload']['tmp_name'];
      $file_type=$_FILES['fileToUpload']['type'];
      $tmp = explode('.',$_FILES['fileToUpload']['name']);
      $file_ext=strtolower(end($tmp));
      $file_name = 'importdata.' . $file_ext;
      
      $expensions= array("xls","xlsx");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a XLS or XLSX file.";
      }
      
      if($file_size > 2097152){
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"PhpSpreadsheet/samples/Reader/sampleData/".$file_name);
         echo "Success";
         header('Location:PhpSpreadsheet/samples/Reader/New_sample_expenses.php');
      }else{
         print_r($errors);
      }
   }
?>

<!DOCTYPE html>
<html>
<body>

<form action="" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload File" name="submit">
</form>

</body>
</html>