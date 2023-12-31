<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Example</title>
</head>
<body>
    <form action="">
        @csrf
        @foreach($cat as $cat)
        <label for="">{{$cat->catagory_name}}</label>
        <input type="text" name="{{$cat->catagory_name}}">
        <br>
        @endforeach

    </form>
</body>
</html>