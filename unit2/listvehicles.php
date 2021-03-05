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
   
   <table>
      <tr>
         <th>Reg_no</th><th>Category</th><th>Brand</th><th>Dailyrate</th><th>Description</th>
      </tr>
      <?php 
         foreach ($rows as $row){
      ?>   
            <tr>
               <td><?= $row["reg_no"] ?></td> 
               <td><?= $row["category"] ?></td>
               <td><?= $row["brand"] ?></td>
               <td><?= $row["description"] ?></td>
               <td><?= $row["dailyrate"] ?></td>
            </tr>
      <?php
      }
      ?>
   </table>
</body>
</html>

