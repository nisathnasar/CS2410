<?php
include 'Calculator.php';
include 'PHPUnit';

class CalculatorTest extends PHPUnit\Framework\TestCase{

   public function testAdd(){
      $c = new Calculator(1, 7);
      PHPUnit\Framework\Assert::assertEquals(8, $c->add());
   }

   public function testDiv(){
      $c = new Calculator(10, 5);
      PHPUnit\Framework\Assert::assertEquals(2, $c->div());

      $c2 = new Calculator(10, 0);
      
      try{
         $c2->div();
      }
      catch(Exception $e){
         echo "Error Message: " . $e->getMessage();
      }
         
   }

}
?>