<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>
<body>
   <?php
      require 'connectdb.php';

   ?>
   <form action="addvehicles2.php" method="post">
      <label for="registration_number">Reg no:</label>
      <input type="text" name="reg_number" placeholder="Registration No" id="reg_no"> <br>
      <label for="brand">Brand:</label>
      <input type="text" name="brand" placeholder="Brand" id="Brand"><br>
      <label for="category">Catergory:</label><br>
      <label for="car">Car</label>
      <input type="radio" name="category" placeholder="Car" id="car" value="car"><br>
      <label for="truck">Truck</label>
      <input type="radio" name="category" placeholder="Car" id="truck" value="truck"><br>
      <label for="description">Description: </label>
      <input type="text" name="description" placeholder="Description" id="description"><br>
      <label for="dailyrate">Daily Rate: </label>
      <input type="number" name="dailyrate" placeholder="Daily Rate" id="dailyrate" step="0.01"><br>
      <input type="submit">
   </form>

   <?php
      $regnumber = $_POST['reg_number'];
      $cat = $_POST['category'];
      $brand = $_POST['brand'];
      $desc = $_POST['description'];
      $dailyrate = $_POST['dailyrate'];

      try{
         $sth=$db->prepare("INSERT INTO VEHICLES VALUES(:regnum, :cat, :brand, :descr, :dailyr)");
         $sth->bindParam(':regnum', $regnumber, PDO::PARAM_STR, 10);
         $sth->bindParam(':cat', $cat, PDO::PARAM_STR, 10);
         $sth->bindParam(':brand', $brand, PDO::PARAM_STR, 10);
         $sth->bindParam(':descr', $desc, PDO::PARAM_STR, 10);
         $sth->bindParam(':dailyr', $dailyrate, PDO::PARAM_INT, 10);
         $sth->execute();
      }
      catch (PDOException $ex){
         ?>
         <p>Sorry, a databse error occurred. Please try again.</p>
         <!--<p>(Error details: <?= $ex->getMessage() ?>)</p>-->
         <?php
      }
   ?>
</body>
</html>
