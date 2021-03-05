<?php
   $var1 = $_GET["firstn"];
   $var2 = $_GET["secondn"];

   if($var1!=0 && $var2!=0 && (isset($var1)) && (isset($var2) && !empty($var1) && !empty($var2)) && is_numeric($var1) && is_numeric($var2)){
      echo "Your first input: " . $var1 . "<br>";
      echo "Your second input: " . $var2 . "<br>";
      echo "Addition Result: " . $var1+$var2 . "<br>";
      echo "Deduction Result: " . $var1-$var2 . "<br>";
      echo "Multiplication Result: " . $var1*$var2 . "<br>";
      echo "Division Result: " . $var1/$var2 . "<br>";
   }else{
      print("Error, please check your numbers");
   }
?>

