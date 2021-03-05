<?php

include_once("model/account.php");

class Model {

    private $server;
    private $dbname;
    private $username;
    private $password;
    public $pdo;
	# define the constructor which has four arguments for $server, $dbname, $username, $password. 
	# The $pdo field should be assigned as null  
	function __construct($server, $dbname, $username, $password) {
		$this->server=$server;
		$this->dbname=$dbname;
		$this->username=$username;
		$this->password=$password;
		$this->pdo=null;
	}
	
   #Define a Connect() function to create the $pdo as a PDO object based on the four fields $server, $dbname, $username, $password. 
	#Using the try/catch structure to handle the database connection error
	function connect(){
		$this->pdo = new PDO("mysql:dbname=".$this->dbname."; host=localhost;", $this->username, $this->password);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//debug
		print "debug: Connected to db............................................";
		//print $this->getAccountById(100)->__get("balance"); //this queries the account and prints the balance
	}
    

   #method to get an account by id, returns an account object
	#it querys database and create an object account if the id exists in database; 
	#return null otherwise
	public function getAccountById($id) {
		if($this->pdo != null){
			$rows=$this->pdo->query("SELECT * FROM savings");
			$balance = null;
			foreach ($rows as $row){
				if($row["id"] == $id){
					$balance = $row["balance"];
				}
			}
			return $resultAcc = new Account($id, $balance);
		}
		else return null;
	}

	#method to withdraw money from account
	#returns the new balance after withdraw amount from account; return null if failure
	#it update balance of user id in the database
	#should check whether amount is less than or equal to current balance
   public function withdraw($id, $amount) {
		$rows=$this->pdo->query("SELECT * FROM savings");
		$balance = null;
		foreach ($rows as $row){
			if($row["id"] == $id){
				$balance = $row["balance"];
			}
		}
		if($amount <= $balance){
			print "Debug: you don't have enough balance > Throwing null.";
			return null;
		}
		$balance-=$amount;
		$sth=$this->pdo->prepare("UPDATE savings SET(balance=:balance) WHERE(id=:id)");
      $sth->bindParam(':id', $id );
      $sth->bindParam(':balance', $balance);
		$sth->execute();
		return $balance;
   }
	
	
	#method to deposit amount to account id
	#returns the new balance after depositing amount to account; return null if failure
	#it update balance of user id in the database
	public function deposit($id, $amount) {
		$rows=$this->pdo->query("SELECT * FROM savings");
		$balance = null;
		foreach ($rows as $row){
			if($row["id"] == $id){
				$balance = $row["balance"];
			}
		}
		$balance+=$amount;
		$sth=$this->pdo->prepare("UPDATE savings SET(balance=:balance) WHERE(id=:id)");
      $sth->bindParam(':id', $id );
      $sth->bindParam(':balance', $balance);
		$sth->execute();
		return $balance;
	}
}
?>