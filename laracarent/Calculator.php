<?php
class Calculator {
   public $num1;
   public $num2;
   
   public function __construct($a, $b){
      if(!is_numeric($a) && !is_numeric($b)){
         throw new Exception("Wrong value");
      }
      
      $this->num1 = $a;
      $this->num2 = $b;
   }

   public function add(){
      return $this->num1+$this->num2;
   }

   public function div(){
      if($this->num2 == 0){
         throw new Exception("Can not divide by zero");
      }

      return $this->num1 / $this->num2;
   }
}

?>   

