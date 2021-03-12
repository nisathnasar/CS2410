<!DOCTYPE html>
<html lang="en">
<head>
   <title>Account {{$account->id}}</title>
</head>
<body>
   <h1>Account {{$account->accountno}}</h1>
   <ul>
      <li>Balance: {{$account->balance}}</li>
      <li>Interest: {{$account->interest}}</li>
   </ul>
</body>
</html>