<!DOCTYPE html>
<html>
<head>
    <title>Task</title>
</head>
<body>
    <h1>Subject : {{ $subject }}</h1>
    <h3>Message : {{ $data['message'] }}</h3>
    <img src="{{URL::asset('/image/'.$data['image'])}}" alt="Pic" height="100" width="100" />
   
    <p>Thank you</p>
</body>
</html>