<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<form action="{{url('add-multiple-data')}}" method="POST">
@csrf
<label>name</label>  <input type="text" name="name">  <label>number</label> <input type="number" name="number"> <br>
<label>name</label>  <input type="text" name="name">   <label>number</label> <input type="number" name="number"> <br>
<label>name</label>   <input type="text" name="name">   <label>number</label> <input type="number" name="number"> <br>
<label>name</label>   <input type="text" name="name">   <label>number</label> <input type="number" name="number"> <br>
<label>name</label>   <input type="text" name="name">   <label>number</label> <input type="number" name="number"> <br>

<input type="submit" value="submit">
</form>
</body>
</html>