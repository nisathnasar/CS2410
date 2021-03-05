

<?php
   $db = new PDO("mysql:dbname=carent; host=localhost;", "root", "");
   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $rows=$db->query("SELECT * FROM vehicles");
   if($rows->rowCount() > 0){
      $first_row = $rows->fetch();
   }

   print "connected to db file <br> <br>";

   $mylist = array( "Apple"=>"Red","Bannana"=>"Yellow", "Pear"=>"Yellow","Orange"=>"Orange", "Grapes"=>"Purple" );
foreach ($mylist as $item ) {
   print "$item ";
}
  
?>