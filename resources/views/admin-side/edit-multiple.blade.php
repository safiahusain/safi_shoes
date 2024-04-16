<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>



    
@foreach($multiple as $multiple)
<form action="{{url('update-multiple-data',$multiple->id)}}" method="POST">

@csrf
@method('PUT')

<label for="">name</label><input type="text" name=name[] value="{{$multiple->name}}">  <label for="">number</label><input type="number" name=number[] value="{{$multiple->number}}"> <br>
@endforeach
<input type="submit" value="submit">

</form>
</body>
</html>