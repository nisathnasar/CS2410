<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>
<body>
   <table>
      <thead>
         <tr>
            <th>id</th>
            <th>Account no</th>
            <th>Type</th>
            <th>balance</th>
            <th>interest</th>
         </tr>
      </thead>
      <tbody>
      @foreach($accounts as $account)
      <tr>
         <td>{{$account->id}}</td>
         <td>{{$account->accountno}}</td>
         <td>{{$account->type}}</td>
         <td>{{$account->balance}}</td>
         <td>{{$account->interest}}</td>
      </tr>
      @endforeach
   </tbody>   
   </table>
   
</body>
</html>

