<?php

include_once("model/account.php");

class Model {

    private $server;
    private $dbname;
    private $username;
    private $password;
    private $pdo;
	# define the constructor which has four arguments for $server, $dbname, $username, $password. 
	# The $pdo field should be assigned as null  

	
	
	
	
    #Define a Connect() function to create the $pdo as a PDO object based on the four fields $server, $dbname, $username, $password. 
	#Using the try/catch structure to handle the database connection error
  
  
  
  
  
  

    #method to get an account by id, returns an account object
	#it querys database and create an object account if the id exists in database; 
	#return null otherwise
    public function getAccountById($id) {
		

		
	}

	#method to withdraw money from account
	#returns the new balance after withdraw amount from account; return null if failure
	#it update balance of user id in the database
	#should check whether amount is less than or equal to current balance
    public function withdraw($id, $amount) {
		
		
    }
	
	
	#method to deposit amount to account id
	#returns the new balance after depositing amount to account; return null if failure
	#it update balance of user id in the database
    public function deposit($id, $amount) {
		
      
	}
}
?>