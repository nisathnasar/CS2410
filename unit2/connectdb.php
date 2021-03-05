

<?php
   $db = new PDO("mysql:dbname=carent; host=localhost;", "root", "");
   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $rows=$db->query("SELECT * FROM vehicles");
   if($rows->rowCount() > 0){
      $first_row = $rows->fetch();
   }
  
?>