<?php
if (isset($_POST["balance"])) {
#Use the "id" from the form input and Get balance value of this id into $account
#you should call the model method call the Model's getAccountById() method 



 if ($account != null) {
  $balance = $account->balance;
  //Display balance
    echo "<b><h3>Your balance is: &pound; $balance</h3></b>";
 }
 else {
    echo "<p>Sorry, there is an error in showing your balance. Make sure to input a valid ID.</p>";
 }
}
//display the form
?>

<h1>Balance</h1>
<form method="post" action="">
<div>
        Please enter the account ID<input type="text" name="id"/>
        <input type="submit" name="balance" value="balance">
</div>
</form>

