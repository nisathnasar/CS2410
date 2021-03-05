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
      include 'connectdb.php';
   ?>
   <form action="addvehicles.php" method="post">
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
      <input type="number" name="dailyrate" placeholder="Daily Rate" id="dailyrate"><br>
      <input type="submit">
   </form>

   <?php
      $regnumber = $db->quote( $_POST['reg_number']);
      $cat = $db->quote( $_POST['category']);
      $brand = $db->quote( $_POST['brand']);
      $desc = $db->quote( $_POST['description']);
      $dailyrate = $_POST['dailyrate'];

      try{
         $db->exec("INSERT INTO vehicles VALUES($regnumber, $cat, $brand, $desc, $dailyrate)");
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










